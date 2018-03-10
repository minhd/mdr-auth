<?php

namespace MinhD\Http\Controllers\API\Repository;

use MinhD\Http\Controllers\Controller;
use MinhD\Repository\Record;
use MinhD\Repository\Version;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RecordVersionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Record $record
     * @return \Illuminate\Http\Response
     */
    public function index(Record $record)
    {
        return response($record->versions, Response::HTTP_OK);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param Record $record
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Record $record)
    {
        $version = $record->versions()->create($request->all());
        return response($version, Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     *
     * @param Record $record
     * @param Version $version
     * @return \Illuminate\Http\Response
     */
    public function show(Record $record, Version $version)
    {
        return response($version, Response::HTTP_OK);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param Version $version
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Record $record, Version $version)
    {
        $version->update($request->all());
        return response($version, Response::HTTP_ACCEPTED);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Record $record
     * @param Version $version
     * @return \Illuminate\Http\Response
     */
    public function destroy(Record $record, Version $version)
    {
        $version->delete();
        return response("", Response::HTTP_ACCEPTED);
    }
}
