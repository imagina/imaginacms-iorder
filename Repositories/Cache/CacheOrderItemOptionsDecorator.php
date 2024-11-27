<?php

namespace Modules\Iorder\Repositories\Cache;

use Modules\Iorder\Repositories\OrderItemOptionsRepository;
use Modules\Core\Icrud\Repositories\Cache\BaseCacheCrudDecorator;

class CacheOrderItemOptionsDecorator extends BaseCacheCrudDecorator implements OrderItemOptionsRepository
{
    public function __construct(OrderItemOptionsRepository $orderitemoptions)
    {
        parent::__construct();
        $this->entityName = 'iorder.orderitemoptions';
        $this->repository = $orderitemoptions;
    }
}
