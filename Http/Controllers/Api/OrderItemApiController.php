<?php

namespace Modules\Iorder\Http\Controllers\Api;

use Modules\Core\Icrud\Controllers\BaseCrudController;
//Model
use Modules\Iorder\Entities\OrderItem;
use Modules\Iorder\Repositories\OrderItemRepository;

class OrderItemApiController extends BaseCrudController
{
  public $model;
  public $modelRepository;

  public function __construct(OrderItem $model, OrderItemRepository $modelRepository)
  {
    $this->model = $model;
    $this->modelRepository = $modelRepository;
  }
}
