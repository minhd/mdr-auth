<?php

namespace Tests;

use Illuminate\Database\QueryException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;

class MySQLTestCase extends TestCase
{
    use RefreshDatabase;

    public function setUp()
    {
        parent::setUp();

        $mysqlDB = config('database.connections.mysql_testing.database');
        try {
            $query = "SELECT SCHEMA_NAME FROM INFORMATION_SCHEMA.SCHEMATA WHERE SCHEMA_NAME =  ?";
            DB::connection('mysql_testing')
                ->select($query, [$mysqlDB]);
        } catch (QueryException $e) {
            $this->markTestSkipped("Database $mysqlDB does not exist for testing. Skipping tests");
        }

        Config::set('database.default', 'mysql_testing');
        Artisan::call('migrate:fresh');
    }
}