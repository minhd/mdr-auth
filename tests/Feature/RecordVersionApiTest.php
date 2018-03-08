<?php

namespace Tests\Feature;

use MinhD\Repository\Record;
use MinhD\Repository\RecordVersion;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class RecordVersionApiTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    function it_shows_all_versions_for_a_record()
    {
        $record = create(Record::class);
        $record->versions()->create([
            'status' => RecordVersion::STATUS_CURRENT,
            'data' => 'current_ver'
        ]);
        $record->versions()->create([
            'status' => RecordVersion::STATUS_SUPERSEDED,
            'data' => 'prev_ver'
        ]);

        $this->getJson(route('records.recordsversions.index', [
            'record' => $record->id
        ]))->assertStatus(200);
    }
}
