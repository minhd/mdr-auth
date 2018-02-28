<?php

namespace MinhD\Http\Controllers;

use Illuminate\Http\Request;

/**
 * @SWG\Swagger(
 *     schemes={"http","https"},
 *     host="mdr-auth.test",
 *     basePath="/",
 *     @SWG\Info(
 *         version="1.0.0",
 *         title="Authentication API",
 *         description="An API for authentication",
 *         termsOfService="",
 *         @SWG\Contact(
 *             email="dekarvn@gmail.com"
 *         ),
 *         @SWG\License(
 *             name="MIT",
 *             url="URL to the license"
 *         )
 *     ),
 *     @SWG\ExternalDocumentation(
 *         description="Find out more about my website",
 *         url="http..."
 *     )
 * )
 */
class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * @SWG\Get(
     *   path="/",
     *   summary="Home Page",
     *   @SWG\Response(
     *     response=200,
     *     description="Authentication home page"
     *   )
     * )
     */
    
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('home');
    }
}
