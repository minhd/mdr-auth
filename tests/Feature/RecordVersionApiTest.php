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
        ]))->assertStatus(200)
            ->assertSee("current_ver")
            ->assertSee("prev_ver");
    }

    /** @test */
    function it_show_a_specific_version()
    {
        $record = create(Record::class);
        $record->versions()->create([
            'status' => Version::STATUS_CURRENT,
            'data' => 'current_ver'
        ]);
        $version = $record->versions()->first();
        $this->getJson(route('records.versions.show', [
            'record' => $record,
            'version' => $version
        ]))->assertStatus(200)
            ->assertSee("current_ver");
    }

    /** @test */
    function it_creates_a_new_version()
    {
        $record = create(Record::class);

        $this->assertEquals(0, $record->fresh()->versions->count());

        $this->postJson(route('records.versions.store', [
            'record' => $record
        ]), [
            'status' => VERSION::STATUS_CURRENT,
            'data' => 'current'
        ])->assertStatus(201);

        $this->assertEquals(1, $record->fresh()->versions->count());
    }

    /** @test */
    function it_updates_a_version()
    {
        $record = create(Record::class);
        $record->versions()->create([
            'status' => Version::STATUS_CURRENT,
            'data' => 'current_ver'
        ]);
        $version = $record->fresh()->versions()->first();

        $this->putJson(route('records.versions.update', [
            'record' => $record,
            'version' => $version
        ]), [
            'status' => VERSION::STATUS_SUPERSEDED,
            'data' => 'updated'
        ])->assertStatus(202)->assertSee('updated');

        $this->assertEquals('updated', $version->fresh()->data);
    }

    /** @test */
    function it_deletes_the_version()
    {
        $record = create(Record::class);
        $record->versions()->create([
            'status' => Version::STATUS_CURRENT,
            'data' => 'current_ver'
        ]);
        $version = $record->fresh()->versions()->first();

        $this->deleteJson(route('records.versions.destroy', [
            'record' => $record->id,
            'version' => $version->id
        ]))->assertStatus(202);

        $this->assertNull(Version::find($version->id));
    }
}
