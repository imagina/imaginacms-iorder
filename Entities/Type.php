<?php

namespace Modules\Iorder\Entities;

use Modules\Core\Icrud\Entities\CrudStaticModel;

class Type extends CrudStaticModel
{
  const SHOP = 1;
  const SUPPLY = 2;

  public function __construct()
  {
    $this->records = [
      self::SHOP => ['title' => trans('iorder::type.shop'), 'id' => self::SHOP],
      self::SUPPLY => ['title' => trans('iorder::type.supply'), 'id' => self::SUPPLY]
    ];
  }
}
