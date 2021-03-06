<?php

namespace Tests\Feature;

use MinhD\Repository\DataSource;
use MinhD\Repository\Record;
use MinhD\Repository\Version;
use MinhD\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class RecordsApiTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    function shows_all_records()
    {
        $dataSource = create(DataSource::class);
        create(Record::class, ['data_source_id' => $dataSource->id], 30);

        $result = $this->getJson(route('records.index'));
        $result->assertStatus(200);
        $result->assertJsonCount(10);
    }

    /** @test */
    function records_only_show_published()
    {
        $published = create(Record::class, ['status' => Record::STATUS_PUBLISHED,]);
        $draft = create(Record::class, ['status' => Record::STATUS_DRAFT,]);

        $this->getJson(route('records.index'))
            ->assertSee($published->id)
            ->assertDontSee($draft->id);
    }

    /** @test */
    function records_status_filter()
    {
        $published = create(Record::class, ['status' => Record::STATUS_PUBLISHED]);
        $draft = create(Record::class, ['status' => Record::STATUS_DRAFT]);

        $this->getJson(route('records.index', ['status' => Record::STATUS_DRAFT]))
            ->assertSee($draft->id)
            ->assertDontSee($published->id);
    }

    /** @test */
    function records_dsid_filter()
    {
        $dataSource1 = create(DataSource::class);
        create(Record::class, ['data_source_id' => $dataSource1->id], 2);
        $record1 = Record::where('data_source_id', $dataSource1->id)->first();
        $dataSource2 = create(DataSource::class);
        create(Record::class, ['data_source_id' => $dataSource2->id], 5);
        $record2 = Record::where('data_source_id', $dataSource2->id)->first();

        $this->getJson(route('records.index', ['data_source_id' => $dataSource2->id]))
            ->assertSee($record2->id)
            ->assertDontSee($record1->id);
    }

    /** @test */
    function it_shows_link_pagination_on_header()
    {
        create(Record::class, [], 30);
        $result = $this->getJson(route('records.index'));
        $result->assertStatus(200);

        // should see the next link in header
        $result->assertHeader('Link');
        $this->assertContains("next", $result->headers->get('Link'));
        $this->assertContains("last", $result->headers->get('Link'));
        $this->assertContains("first", $result->headers->get('Link'));
    }

    /** @test */
    function records_block_the_right_route()
    {
        $this->postJson(route('records.store'), [])
            ->assertStatus(401)->assertSee('Unauthenticated');

        $this->putJson(route('records.update', ['record' => 1]), [])
            ->assertStatus(401)->assertSee('Unauthenticated');

        $this->deleteJson(route('records.destroy', ['record' => 1]), [])
            ->assertStatus(401)->assertSee('Unauthenticated');
    }

    protected function validRecord($overrides = [], $user = null)
    {
        $user = $user ?: signIn();
        $dataSource = create(DataSource::class, ['user_id' => $user]);
        return array_merge([
            'title' => 'some sample record',
            'status' => Record::STATUS_DRAFT,
            'data_source_id' => $dataSource->id,
            'version' => [
                'status' => Version::STATUS_CURRENT,
                'data' => 'current_version'
            ]
        ], $overrides);
    }

    /** @test */
    function can_create_record()
    {
        signIn();
        $valid = $this->validRecord();

        $this->postJson(route('records.store', $valid))
            ->assertStatus(201)->assertSee($valid['title']);
    }

    /** @test */
    function it_requires_some_data_to_create()
    {
        signIn();

        $this->postJson(route('records.store', []))
            ->assertStatus(422);
    }

    /** @test */
    function it_requires_version_to_create()
    {
        signIn();

        $this->postJson(route('records.store', $this->validRecord(['version' => ''])))
            ->assertStatus(422)->assertSee('version field is required');
    }

    /** @test */
    function it_requires_a_valid_datasource_to_create()
    {
        signIn();

        $this->postJson(route('records.store', $this->validRecord(['data_source_id' => 'non-exist'])))
            ->assertStatus(422)->assertSee('data source');
    }


    /** @test */
    function it_updates_records()
    {
        $user = signIn();
        $dataSource = create(DataSource::class, ['user_id' => $user->id]);
        $record = create(Record::class, ['data_source_id' => $dataSource->id]);

        $this->putJson(route('records.update', [
            'record' => $record->id,
            'title' => 'updated title'
        ]))->assertStatus(202)->assertSee('updated title');
    }

    /** @test */
    function it_disallows_updating_records_user_dont_own()
    {
        $john = signIn();
        $dataSource = create(DataSource::class, ['user_id' => $john->id]);
        $record = create(Record::class, ['data_source_id' => $dataSource->id]);

        $jane = create(User::class);
        signIn($jane);
        $this->putJson(route('records.update', $this->validRecord([
            'record' => $record->id,
            'title' => 'updated title',
            'status' => Record::STATUS_DRAFT
        ], $john)))->assertStatus(403);
    }

    /** @test */
    function it_can_delete_records()
    {
        signIn();
        $record = create(Record::class);

        $this->deleteJson(route('records.destroy', [
            'record' => $record->id
        ]))->assertStatus(202);

        $this->assertNull(Record::find($record->id));
    }
}
