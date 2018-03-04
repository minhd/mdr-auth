<?php

namespace MinhD\Http\Controllers\API\Repository;

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
        return (new DataSourceService())
            ->search($request);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request|StoreDataSource $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreDataSource $request)
    {
        return (new DataSourceService())
            ->create($request->all(), auth()->user());
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
        return (new DataSourceService())
            ->update($request->all(), $dataSource);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \MinhD\Repository\DataSource  $dataSource
     * @return \Illuminate\Http\Response
     */
    public function destroy(DataSource $dataSource)
    {
        return (new DataSourceService())
            ->delete($dataSource);
    }
}
