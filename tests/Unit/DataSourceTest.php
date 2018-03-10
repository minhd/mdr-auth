<?php

namespace Tests\Unit;

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Config;
use MinhD\Repository\DataSource;
use MinhD\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class DataSourceTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    function datasource_must_have_an_owner()
    {
        $dataSource = create(DataSource::class);

        $this->assertNotNull($dataSource->owner);
        $this->assertEquals(get_class($dataSource->owner), User::class);
    }

}
