<?php

namespace Modules\Iorder\Http\Controllers\Api;

use Modules\Core\Icrud\Controllers\BaseCrudController;
//Model
use Modules\Iorder\Entities\Order;
use Modules\Iorder\Repositories\OrderRepository;

class OrderApiController extends BaseCrudController
{
  public $model;
  public $modelRepository;

  public function __construct(Order $model, OrderRepository $modelRepository)
  {
    $this->model = $model;
    $this->modelRepository = $modelRepository;
  }
}
