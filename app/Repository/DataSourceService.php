<?php


namespace MinhD\Repository;


use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;

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
        $results = DataSource::offset($this->filters['offset']);

        // TODO: title, description, owner

        $this->results = $results->paginate($this->filters['limit']);
        return $this;
    }

    public function getResults()
    {
        return $this->results ? $this->results->items() : null;
    }

    public function response()
    {
        $paginator = $this->results;
        $pagination = $paginator->toArray();
        $links = [];

        if ($pagination['prev_page_url']) {
            $prev = "<{$pagination['prev_page_url']}>; rel=\"prev\"";
            $links[] = $prev;
        }

        if ($paginator->hasMorePages()) {
            $links[] = "<{$pagination['next_page_url']}>; rel=\"next\"";
        }

        $links[] = "<{$pagination['first_page_url']}>; rel=\"first\"";
        $links[] = "<{$pagination['last_page_url']}>; rel=\"last\"";

        $links = implode(", ", $links);

        return response($paginator->items())
            ->header('Link', $links);
    }

    public function getPaginator() : LengthAwarePaginator
    {
        return $this->results;
    }

    public function find($id)
    {
        return DataSource::find($id) ?: null;
    }
}