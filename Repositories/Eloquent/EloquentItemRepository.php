<?php

namespace Modules\Iorder\Repositories\Eloquent;

use Modules\Iorder\Entities\Status;
use Modules\Iorder\Entities\Type;
use Modules\Iorder\Repositories\ItemRepository;
use Modules\Core\Icrud\Repositories\Eloquent\EloquentCrudRepository;

class EloquentItemRepository extends EloquentCrudRepository implements ItemRepository
{
  /**
   * Filter names to replace
   * @var array
   */
  protected $replaceFilters = [];

  /**
   * Relation names to replace
   * @var array
   */
  protected $replaceSyncModelRelations = [];

  /**
   * Attribute to define default relations
   * all apply to index and show
   * index apply in the getItemsBy
   * show apply in the getItem
   * @var array
   */
  protected $with = [/*all => [] ,index => [],show => []*/];

  /**
   * Filter query
   *
   * @param $query
   * @param $filter
   * @param $params
   * @return mixed
   */
  public function filterQuery($query, $filter, $params)
  {

    /**
     * Note: Add filter name to replaceFilters attribute before replace it
     *
     * Example filter Query
     * if (isset($filter->status)) $query->where('status', $filter->status);
     *
     */

    //Response
    return $query;
  }

  /**
   * Method to sync Model Relations
   *
   * @param $model ,$data
   * @return $model
   */
  public function syncModelRelations($model, $data)
  {
    //Get model relations data from attribute of model
    $modelRelationsData = ($model->modelRelations ?? []);

    /**
     * Note: Add relation name to replaceSyncModelRelations attribute before replace it
     *
     * Example to sync relations
     * if (array_key_exists(<relationName>, $data)){
     *    $model->setRelation(<relationName>, $model-><relationName>()->sync($data[<relationName>]));
     * }
     *
     */

    //Response
    return $model;
  }

  public function beforeCreate(&$data)
  {
    // Ensure 'entity_type' and 'entity_id' are provided
    if (!isset($data['entity_type'], $data['entity_id'])) {
      throw new \Exception('Insufficient data to process the entity.'); // Prevent creation
    }

    // Dynamically resolve the entity class
    $entityClass = app($data['entity_type']);
    if (!isset($entityClass)) {
      throw new \Exception('The specified class does not exist.'); // Prevent creation
    }

    // Resolve the repository for the entity
    $repository = app($entityClass->repository);
    $params = [];

    // Include specific relationships if applicable
    if ($entityClass->repository === 'Modules\\Iproduct\\Repositories\\ProductRepository') {
      $params['include'] = 'prices,files';
    }

    // Fetch the associated model
    $model = $repository->getItem($data['entity_id'], $params);

    // Check if the model exists
    if (!$model) {
      throw new \Exception('The associated model does not exist.'); // Prevent creation
    }

    // Process quantity and price
    $quantity = $data['quantity'] ?? 0;
    $price = 0;

    if ($entityClass->repository === 'Modules\\Iproduct\\Repositories\\ProductRepository') {
      $model->mediaFiles = $model->mediaFiles();
      unset($model->files);
      $defaultZone = $model->getDefaultZone();
      if ($defaultZone) {
        $defaultPrice = $model->prices->where('zone_id', $defaultZone->id)->first();
        $price = $defaultPrice->value ?? 0;
      }

      // Set attributes for the current model
      $data['price'] = $price;
      $data['total'] = $quantity * $price;
      $data['extra_data'] = $model->toArray();
      $data['title'] = $model->title ?? $model->name ?? null;

      $suppliers = $data['suppliers'] ?? [];

      foreach ($suppliers as $index => $supplier) {
        $supplier['quantity'] = $quantity;
        $supplier['price'] = $price;
        $supplier['total'] = $quantity * $price;
        $data['suppliers'][$index] = $supplier;
      }
    }
  }

  public function beforeUpdate(&$data)
  {
    $model = $this->getItem($data['id'], ['include' => ['order.items', 'suppliers']]);
    $order = $model->order;

    if (isset($data['automatic']) || ($order->type_id == Type::SUPPLY
      && !in_array($data['status_id'], [Status::ITEM_COMPLETED, Status::ITEM_PENDING_REVIEW, Status::ITEM_CANCELLED]))) {
      return; // Early return if status is not relevant
    }

    //Ignore other status when is supply type
    if (!in_array($order->status_id, [Status::ORDER_PENDING, Status::ORDER_IN_PROGRESS])) {
      $tmpData = $data;

      $data = [
        'id' => $tmpData['id']
      ];
      return;
    }
    $supplies = $model->suppliers;
    $status = $this->determineStatus($data, $order, $supplies);
    $orderStatus = $status['order'] ?? null;
    $suppliesStatus = $status['supply'] ?? null;

    if (isset($suppliesStatus) && !empty($suppliesStatus)) {
      $firstSuply = $supplies->first();
      $repositorySupplies = app($firstSuply->repository);
      $allStatus = $suppliesStatus['all'] ?? null;

      if(isset($allStatus)) {
        foreach ($supplies as $supply) {
          $status_id = $allStatus;
          if (in_array($supply->status_id, [Status::SUPPLY_MODIFIED, Status::SUPPLY_PENDING])) {
            if($status_id == Status::SUPPLY_ACCEPTED &&
              $supply->status_id == Status::SUPPLY_PENDING) {
              $status_id = Status::SUPPLY_REFUSED;
            }

            $repositorySupplies->updateBy($supply->id, ['status_id' => $status_id, 'automatic' => 0]);
          }
        }
      }

      if(isset($data['suppliers'])) unset($data['suppliers']);
    }

    if (isset($orderStatus)) {
      $repositoryOrders = app($order->repository);
      $repositoryOrders->updateBy($order->id, ['status_id' => $orderStatus, 'automatic' => 0]);
      if(isset($data['order'])) unset($data['order']);
    }
  }

  private function determineStatus($data, $order, $supplies)
  {
    $orderStatus = null;
    $supplyStatus = [];
    $response = [];

    switch ($data['status_id']) {
      case Status::ITEM_COMPLETED:
        $changeStatus = $this->checkItemsStatus($data['id'], $order, Status::ITEM_COMPLETED);

        if ($changeStatus) $orderStatus = Status::ORDER_IN_PROGRESS;
        else $orderStatus = Status::ORDER_APPROVED;

        //TODO: Change this for specific supplies, because its necesary reject the other supplies or analyze the logic
        $supplyStatus['all'] = Status::SUPPLY_ACCEPTED;
        break;
      case Status::ITEM_CANCELLED:
        $changeStatus = $this->checkItemsStatus($data['id'], $order, Status::ITEM_CANCELLED);

        if ($changeStatus) $orderStatus = Status::ORDER_IN_PROGRESS;
        else $orderStatus = Status::ORDER_CANCELLED;
        $supplyStatus['all'] = Status::SUPPLY_REFUSED;
        break;
      case Status::ITEM_PENDING_REVIEW:
        $orderStatus = Status::ORDER_IN_PROGRESS;
        break;
    }
    if (isset($orderStatus)) $response['order'] = $orderStatus;
    if (!empty($supplyStatus)) $response['supply'] = $supplyStatus;

    return $response;
  }

  private function checkItemsStatus($currentModelId, $order, $statusId)
  {
    $items = $order->items
      ->where('status_id', '!=', $statusId)
      ->where('id', '!=', $currentModelId)
      ->first();

    return isset($items);
  }

  private function checkSuppliesStatus($currentModelId, $order, $statusId)
  {
    $items = $order->items
      ->where('status_id', '!=', $statusId)
      ->where('id', '!=', $currentModelId)
      ->first();

    return isset($items);
  }
}
