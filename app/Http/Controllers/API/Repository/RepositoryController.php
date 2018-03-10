<?php

namespace MinhD\Http\Controllers\API\Repository;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use MinhD\Http\Controllers\Controller;

class RepositoryController extends Controller
{
    public function index()
    {
        return [
            'url' => URL::to('/'),
            'api_url' => URL::to('/api'),
            'version' => '0.1a',
            'schemas' => collect(config('schema'))->keys()
        ];
    }
}
