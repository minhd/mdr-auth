<?php

namespace Tests\Feature;

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
        $dataSource = factory(DataSource::class)->create();
        $this->assertNotNull($dataSource->owner);
        $this->assertEquals(get_class($dataSource->owner), User::class);
    }

}
