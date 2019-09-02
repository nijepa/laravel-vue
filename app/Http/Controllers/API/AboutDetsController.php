<?php

namespace App\Http\Controllers\API;

use App\AboutDet;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AboutDetsController extends Controller
{
    /**
     * AboutDetController constructor.
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
     * @return json Response
     */
    public function index()
    {
        $aboutdets = AboutDet::orderBy('caption')->get();//To get the output in array

        return response()->json($aboutdets);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return Response
     * @throws
     */
    public function store(Request $request)
    {
        $this->authorize('isAdmin');

        $this->validate($request, [
            'caption' => 'required|string|max:191',
            'description' => 'required'
        ]);

        return AboutDet::create([
            'caption' => $request['caption'],
            'description' => $request['description']
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return json Response
     */
    public function show($id)
    {
        $about = AboutDet::where('about_id', $id)->get();

        return response()->json($about);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param  int  $id
     * @return array
     * @throws
     */
    public function update(Request $request, $id)
    {
        $this->authorize('isAdmin');

        $about = AboutDet::findOrFail($id);

        $this->validate($request, [
            'caption' => 'required|string|max:191',
            'description' => 'required'
        ]);

        $about->update($request->all());

        return ['about' => $about];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return array
     * @throws
     */
    public function destroy($id)
    {
        $this->authorize('isAdmin');

        $about = AboutDet::findOrFail($id);

        $about->delete();

        return ['message' => 'About deleted'];
    }
}
