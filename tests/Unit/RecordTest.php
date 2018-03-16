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

    /** @test */
    function it_can_be_soft_deleted()
    {
        $record = create(Record::class);
        $record->delete();
        $this->assertNull(Record::find($record->id));
        $this->assertEmpty(Record::all());
        $this->assertTrue($record->trashed());
        $this->assertNotEmpty(Record::withTrashed()->get());
        $this->assertEquals($record->id, Record::withTrashed()->first()->id);
    }
}
