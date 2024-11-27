<?php

namespace Modules\Iorder\Http\Controllers\Api;

use Modules\Core\Icrud\Controllers\BaseCrudController;
//Model
use Modules\Iorder\Entities\OrderItemOptions;
use Modules\Iorder\Repositories\OrderItemOptionsRepository;

class OrderItemOptionsApiController extends BaseCrudController
{
  public $model;
  public $modelRepository;

  public function __construct(OrderItemOptions $model, OrderItemOptionsRepository $modelRepository)
  {
    $this->model = $model;
    $this->modelRepository = $modelRepository;
  }
}
