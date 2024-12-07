<?php

namespace Modules\Iorder\Http\Controllers\Api;

use Modules\Core\Icrud\Controllers\BaseCrudController;
//Model
use Modules\Iorder\Entities\Item;
use Modules\Iorder\Repositories\ItemRepository;

class ItemApiController extends BaseCrudController
{
  public $model;
  public $modelRepository;

  public function __construct(Item $model, ItemRepository $modelRepository)
  {
    $this->model = $model;
    $this->modelRepository = $modelRepository;
  }
}
