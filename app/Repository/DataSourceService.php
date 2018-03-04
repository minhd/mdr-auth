<?php


namespace MinhD\Repository;


use Illuminate\Http\Request;

class DataSourceService
{
    public static $defaultFilters = [
        'limit' => 10,
        'offset' => 0
    ];

    public static function get($filters) {
        $dataSources = DataSource::limit($filters['limit'])->offset($filters['offset']);

        return $dataSources->get();
    }

    public static function getFilters(Request $request)
    {
        $filters = static::$defaultFilters;

        $filters['limit'] = $request->input('per_page') ? : $filters['limit'];

        $page = $request->input('page') ?: 1;
        $filters['offset'] = ($page - 1) * $filters['limit'];

        return $filters;
    }
}