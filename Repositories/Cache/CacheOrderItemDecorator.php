<?php

namespace Modules\Iorder\Repositories\Cache;

use Modules\Iorder\Repositories\OrderItemRepository;
use Modules\Core\Icrud\Repositories\Cache\BaseCacheCrudDecorator;

class CacheOrderItemDecorator extends BaseCacheCrudDecorator implements OrderItemRepository
{
    public function __construct(OrderItemRepository $orderitem)
    {
        parent::__construct();
        $this->entityName = 'iorder.orderitems';
        $this->repository = $orderitem;
    }
}
