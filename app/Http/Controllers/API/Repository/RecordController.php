<?php

namespace MinhD\Http\Controllers\API\Repository;

use MinhD\Http\Controllers\Controller;
use MinhD\Repository\Record;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RecordController extends Controller
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


        $status = $request->input('status') ?: Record::STATUS_PUBLISHED;
        $dataSourceId = $request->input('data_source_id') ?: false;
        $result = (new Record())
            ->offset($filters['offset'])
            ->where('status', $status);

        if ($dataSourceId) {
            $result = $result->where('data_source_id', $dataSourceId);
        }

        $paginator = $result->paginate($filters['limit']);
        $links = getPaginatedLinksForHeader($paginator);
        return response($paginator->items(), Response::HTTP_OK)
            ->header('Link', $links);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $record = Record::create($request->all());
        return response($record, Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     *
     * @param  \MinhD\Repository\Record $record
     * @return \Illuminate\Http\Response
     */
    public function show(Record $record)
    {
        return response($record, Response::HTTP_OK);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \MinhD\Repository\Record $record
     * @return \Illuminate\Http\Response
     */
    public function edit(Record $record)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \MinhD\Repository\Record $record
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Record $record)
    {
        $record->update($request->all());
        return response($record, Response::HTTP_ACCEPTED);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \MinhD\Repository\Record $record
     * @return \Illuminate\Http\Response
     */
    public function destroy(Record $record)
    {
        $record->delete();
        return response("", Response::HTTP_ACCEPTED);
    }
}
