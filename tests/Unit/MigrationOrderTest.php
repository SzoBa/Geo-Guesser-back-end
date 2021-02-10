<?php

namespace Tests\Unit;

use Illuminate\Support\Facades\Artisan;
//use PHPUnit\Framework\TestCase;
use Tests\TestCase;


class MigrationOrderTest extends TestCase
{

    public function testMigrateAllOrderedCommandExists(): void
    {
        $this->assertTrue(class_exists(\App\Console\Commands\MigrationOrder::class));
    }

    public function testMigrateAllOrderedCommandMultipleExecutionFails(): void
    {

        Artisan::call('migrate:all:ordered');
        $this->artisan('migrate:all:ordered')
            ->expectsOutput('Failed to migrate!');
    }
}
