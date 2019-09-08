<?php

namespace App\Http\Controllers\API;

use App\ProjectDet;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProjectDetsController extends Controller
{
    /**
     * ProjectsDets Controller constructor.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api')->only('store', 'update', 'destroy');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $projectdets = ProjectDet::orderBy('caption')->get();//To get the output in array

        return response()->json($projectdets);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
     * @param  \App\ProjectDets  $projectDets
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $product = ProjectDet::where('project_id', $id)->get();

        return response()->json($product);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\ProjectDets  $projectDets
     * @return \Illuminate\Http\Response
     */
    public function edit(ProjectDets $projectDets)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ProjectDets  $projectDets
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ProjectDets $projectDets)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ProjectDets  $projectDets
     * @return \Illuminate\Http\Response
     */
    public function destroy(ProjectDets $projectDets)
    {
        //
    }
}
