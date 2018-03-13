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
        $filters = getPaginationFilters($request);

        $result = (new DataSource())
            ->where('user_id', auth()->user()->id)
            ->offset($filters['offset']);

        // meta_rifcs/key = fish
        // rifcs->key = fish
        $meta = collect($request->all())->filter(function($item) {
            return !starts_with($item, "meta_");
        })->flip()->map(function($item) {
            return str_replace("meta_", "", $item);
        })->map(function($item){
            return str_replace("/", "->", $item);
        })->flip();

        foreach ($meta as $field => $value) {
            $result = $result->where("meta->$field", $value);
        }

        $paginator = $result->paginate($filters['limit']);

        $links = getPaginatedLinksForHeader($paginator);

        return response($paginator->items(), Response::HTTP_OK)
            ->header('Link', $links);
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
            ['user_id' => auth()->user()->id]
        );

        $dataSource = DataSource::create($data);

        return response($dataSource, Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     *
     * @param  \MinhD\Repository\DataSource $dataSource
     * @return \Illuminate\Http\Response
     */
    public function show(DataSource $dataSource)
    {
        if ($dataSource->user_id !== auth()->user()->id) {
            return response("", Response::HTTP_FORBIDDEN);
        }

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
     * @param  \MinhD\Repository\DataSource $dataSource
     * @return \Illuminate\Http\Response
     */
    public function destroy(DataSource $dataSource)
    {
        $dataSource->delete();
        return response("", Response::HTTP_ACCEPTED);
    }
}
