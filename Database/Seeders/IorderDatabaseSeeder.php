<?php

namespace Modules\Iorder\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\Isite\Jobs\ProcessSeeds;

class IorderDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
      Model::unguard();
      ProcessSeeds::dispatch([
        'baseClass' => "\Modules\Iorder\Database\Seeders",
        'seeds' => ['FillCustomCreatedAtSeeder'],
      ]);
    }
}
