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
  const ORDER_INVOICED = 107;

  // Item statuses
  const ITEM_PENDING = 201;
  const ITEM_COMPLETED = 202;
  const ITEM_CANCELLED = 203;
  const ITEM_PENDING_REVIEW = 204;
  const ITEM_SHIPPED = 205;
  const ITEM_INVOICED = 206;

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
        'icon' => 'fa-solid fa-hourglass-start',
        'color' => '#1378D6',
        'id' => self::ORDER_PENDING,
        'groupId' => self::GROUP_ORDER,
      ],
      self::ORDER_IN_PROGRESS => [
        'title' => trans('iorder::status.order_in_progress'),
        'icon' => 'fa-solid fa-spinner',
        'color' => '#FFA500',
        'id' => self::ORDER_IN_PROGRESS,
        'groupId' => self::GROUP_ORDER,
      ],
      self::ORDER_CANCELLED => [
        'title' => trans('iorder::status.order_cancelled'),
        'icon' => 'fa-solid fa-circle-xmark',
        'color' => '#E52E39',
        'id' => self::ORDER_CANCELLED,
        'groupId' => self::GROUP_ORDER,
      ],
      self::ORDER_APPROVED => [
        'title' => trans('iorder::status.order_approved'),
        'icon' => 'fa-solid fa-circle-check',
        'color' => '#45CD63',
        'id' => self::ORDER_APPROVED,
        'groupId' => self::GROUP_ORDER,
      ],
      self::ORDER_SHIPPED => [
        'title' => trans('iorder::status.order_shipped'),
        'icon' => 'fa-solid fa-truck',
        'color' => '#FFA500',
        'id' => self::ORDER_SHIPPED,
        'groupId' => self::GROUP_ORDER,
      ],
      self::ORDER_COMPLETED => [
        'title' => trans('iorder::status.order_completed'),
        'icon' => 'fa-solid fa-circle-check',
        'color' => '#45CD63',
        'id' => self::ORDER_COMPLETED,
        'groupId' => self::GROUP_ORDER,
      ],
      self::ORDER_INVOICED => [
        'title' => trans('iorder::status.order_invoiced'),
        'icon' => 'fa-solid fa-receipt',
        'color' => '#31C4E4',
        'id' => self::ORDER_INVOICED,
        'groupId' => self::GROUP_ORDER,
      ],

      // Item statuses
      self::ITEM_PENDING => [
        'title' => trans('iorder::status.item_pending'),
        'icon' => 'fa-solid fa-hourglass-start',
        'color' => '#1378D6',
        'id' => self::ITEM_PENDING,
        'groupId' => self::GROUP_ITEM,
      ],
      self::ITEM_COMPLETED => [
        'title' => trans('iorder::status.item_completed'),
        'icon' => 'fa-solid fa-circle-check',
        'color' => '#45CD63',
        'id' => self::ITEM_COMPLETED,
        'groupId' => self::GROUP_ITEM,
      ],
      self::ITEM_CANCELLED => [
        'title' => trans('iorder::status.item_cancelled'),
        'icon' => 'fa-solid fa-circle-xmark',
        'color' => '#E52E39',
        'id' => self::ITEM_CANCELLED,
        'groupId' => self::GROUP_ITEM,
      ],
      self::ITEM_PENDING_REVIEW => [
        'title' => trans('iorder::status.item_pending_review'),
        'icon' => 'fa-solid fa-eye',
        'color' => '#9A53F4',
        'id' => self::ITEM_PENDING_REVIEW,
        'groupId' => self::GROUP_ITEM,
      ],
      self::ITEM_SHIPPED => [
        'title' => trans('iorder::status.item_shipped'),
        'icon' => 'fa-solid fa-truck',
        'color' => '#FFA500',
        'id' => self::ITEM_SHIPPED,
        'groupId' => self::GROUP_ITEM,
      ],
      self::ITEM_INVOICED => [
        'title' => trans('iorder::status.item_invoiced'),
        'icon' => 'fa-solid fa-receipt',
        'color' => '#31C4E4',
        'id' => self::ITEM_INVOICED,
        'groupId' => self::GROUP_ITEM,
      ],

      // Supply statuses
      self::SUPPLY_PENDING => [
        'title' => trans('iorder::status.supply_pending'),
        'icon' => 'fa-solid fa-pen',
        'color' => '#007BFF',
        'id' => self::SUPPLY_PENDING,
        'groupId' => self::GROUP_SUPPLY,
      ],
      self::SUPPLY_ACCEPTED => [
        'title' => trans('iorder::status.supply_accepted'),
        'icon' => 'fa-solid fa-circle-check',
        'color' => '#45CD63',
        'id' => self::SUPPLY_ACCEPTED,
        'groupId' => self::GROUP_SUPPLY,
      ],
      self::SUPPLY_REFUSED => [
        'title' => trans('iorder::status.supply_refused'),
        'icon' => 'fa-solid fa-circle-xmark',
        'color' => '#E52E39',
        'id' => self::SUPPLY_REFUSED,
        'groupId' => self::GROUP_SUPPLY,
      ],
      self::SUPPLY_MODIFIED => [
        'title' => trans('iorder::status.supply_modified'),
        'icon' => 'fa-solid fa-eye',
        'color' => '#9A53F4',
        'id' => self::SUPPLY_MODIFIED,
        'groupId' => self::GROUP_SUPPLY,
      ],
      self::SUPPLY_SELECTED => [
        'title' => trans('iorder::status.supply_selected'),
        'icon' => 'fa-solid fa-check-circle',
        'color' => '#28A745',
        'id' => self::SUPPLY_SELECTED,
        'groupId' => self::GROUP_SUPPLY,
      ],
    ];
  }
}
