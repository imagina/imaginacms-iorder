<?php

namespace Modules\Iorder\Entities;

use Astrotomic\Translatable\Translatable;
use Modules\Core\Icrud\Entities\CrudModel;

class OrderItem extends CrudModel
{
  use Translatable;

  protected $table = 'iorder__orderitems';
  public $transformer = 'Modules\Iorder\Transformers\OrderItemTransformer';
  public $repository = 'Modules\Iorder\Repositories\OrderItemRepository';
  public $requestValidation = [
      'create' => 'Modules\Iorder\Http\Requests\CreateOrderItemRequest',
      'update' => 'Modules\Iorder\Http\Requests\UpdateOrderItemRequest',
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
  public $translatedAttributes = [];
  protected $fillable = [
    'order_id',
    'entity_type',
    'entity_id',
    'quantity',
    'price',
    'total',
    'options',
    'discount',
    'title',
    'extra_data'
  ];
}
