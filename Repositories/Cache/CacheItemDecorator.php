<?php

namespace Modules\Iorder\Repositories\Cache;

use Modules\Iorder\Repositories\ItemRepository;
use Modules\Core\Icrud\Repositories\Cache\BaseCacheCrudDecorator;

class CacheItemDecorator extends BaseCacheCrudDecorator implements ItemRepository
{
    public function __construct(ItemRepository $item)
    {
        parent::__construct();
        $this->entityName = 'iorder.items';
        $this->repository = $item;
    }
}
