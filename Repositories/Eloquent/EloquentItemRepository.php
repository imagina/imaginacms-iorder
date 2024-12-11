<?php

namespace Modules\Iorder\Repositories\Eloquent;

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
      $params['include'] = 'prices';
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
      $defaultZone = $model->getDefaultZone();
      if ($defaultZone) {
        $defaultPrice = $model->prices->where('zone_id', $defaultZone->id)->first();
        $price = $defaultPrice->value ?? 0;
      }

      // Set attributes for the current model
      $data['price'] = $price;
      $data['total'] = $quantity * $price;
      $data['extra_data'] = json_encode($model->toArray());
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
}
