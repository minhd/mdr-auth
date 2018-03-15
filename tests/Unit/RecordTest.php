<?php

namespace Tests\Unit;

use MinhD\Repository\Record;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class RecordTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    function record_must_have_an_owner_via_datasource()
    {
        $record = create(Record::class);
        $this->assertEquals($record->datasource->owner, $record->owner);
    }
}
