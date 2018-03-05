<?php

namespace MinhD\Http\Controllers\API\Repository;

use MinhD\Http\Controllers\Controller;
use MinhD\Repository\Schema;
use MinhD\Repository\SchemaVersion;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SchemaVersionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Schema $schema
     * @return \Illuminate\Http\Response
     */
    public function index(Schema $schema)
    {
        return response($schema->versions, Response::HTTP_OK);
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
     * @param Schema $schema
     * @param  \MinhD\Repository\SchemaVersion $schemaVersion
     * @return \Illuminate\Http\Response
     */
    public function show(Schema $schema, SchemaVersion $schemaVersion)
    {
        return response($schemaVersion, Response::HTTP_OK);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \MinhD\Repository\SchemaVersion  $schemaVersion
     * @return \Illuminate\Http\Response
     */
    public function edit(SchemaVersion $schemaVersion)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \MinhD\Repository\SchemaVersion  $schemaVersion
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, SchemaVersion $schemaVersion)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \MinhD\Repository\SchemaVersion  $schemaVersion
     * @return \Illuminate\Http\Response
     */
    public function destroy(SchemaVersion $schemaVersion)
    {
        //
    }
}
