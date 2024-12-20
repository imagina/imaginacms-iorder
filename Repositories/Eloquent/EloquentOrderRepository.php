<?php

namespace Modules\Iorder\Repositories\Eloquent;

use Modules\Iorder\Entities\Status;
use Modules\Iorder\Entities\Type;
use Modules\Iorder\Repositories\OrderRepository;
use Modules\Core\Icrud\Repositories\Eloquent\EloquentCrudRepository;

class EloquentOrderRepository extends EloquentCrudRepository implements OrderRepository
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

    if (!isset($params->permissions['iorder.orders.index-all']) ||
      (isset($params->permissions['iorder.orders.index-all']) &&
        !$params->permissions['iorder.orders.index-all'])) {
      $user = $params->user ?? null;

      if (isset($user->id)) {
        $query = $query->whereHas('items.suppliers', function ($query) use ($user) {
          $query->where('supplier_id', $user->id);
        });
      }
    }
  }

  public function beforeUpdate(&$data)
  {
    $model = $this->getItem($data['id'], ['include' => ['items']]);

    if ($model->type_id != Type::SUPPLY
        && !in_array($data['status_id'], [Status::ORDER_INVOICED])) {
      return; // Early return if status is not relevant
    }

    //Ignore other status when is supply type
    if (in_array($model->status_id, [Status::ORDER_INVOICED])) {
      $tmpData = $data;

      $data = [
        'id' => $tmpData['id']
      ];
      return;
    }

    $status = Status::ITEM_INVOICED;
    $items = $model->items;

    if (isset($items)) {
      $firstItem = $items->first();
      $repositoryItem = app($firstItem->repository);

      foreach ($items as $item) {
        if($item->status_id != Status::ITEM_INVOICED) {
          $repositoryItem->updateBy($item->id, ['status_id' => $status, 'automatic' => 0]);
        }
      }

      if(isset($data['items'])) unset($data['items']);
    }
  }
}
