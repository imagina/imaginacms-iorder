<?php

namespace Modules\Iorder\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Modules\Iorder\Repositories\SupplyRepository;
use Modules\Iorder\Entities\Status;
use Carbon\Carbon;

class CheckPendingOrdersJob implements ShouldQueue
{
  use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

  public $supplyRepository;
  public $hoursCheckLimit;

  /**
   * Create a new job instance.
   *
   * @return void
   */
  public function __construct($hours)
  {
    $this->supplyRepository = app(SupplyRepository::class);
    $this->hoursCheckLimit = $hours ?? 0;
  }

  /**
   * Execute the job.
   *
   * @return void
   */
  public function handle()
  {
    \Log::info('IOrder: Jobs|CheckPendingOrdersJob');
    $userIds = setting("iorder::usersToNotify");

    if (isset($userIds)) {
      $userIds = json_decode($userIds);
    }

    if (count($userIds) > 0) {
      $params = [
        'filter' => [
          'id' => $userIds
        ]
      ];

      $users = app("Modules\Iprofile\Repositories\UserApiRepository")->getItemsBy(json_decode(json_encode($params)));
      $data = ['id' => $userIds, 'email' => $users->pluck('email')->unique()->toArray()];

      $this->processPendingSupplies($data);
      $this->processModifiedSupplies($data);
    }

    $this->processSupplierNotifications();
  }

  /**
   * Process pending supplies and notify the administrator.
   */
  private function processPendingSupplies($data)
  {
    $pendingSupplies = $this->getSuppliesByStatus(Status::SUPPLY_PENDING, $this->hoursCheckLimit);
    $orderIds = $pendingSupplies->pluck('item.order_id')->unique()->toArray();

    if (!empty($orderIds)) {
      $countOrders = count($orderIds);
      $this->notifyUsers(
        trans("iorder::supplies.title.adminOrderRemind", ['count' => $countOrders]),
        trans("iorder::supplies.messages.adminOrderRemind", ['count' => $countOrders]),
        '/iadmin/#/orders/orders/index?order.orders=%7B"statusId":"201"%7D',
        $data['email'],
        $data['id'],
        'Job|PendingSupplies'
      );
    }
  }

  /**
   * Process modified supplies and notify the administrator.
   */
  private function processModifiedSupplies($data)
  {
    $modifiedSupplies = $this->getSuppliesByStatus(Status::SUPPLY_MODIFIED);
    $orderIds = $modifiedSupplies->pluck('item.order_id')->unique()->toArray();

    if (!empty($orderIds)) {
      $countModified = count($orderIds);
      $this->notifyUsers(
        trans("iorder::supplies.title.checkOrder", ['count' => $countModified]),
        trans("iorder::supplies.messages.checkOrder", ['count' => $countModified]),
        '/iadmin/#/orders/orders/index?order.orders=%7B"statusId":"204"%7D',
        $data['email'],
        $data['id'],
        'Job|ModifiedSupplies'
      );
    }
  }

  /**
   * Process supplier notifications for pending supplies.
   */
  private function processSupplierNotifications()
  {
    $pendingSupplies = $this->getSuppliesByStatus(Status::SUPPLY_PENDING, $this->hoursCheckLimit);
    $supplierIds = $pendingSupplies->pluck('supplier_id')->unique()->toArray();

    foreach ($supplierIds as $supplierId) {
      $filteredSupplies = $pendingSupplies->where('supplier_id', $supplierId);
      $supply = $filteredSupplies->first();
      $orderIds = $filteredSupplies->pluck('item.order_id')->unique()->toArray();
      if (!empty($orderIds)) {
        $countOrderIds = count($orderIds);
        $this->notifyUsers(
          trans("iorder::supplies.title.orderRemind", ['count' => $countOrderIds]),
          trans("iorder::supplies.messages.orderRemind", ['count' => $countOrderIds]),
          '/iadmin/#/orders/supplies/index?order.supplies=%7B"statusId":"301"%7D',
          [$supply->supplier->email],
          [$supplierId],
          'Job|Supplies'
        );
      }
    }
  }

  /**
   * Retrieve supplies filtered by status and time limit (optional).
   *
   * @param int $statusId
   * @param int|null $hoursLimit
   * @return Collection
   */
  private function getSuppliesByStatus($statusId, $hoursLimit = null)
  {
    $params = [
      'include' => ['item', 'supplier'],
      'filter' => [
        'status_id' => $statusId
      ]
    ];

    if ($hoursLimit) {
      $params['filter']['created_at'] = [
        'where' => 'date',
        'operator' => '<=',
        'value' => Carbon::now()->subHours($hoursLimit)
      ];
    }

    return $this->supplyRepository->getItemsBy(json_decode(json_encode($params)));
  }

  /**
   * Send notification to the users.
   */
  private function notifyUsers($title, $msg, $url = '', $emails = [], $ids = [], $source = 'Admin')
  {
    $notification = app("Modules\Notification\Services\Inotification");
    $notification->to([
      'email' => $emails ?? [],
      'broadcast' => $ids ?? []
    ])->push([
      "title" => $title,
      "message" => $msg,
      "setting" => ["saveInDatabase" => 1],
      "link" => url($url),
      "source" => $source
    ]);
  }
}
