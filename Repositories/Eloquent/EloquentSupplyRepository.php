<?php

namespace Modules\Iorder\Repositories\Eloquent;

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
}
