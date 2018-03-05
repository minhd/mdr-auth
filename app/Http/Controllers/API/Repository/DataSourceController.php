<?php

namespace MinhD\Http\Controllers\API\Repository;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use MinhD\Http\Controllers\Controller;
use MinhD\Http\Requests\StoreDataSource;
use MinhD\Repository\DataSource;
use Illuminate\Http\Request;
use MinhD\Repository\DataSourceService;
use Symfony\Component\HttpFoundation\Response;

class DataSourceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $filters = $this->getFilters($request);

        $paginator = (new DataSource())
            ->offset($filters['offset'])
            ->paginate($filters['limit']);

        $links = $this->getLinksHeader($paginator);

        return response($paginator->items(), Response::HTTP_OK)
            ->header('Link', $links);
    }

    /**
     * get Link formatted for use in HTTP Header
     *
     * @param LengthAwarePaginator $paginator
     * @return array|string
     */
    private function getLinksHeader(LengthAwarePaginator $paginator)
    {
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

        return $links;
    }

    /**
     * Get an array of valid filters
     *
     * @param Request $request
     * @return array
     */
    private function getFilters(Request $request)
    {
        $filters = [
            'limit' => 10,
            'offset' => 0
        ];
        $filters['limit'] = $request->input('per_page') ? : $filters['limit'];
        $page = $request->input('page') ?: 1;
        $filters['offset'] = ($page - 1) * $filters['limit'];

        return $filters;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request|StoreDataSource $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreDataSource $request)
    {
        $data = array_merge(
            $request->all(),
            [ 'user_id' => auth()->user() ]
        );

        $dataSource = DataSource::create($data);

        return response($dataSource, Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     *
     * @param  \MinhD\Repository\DataSource  $dataSource
     * @return \Illuminate\Http\Response
     */
    public function show(DataSource $dataSource)
    {
        return response($dataSource, Response::HTTP_OK);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request|StoreDataSource $request
     * @param  \MinhD\Repository\DataSource $dataSource
     * @return \Illuminate\Http\Response
     */
    public function update(StoreDataSource $request, DataSource $dataSource)
    {
        $dataSource->update($request->all());
        return response($dataSource, Response::HTTP_ACCEPTED);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \MinhD\Repository\DataSource  $dataSource
     * @return \Illuminate\Http\Response
     */
    public function destroy(DataSource $dataSource)
    {
        $dataSource->delete();
        return response("", Response::HTTP_ACCEPTED);
    }
}
