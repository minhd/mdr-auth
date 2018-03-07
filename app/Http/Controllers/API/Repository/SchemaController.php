<?php

namespace MinhD\Http\Controllers\API\Repository;

use MinhD\Http\Controllers\Controller;
use MinhD\Http\Requests\StoreSchema;
use MinhD\Repository\Schema;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SchemaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response(Schema::all(), Response::HTTP_OK);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request|StoreSchema $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreSchema $request)
    {
        $schema = Schema::create($request->all());
        return response($schema, Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     *
     * @param  \MinhD\Repository\Schema  $schema
     * @return \Illuminate\Http\Response
     */
    public function show(Schema $schema)
    {
        return response($schema, Response::HTTP_OK);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request|StoreSchema $request
     * @param  \MinhD\Repository\Schema $schema
     * @return \Illuminate\Http\Response
     */
    public function update(StoreSchema $request, Schema $schema)
    {
        $schema->update($request->all());
        return response($schema, Response::HTTP_ACCEPTED);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \MinhD\Repository\Schema $schema
     * @return \Illuminate\Http\Response
     */
    public function destroy(Schema $schema)
    {
        $schema->delete();
        return response("", Response::HTTP_ACCEPTED);
    }
}
