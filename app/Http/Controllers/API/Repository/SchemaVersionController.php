<?php

namespace MinhD\Http\Controllers\API\Repository;

use MinhD\Http\Controllers\Controller;
use MinhD\Http\Requests\StoreSchemaVersion;
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
     * @param Request|StoreSchemaVersion $request
     * @param Schema $schema
     * @return \Illuminate\Http\Response
     */
    public function store(StoreSchemaVersion $request, Schema $schema)
    {
        $data = array_merge(
            $request->all(),
            ['schema_id' => $schema->id]
        );
        $version = SchemaVersion::create($data);
        return response($version, Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     *
     * @param Schema $schema
     * @param  \MinhD\Repository\SchemaVersion $version
     * @return \Illuminate\Http\Response
     */
    public function show(Schema $schema, SchemaVersion $version)
    {
        return response($version, Response::HTTP_OK);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request|StoreSchemaVersion $request
     * @param Schema $schema
     * @param  \MinhD\Repository\SchemaVersion $version
     * @return \Illuminate\Http\Response
     */
    public function update(StoreSchemaVersion $request, Schema $schema, SchemaVersion $version)
    {
        $version->update($request->all());
        return response($version, Response::HTTP_ACCEPTED);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Schema $schema
     * @param  \MinhD\Repository\SchemaVersion $version
     * @return \Illuminate\Http\Response
     */
    public function destroy(Schema $schema, SchemaVersion $version)
    {
        $version->delete();
        return response("", Response::HTTP_ACCEPTED);
    }
}
