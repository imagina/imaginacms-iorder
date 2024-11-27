<?php

namespace Modules\Iorder\Entities;

use Astrotomic\Translatable\Translatable;
use Modules\Core\Icrud\Entities\CrudModel;

class Order extends CrudModel
{
  use Translatable;

  protected $table = 'iorder__orders';
  public $transformer = 'Modules\Iorder\Transformers\OrderTransformer';
  public $repository = 'Modules\Iorder\Repositories\OrderRepository';
  public $requestValidation = [
      'create' => 'Modules\Iorder\Http\Requests\CreateOrderRequest',
      'update' => 'Modules\Iorder\Http\Requests\UpdateOrderRequest',
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
    'total',
    'status_id',
    'zone',
    'customer_id',
    'customer_first_name',
    'customer_last_name',
    'customer_email',
    'customer_phone',
    'payment_name',
    'payment_country',
    'payment_city',
    'payment_province',
    'payment_zip_code',
    'payment_extra_data',
    'shipping_name',
    'shipping_customer_phone',
    'shipping_country',
    'shipping_city',
    'shipping_province',
    'shipping_address_1',
    'shipping_address_2',
    'shipping_amount',
    'shipping_extra_data',
    'currency',
    'options',
    'payment_name',
    'shipping_name',
    'type'
  ];
}
