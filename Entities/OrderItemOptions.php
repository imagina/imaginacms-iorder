<?php

namespace Modules\Iorder\Entities;

use Astrotomic\Translatable\Translatable;
use Modules\Core\Icrud\Entities\CrudModel;

class OrderItemOptions extends CrudModel
{
  use Translatable;

  protected $table = 'iorder__orderitemoptions';
  public $transformer = 'Modules\Iorder\Transformers\OrderItemOptionsTransformer';
  public $repository = 'Modules\Iorder\Repositories\OrderItemOptionsRepository';
  public $requestValidation = [
      'create' => 'Modules\Iorder\Http\Requests\CreateOrderItemOptionsRequest',
      'update' => 'Modules\Iorder\Http\Requests\UpdateOrderItemOptionsRequest',
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
    'entity_type',
    'entity_id',
    'order_id',
    'order_item_id',
    'options',
    'price',
    'description',
    'value',
    'extra_data'
  ];
}
