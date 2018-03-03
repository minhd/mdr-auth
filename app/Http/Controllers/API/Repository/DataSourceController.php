<?php

namespace MinhD\Http\Controllers\API\Repository;

use MinhD\Http\Controllers\Controller;
use MinhD\Repository\DataSource;
use Illuminate\Http\Request;

class DataSourceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // TODO: page
        // TODO: Links Header
        $dataSources = DataSource::all();

        return $dataSources;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
     * Show the form for editing the specified resource.
     *
     * @param  \MinhD\Repository\DataSource  $dataSource
     * @return \Illuminate\Http\Response
     */
    public function edit(DataSource $dataSource)
    {
        //
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
