<?php

namespace App\Http\Controllers\API;

use App\About;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AboutsController extends Controller
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
        $abouts = About::orderBy('title')->leftJoin('about_dets', 'abouts.id', '=', 'about_dets.about_id')->get();//To get the output in array

        return response()->json($abouts);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function aboutF()
    {
        $about = About::orderBy('title')->leftJoin('about_dets', 'abouts.id', '=', 'about_dets.about_id')->get();//To get the output in array

        return response()->json($about);
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
            'title' => 'required|string|max:191',
            'body' => 'required'
        ]);

        return About::create([
            'title' => $request['title'],
            'body' => $request['body']
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
        $about = About::findOrFail($id);

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

        $about = About::findOrFail($id);

        $this->validate($request, [
            'title' => 'required|string|max:191',
            'body' => 'required'
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

        $about = About::findOrFail($id);

        $about->delete();

        return ['message' => 'About deleted'];
    }
}
