<?php

namespace Tests\Feature;

use MinhD\Repository\DataSource;
use Tests\MySQLTestCase;

class DataSourceMetaTest extends MySQLTestCase
{
    /** @test */
    function datasource_can_have_meta()
    {
        $dataSource = create(DataSource::class);
        $dataSource->meta = [
            'key' => 'something',
            'count' => [
                'published' => 1
            ]
        ];
        $dataSource->save();

        $this->assertEquals($dataSource->fresh()->meta['key'], 'something');
        $this->assertEquals(
            DataSource::where('meta->key', 'something')->first()->id,
            $dataSource->fresh()->id
        );
    }

    /** @test */
    function can_filter_by_meta_key()
    {
        $user = signIn();
        create(DataSource::class, ['user_id' => $user->id], 3);
        $dataSource = create(DataSource::class, ['user_id' => $user->id]);
        $dataSource->meta = [
            'key' => 'first-key'
        ];
        $dataSource->save();

        $this->getJson(route('datasources.index', [
            'meta_key' => 'first-key'
        ]))->assertSee($dataSource->id);
    }

    /** @test */
    function it_can_filter_by_nested_key()
    {
        $user = signIn();
        create(DataSource::class, ['user_id' => $user->id], 3);
        $dataSource = create(DataSource::class, ['user_id' => $user->id]);
        $dataSource->meta = [
            'nested' => [
                'key' => 'val'
            ],
            'level_1' => [
                'level_2' => [
                    'level_3' => 'value'
                ],
                'level_2_2' => false
            ]
        ];
        $dataSource->save();

        $this->getJson(route('datasources.index', [
            'meta_nested/key' => 'val'
        ]))->assertJsonCount(1)->assertSee($dataSource->id);

        $this->getJson(route('datasources.index', [
            'meta_level_1/level_2/level_3' => 'value'
        ]))->assertJsonCount(1)->assertSee($dataSource->id);
    }
}
