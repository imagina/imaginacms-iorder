<?php

namespace Modules\Iorder\Entities;

use Modules\Core\Icrud\Entities\CrudStaticModel;

class Status extends CrudStaticModel
{
  // Status groups
  const GROUP_ORDER = 1;
  const GROUP_ITEM = 2;
  const GROUP_SUPPLY = 3;

  // Order statuses
  const ORDER_PENDING = 101;
  const ORDER_IN_PROGRESS = 102;
  const ORDER_CANCELLED = 103;
  const ORDER_APPROVED = 104;
  const ORDER_SHIPPED = 105;
  const ORDER_COMPLETED = 106;

  // Item statuses
  const ITEM_PENDING = 201;
  const ITEM_COMPLETED = 202;
  const ITEM_CANCELLED = 203;

  // Supply statuses
  const SUPPLY_PENDING = 301;
  const SUPPLY_ACCEPTED = 302;
  const SUPPLY_REFUSED = 303;
  const SUPPLY_MODIFIED = 304;
  const SUPPLY_SELECTED = 305;

  public function __construct()
  {
    $this->records = [
      // Order statuses
      self::ORDER_PENDING => [
        'title' => trans('iorder::status.order_pending'),
        'id' => self::ORDER_PENDING,
        'groupId' => self::GROUP_ORDER,
      ],
      self::ORDER_IN_PROGRESS => [
        'title' => trans('iorder::status.order_in_progress'),
        'id' => self::ORDER_IN_PROGRESS,
        'groupId' => self::GROUP_ORDER,
      ],
      self::ORDER_CANCELLED => [
        'title' => trans('iorder::status.order_cancelled'),
        'id' => self::ORDER_CANCELLED,
        'groupId' => self::GROUP_ORDER,
      ],
      self::ORDER_APPROVED => [
        'title' => trans('iorder::status.order_approved'),
        'id' => self::ORDER_APPROVED,
        'groupId' => self::GROUP_ORDER,
      ],
      self::ORDER_SHIPPED => [
        'title' => trans('iorder::status.order_shipped'),
        'id' => self::ORDER_SHIPPED,
        'groupId' => self::GROUP_ORDER,
      ],
      self::ORDER_COMPLETED => [
        'title' => trans('iorder::status.order_completed'),
        'id' => self::ORDER_COMPLETED,
        'groupId' => self::GROUP_ORDER,
      ],

      // Item statuses
      self::ITEM_PENDING => [
        'title' => trans('iorder::status.item_pending'),
        'id' => self::ITEM_PENDING,
        'groupId' => self::GROUP_ITEM,
      ],
      self::ITEM_COMPLETED => [
        'title' => trans('iorder::status.item_completed'),
        'id' => self::ITEM_COMPLETED,
        'groupId' => self::GROUP_ITEM,
      ],
      self::ITEM_CANCELLED => [
        'title' => trans('iorder::status.item_cancelled'),
        'id' => self::ITEM_CANCELLED,
        'groupId' => self::GROUP_ITEM,
      ],

      // Supply statuses
      self::SUPPLY_PENDING => [
        'title' => trans('iorder::status.supply_pending'),
        'id' => self::SUPPLY_PENDING,
        'groupId' => self::GROUP_SUPPLY,
      ],
      self::SUPPLY_ACCEPTED => [
        'title' => trans('iorder::status.supply_accepted'),
        'id' => self::SUPPLY_ACCEPTED,
        'groupId' => self::GROUP_SUPPLY,
      ],
      self::SUPPLY_REFUSED => [
        'title' => trans('iorder::status.supply_refused'),
        'id' => self::SUPPLY_REFUSED,
        'groupId' => self::GROUP_SUPPLY,
      ],
      self::SUPPLY_MODIFIED => [
        'title' => trans('iorder::status.supply_modified'),
        'id' => self::SUPPLY_MODIFIED,
        'groupId' => self::GROUP_SUPPLY,
      ],
      self::SUPPLY_SELECTED => [
        'title' => trans('iorder::status.supply_selected'),
        'id' => self::SUPPLY_SELECTED,
        'groupId' => self::GROUP_SUPPLY,
      ],
    ];
  }
}
