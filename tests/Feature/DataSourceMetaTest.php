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
}
