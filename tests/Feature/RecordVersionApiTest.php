<?php

namespace Tests\Feature;

use MinhD\Repository\Record;
use MinhD\Repository\Version;
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
            'status' => Version::STATUS_CURRENT,
            'data' => 'current_ver'
        ]);
        $record->versions()->create([
            'status' => Version::STATUS_SUPERSEDED,
            'data' => 'prev_ver'
        ]);

        $this->getJson(route('records.versions.index', [
            'record' => $record->id
        ]))->assertStatus(200);
    }
}
