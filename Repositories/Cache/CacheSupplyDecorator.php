<?php

namespace Modules\Iorder\Repositories\Cache;

use Modules\Iorder\Repositories\SupplyRepository;
use Modules\Core\Icrud\Repositories\Cache\BaseCacheCrudDecorator;

class CacheSupplyDecorator extends BaseCacheCrudDecorator implements SupplyRepository
{
    public function __construct(SupplyRepository $supply)
    {
        parent::__construct();
        $this->entityName = 'iorder.supplies';
        $this->repository = $supply;
    }
}
