<?php

namespace Modules\Iorder\Http\Controllers\Api;

use Modules\Core\Icrud\Controllers\BaseCrudController;
//Model
use Modules\Iorder\Entities\Supply;
use Modules\Iorder\Repositories\SupplyRepository;

class SupplyApiController extends BaseCrudController
{
  public $model;
  public $modelRepository;

  public function __construct(Supply $model, SupplyRepository $modelRepository)
  {
    $this->model = $model;
    $this->modelRepository = $modelRepository;
  }
}
