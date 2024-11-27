<?php

namespace Modules\Iorder\Repositories\Cache;

use Modules\Iorder\Repositories\OrderRepository;
use Modules\Core\Icrud\Repositories\Cache\BaseCacheCrudDecorator;

class CacheOrderDecorator extends BaseCacheCrudDecorator implements OrderRepository
{
    public function __construct(OrderRepository $order)
    {
        parent::__construct();
        $this->entityName = 'iorder.orders';
        $this->repository = $order;
    }
}
