<?php

namespace Modules\Iorder\Entities;

use Modules\Core\Icrud\Entities\CrudModel;

class Supply extends CrudModel
{
  protected $table = 'iorder__supplies';
  public $transformer = 'Modules\Iorder\Transformers\SupplyTransformer';
  public $repository = 'Modules\Iorder\Repositories\SupplyRepository';
  public $requestValidation = [
    'create' => 'Modules\Iorder\Http\Requests\CreateSupplyRequest',
    'update' => 'Modules\Iorder\Http\Requests\UpdateSupplyRequest',
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
    'item_id',
    'status_id',
    'quantity',
    'price',
    'total',
    'supplier_id',
    'comment',
    'options'
  ];

  public function getStatusAttribute()
  {
    $status = new Status();
    return $status->show($this->status_id);
  }

  public function item()
  {
    return $this->belongsTo(Item::class);
  }

  public function supplier()
  {
    $driver = config('asgard.user.config.driver');

    return $this->belongsTo("Modules\\User\\Entities\\{$driver}\\User", 'supplier_id');
  }
}
