<?php

namespace Modules\Iorder\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Iorder\Entities\Order;
use Illuminate\Database\Eloquent\Model;

class FillCustomCreatedAtSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
      Model::unguard();

      $repository = app('Modules\Iorder\Repositories\OrderRepository');
      $orders = Order::whereNull('custom_created_at')->get();

      foreach ($orders as $order) {
        $repository->updateBy($order->id, [
          'custom_created_at' => $order->created_at
        ]);
      }
    }
}
