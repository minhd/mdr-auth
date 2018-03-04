<?php


namespace MinhD\Repository;


use Illuminate\Http\Request;

// TODO: UnitTest
class DataSourceService
{
    public static $defaultFilters = [
        'limit' => 10,
        'offset' => 0
    ];

    private $filters = [];
    private $results = null;

    public function setFilters(Request $request)
    {
        $filters = self::$defaultFilters;

        $filters['limit'] = $request->input('per_page') ? : $filters['limit'];

        $page = $request->input('page') ?: 1;
        $filters['offset'] = ($page - 1) * $filters['limit'];

        $this->filters = $filters;

        return $this;
    }

    public function fetch()
    {
        $results = DataSource::limit($this->filters['limit'])->offset($this->filters['offset']);

        // TODO: title, description, owner

        $this->results = $results->get();
        return $this;
    }

    public function getResults()
    {
        return $this->results;
    }

    public function find($id)
    {
        return DataSource::find($id) ?: null;
    }
}