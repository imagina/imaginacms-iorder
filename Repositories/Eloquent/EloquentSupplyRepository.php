<?php

namespace Modules\Iorder\Repositories\Eloquent;

use Modules\Iorder\Entities\Status;
use Modules\Iorder\Repositories\SupplyRepository;
use Modules\Core\Icrud\Repositories\Eloquent\EloquentCrudRepository;

class EloquentSupplyRepository extends EloquentCrudRepository implements SupplyRepository
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

    if (isset($filter->orderId)) {
      $query = $query->whereHas('item', function ($query) use ($filter) {
        $query->where('order_id', $filter->orderId);
      });
    }


    $this->validateIndexAllPermission($query, $params);
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

  function validateIndexAllPermission(&$query, $params)
  {

    if (!isset($params->permissions['iorder.supplies.index-all']) ||
      (isset($params->permissions['iorder.supplies.index-all']) &&
        !$params->permissions['iorder.supplies.index-all'])) {
      $user = $params->user ?? null;

      if (isset($user->id)) {
        // if is salesman or salesman manager or salesman sub manager
        $query->where('supplier_id', $user->id);

      }
    }
  }

  public function beforeUpdate(&$data)
  {
    \Log::info('Pass 1' . json_encode($data));
    if (isset($data['automatic']) || !in_array($data['status_id'], [Status::SUPPLY_ACCEPTED, Status::SUPPLY_REFUSED])) {
      return; // Early return if status is not relevant
    }

    $model = $this->getItem($data['id'], ['include' => ['item.suppliers']]);
    if (!isset($data['price'])) $data['price'] = $model->price;
    if (!isset($data['quantity'])) $data['quantity'] = $model->quantity;
    $item = $model->item;

    if($item->status_id != Status::ITEM_PENDING)
    {
      $tmpData = $data;

      $data = [
        'id' => $tmpData['id']
      ];
      return;
    }

    $newItemStatus = $this->determineNewItemStatus($data, $item);

    if ($newItemStatus) {
      $repositoryItem = app($item->repository);
      $repositoryItem->updateBy($item->id, ['status_id' => $newItemStatus]);
      unset($data['item']); // Remove item data from original update
    }

  }

  private function determineNewItemStatus(&$data,$item)
  {
    switch ($data['status_id']) {
      case Status::SUPPLY_ACCEPTED:
        if ($data['price'] == $item->price && $data['quantity'] == $item->quantity) {
          return Status::ITEM_COMPLETED;
        } else {
          $data['status_id'] = Status::SUPPLY_MODIFIED;
          return Status::ITEM_PENDING_REVIEW;
        }
      case Status::SUPPLY_REFUSED:
        $suppliersWithDifferentStatus = $item->suppliers
          ->where('status_id', '!=', $data['status_id'])
          ->where('id', '!=', $data['id'])
          ->first();

        if (!$suppliersWithDifferentStatus) {
          return Status::ITEM_CANCELLED;
        }

        return null;
      default:
        return null; // Should not happen due to initial check, but good practice
    }
  }
}
