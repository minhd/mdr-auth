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
        create(Version::class, [
            'status' => Version::STATUS_CURRENT,
            'data' => 'current_ver',
            'record_id' => $record->id
        ]);
        create(Version::class, [
            'status' => Version::STATUS_SUPERSEDED,
            'data' => 'prev_ver',
            'record_id' => $record->id
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
        $version = create(Version::class, ['data' => 'current_ver']);
        $this->getJson(route('records.versions.show', [
            'record' => $version->record,
            'version' => $version
        ]))->assertStatus(200)
            ->assertSee("current_ver");
    }

    /** @test */
    function it_creates_a_new_version()
    {
        $record = create(Record::class);

        $this->assertEquals(0, $record->fresh()->versions->count());

        signIn($record->owner);

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
        $version = create(Version::class);

        signIn($version->owner);

        $this->putJson(route('records.versions.update', [
            'record' => $version->record,
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
        $version = create(Version::class);

        signIn($version->owner);

        $this->deleteJson(route('records.versions.destroy', [
            'record' => $version->record,
            'version' => $version->id
        ]))->assertStatus(202);

        $this->assertNull(Version::find($version->id));
    }

    /** @test */
    function it_disallow_creating_version_without_logging_in()
    {
        $record = create(Record::class);
        $this->assertEquals(0, $record->fresh()->versions->count());
        $this->postJson(route('records.versions.store', [
            'record' => $record
        ]), [
            'status' => VERSION::STATUS_CURRENT,
            'data' => 'current'
        ])->assertStatus(403);
    }

    /** @test */
    function it_disallow_updating_of_version_they_dont_own()
    {
        $version = create(Version::class);

        signIn();
        $this->putJson(route('records.versions.update', [
            'record' => $version->record,
            'version' => $version
        ]), [
            'status' => VERSION::STATUS_SUPERSEDED
        ])->assertStatus(403);
    }
}
