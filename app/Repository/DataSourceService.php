<?php


namespace MinhD\Repository;


use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Auth;
use MinhD\User;
use Symfony\Component\HttpFoundation\Response;

// TODO: extract interface
// TODO: UnitTest
class DataSourceService
{
    public static $defaultFilters = [
        'limit' => 10,
        'offset' => 0
    ];

    private $filters = [];

    /** @var Paginator */
    private $results = null;

    private $responseType = null;

    public function setFilters(Request $request)
    {
        $filters = self::$defaultFilters;

        $filters['limit'] = $request->input('per_page') ? : $filters['limit'];

        $page = $request->input('page') ?: 1;
        $filters['offset'] = ($page - 1) * $filters['limit'];

        $this->filters = $filters;

        return $this;
    }

    public function search(Request $request)
    {
        return $this->setFilters($request)
            ->fetch()
            ->paginatedSearchResponse();
    }

    public function fetch()
    {
        $results = (new DataSource())->offset($this->filters['offset']);

        $this->responseType = "collection";

        // TODO: title, description, owner

        $this->results = $results->paginate($this->filters['limit']);
        return $this;
    }

    public function paginatedSearchResponse()
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

        return response($paginator->items(), Response::HTTP_OK)
            ->header('Link', $links);
    }

    public function find($id)
    {
        return DataSource::find($id) ?: null;
    }

    public function create($request, Authenticatable $owner)
    {
        $data = array_merge(
            $request,
            [ 'user_id' => $owner->id ]
        );
        $dataSource = DataSource::create($data);

        $this->results = $dataSource;

        return response($dataSource, Response::HTTP_CREATED);
    }

    public function update($request, DataSource $dataSource)
    {
        $dataSource->update($request);
        return response($dataSource, Response::HTTP_ACCEPTED);
    }

    public function delete(DataSource $dataSource)
    {
        $dataSource->delete();
        return response("", Response::HTTP_ACCEPTED);
    }
}