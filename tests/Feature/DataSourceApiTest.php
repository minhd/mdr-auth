<?php

namespace Tests\Feature;

use MinhD\Repository\DataSource;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class DataSourceApiTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    function it_shows_some_datasources()
    {
        factory(DataSource::class, 20)->create();
        $result = $this->getJson(route('datasources.index'));
        $result->assertStatus(200);
        $result->assertJsonCount(10);
    }

    /** @test */
    function it_shows_link_pagination_on_header()
    {
        factory(DataSource::class, 30)->create();

        // GET /
        $result = $this->getJson(route('datasources.index'));
        $result->assertStatus(200);

        // should see the next link in header
        $result->assertHeader('Link');
        $this->assertContains("next", $result->headers->get('Link'));
        $this->assertContains("last", $result->headers->get('Link'));
        $this->assertContains("first", $result->headers->get('Link'));
    }

    /** @test */
    function it_shows_previous_link_on_page_2()
    {
        factory(DataSource::class, 30)->create();

        $result = $this->getJson(route('datasources.index')."?page=2");
        $result->assertHeader('Link');
        $this->assertContains("prev", $result->headers->get('Link'));
    }
}
