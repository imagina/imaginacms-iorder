<?php

namespace Modules\Iorder\Entities;

use Modules\Core\Icrud\Entities\CrudModel;
use Modules\Notification\Traits\IsNotificable;

class Item extends CrudModel
{
  use IsNotificable;
  protected $table = 'iorder__items';
  public $transformer = 'Modules\Iorder\Transformers\ItemTransformer';
  public $repository = 'Modules\Iorder\Repositories\ItemRepository';
  public $requestValidation = [
    'create' => 'Modules\Iorder\Http\Requests\CreateItemRequest',
    'update' => 'Modules\Iorder\Http\Requests\UpdateItemRequest',
  ];
  public $modelRelations = [
    'suppliers' => [
      'relation' => 'hasMany',
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

  protected $casts = [
    'extra_data' => 'array',
    'options' => 'array'
  ];

  public function getStatusAttribute()
  {
    $status = new Status();
    return $status->show($this->status_id);
  }

  public function order()
  {
    return $this->belongsTo(Order::class);
  }

  public function suppliers()
  {
    return $this->hasMany(Supply::class);
  }

  /**
   * Make Notificable Params | to Trait
   * @param $event (created|updated|deleted)
   */
  public function isNotificableParams($event)
  {
    $response = [];
    $userId = \Auth::id() ?? null;
    $source = "iorder";
    $order = $this->order;

    if(!isset($order)) return $response;
    if($event=="updated") {
      $email = [];
      if($order->customer_email); $email[] = $order->customer_email;

      $response[$event] = [
        "title" => trans("iorder::items.title.updatedEvent",  ['id' => $this->id]),
        "message" => trans("iorder::items.messages.updatedEvent", ['id' => $this->id, 'status' => $this->status['title'] ?? '']),
        "email" => $email,
        "broadcast" => [$order->customer_id],
        "userId" => $userId,
        "source" => $source,
        "link" => url('/iadmin/#/orders/orders/index')
      ];
    }

    return $response;

  }
}
