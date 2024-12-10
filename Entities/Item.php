<?php

namespace Modules\Iorder\Entities;

use Modules\Core\Icrud\Entities\CrudModel;

class Item extends CrudModel
{
  protected $table = 'iorder__items';
  public $transformer = 'Modules\Iorder\Transformers\ItemTransformer';
  public $repository = 'Modules\Iorder\Repositories\ItemRepository';
  public $requestValidation = [
    'create' => 'Modules\Iorder\Http\Requests\CreateItemRequest',
    'update' => 'Modules\Iorder\Http\Requests\UpdateItemRequest',
  ];
  public $modelRelations = [
    'suppliers' => [
      'type' => 'updateOrCreateMany',
      'compareKeys' => ['supplier_id']
    ]
  ];
  //Instance external/internal events to dispatch with extraData
  public $dispatchesEventsWithBindings = [
    //eg. ['path' => 'path/module/event', 'extraData' => [/*...optional*/]]
    'created' => [],
    'creating' => [],
    'updated' => [],
    'updating' => [],
    'deleting' => [],
    'deleted' => []
  ];
  protected $fillable = [
    'order_id',
    'entity_type',
    'entity_id',
    'status_id',
    'quantity',
    'price',
    'total',
    'options',
    'discount',
    'title',
    'extra_data'
  ];

  public function getStatusAttribute()
  {
    $status = new Status();
    return $status->show($this->status_id);
  }

  public function order()
  {
    $this->belongsTo(Order::class);
  }

  public function suppliers()
  {
    return $this->hasMany(Supply::class);
  }
}
