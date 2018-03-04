<?php

namespace MinhD\Http\Controllers\API\Repository;

use MinhD\Http\Controllers\Controller;
use MinhD\Repository\DataSource;
use Illuminate\Http\Request;
use MinhD\Repository\DataSourceService;

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
        // TODO: page
        // TODO: Links Header
        $filters = DataSourceService::getFilters($request);
        return DataSourceService::get($filters);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // TODO
    }

    /**
     * Display the specified resource.
     *
     * @param  \MinhD\Repository\DataSource  $dataSource
     * @return \Illuminate\Http\Response
     */
    public function show(DataSource $dataSource)
    {
        return $dataSource;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \MinhD\Repository\DataSource  $dataSource
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, DataSource $dataSource)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \MinhD\Repository\DataSource  $dataSource
     * @return \Illuminate\Http\Response
     */
    public function destroy(DataSource $dataSource)
    {
        //
    }
}
