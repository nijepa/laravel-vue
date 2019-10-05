<?php

namespace App\Http\Controllers\API;

use App\Export;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ExportController extends Controller
{
    /**
     * AboutsController constructor.
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
        $export = Export::orderBy('body')->get();
        return $export;
        //dd($export);
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
     * @param  \App\Export  $export
     * @return \Illuminate\Http\Response
     */
    public function show(Export $export)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int $id
     * @return array
     * @throws
     */
    public function update(Request $request, $id)
    {
        $this->authorize('isAdmin');

        $export = Export::findOrFail($id);

        $this->validate($request, [
            'body' => 'required|string'
        ]);

        $export->update($request->all());

        return ['export' => $export];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Export  $export
     * @return \Illuminate\Http\Response
     */
    public function destroy(Export $export)
    {
        //
    }
}
