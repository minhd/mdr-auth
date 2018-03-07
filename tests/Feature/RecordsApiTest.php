<?php

namespace Tests\Feature;

use MinhD\Repository\DataSource;
use MinhD\Repository\Record;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class RecordsApiTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    function shows_all_records()
    {
        $dataSource = create(DataSource::class);
        create(Record::class, 30, ['data_source_id' => $dataSource->id]);

        $result = $this->getJson(route('records.index'));
        $result->assertStatus(200);
        $result->assertJsonCount(10);
    }

    /** @test */
    function records_only_show_published()
    {
        $published = create(Record::class, 1, ['status' => Record::STATUS_PUBLISHED,]);
        $draft = create(Record::class, 1, ['status' => Record::STATUS_DRAFT,]);

        $this->getJson(route('records.index'))
            ->assertSee($published->id)
            ->assertDontSee($draft->id);
    }

    /** @test */
    function records_status_filter()
    {
        $published = create(Record::class, 1, ['status' => Record::STATUS_PUBLISHED]);
        $draft = create(Record::class, 1, ['status' => Record::STATUS_DRAFT]);

        $this->getJson(route('records.index', ['status' => Record::STATUS_DRAFT]))
            ->assertSee($draft->id)
            ->assertDontSee($published->id);
    }

    /** @test */
    function records_dsid_filter()
    {
        $dataSource1 = create(DataSource::class);
        create(Record::class, 2, ['data_source_id' => $dataSource1->id]);
        $record1 = Record::where('data_source_id', $dataSource1->id)->first();
        $dataSource2 = create(DataSource::class);
        create(Record::class, 5, ['data_source_id' => $dataSource2->id]);
        $record2 = Record::where('data_source_id', $dataSource2->id)->first();

        $this->getJson(route('records.index', ['data_source_id' => $dataSource2->id]))
            ->assertSee($record2->id)
            ->assertDontSee($record1->id);
    }

    /** @test */
    function it_shows_link_pagination_on_header()
    {
        create(Record::class, 30);
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

    /** @test */
    function can_create_record()
    {
        signIn();
        $dataSource = create(DataSource::class);

        $this->postJson(route('records.store', [
            'title' => 'some sample record',
            'status' => Record::STATUS_DRAFT,
            'data_source_id' => $dataSource->id
        ]))->assertStatus(201)->assertSee('some sample record');
    }

    /** @test */
    function it_validates_record_creation()
    {
        // TODO
    }

    /** @test */
    function it_updates_records()
    {
        // TODO
    }

    /** @test */
    function it_disallows_updating_records_user_dont_own()
    {
        // TODO
    }

    /** @test */
    function it_can_delete_records()
    {
        // TODO
    }
}
