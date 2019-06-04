<?php

namespace App\Http\Controllers\API;

use App\Representation;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class RepresentationsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $reps = Representation::orderBy('name')->get();//To get the output in array
        /*        ^               ^
         This will get the user | This will get all the Orders related to the user*/

        return response()->json($reps);
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $rep = Representation::findOrFail($id);
        /*        ^               ^
         This will get the user | This will get all the Orders related to the user*/

        return response()->json($rep);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function reps($id)
    {
        //dd($request);
        $rep = Representation::findOrFail($id);
        //$rep = Representation::where('id', $id)->get();//To get the output in array


        return response()->json($rep);
    }
}
