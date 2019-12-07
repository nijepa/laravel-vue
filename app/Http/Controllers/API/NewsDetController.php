<?php

namespace App\Http\Controllers\API;

use App\News_det;
use App\Traits\StoreImageTrait;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class NewsDetController extends Controller
{
    use StoreImageTrait;

    /**
     * NewsDets Controller constructor.
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
        $newsdets = News_Det::orderBy('description')->get();//To get the output in array

        return response()->json($newsdets);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     * @throws
     */
    public function store(Request $request)
    {
        $this->authorize('isAdmin');

        $this->validate($request, [
            'description' => 'required|string|max:191'
        ]);

        if ($request->photo_id !== null) {
            $this->savePhoto($request, 'news', 'photo_id');
        }

        return News_det::create([
            'description' => $request['description'],
            'news_id' => $request['news_id'],
            'photo_id' => $request['photo_id'],
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return array
     */
    public function show($id)
    {
        $newsdets = News_det::where('news_id', $id)->get();

        return response()->json($newsdets);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return array
     * @throws
     */
    public function update(Request $request, $id)
    {
        $this->authorize('isAdmin');

        $newsdet = News_det::findOrFail($id);

        $this->validate($request, [
            'description' => 'required|string|max:191'
        ]);

        if ($request->photo_id !== null) {
            $this->savePhoto($request, 'news', 'photo_id');
        }

        $newsdet->update($request->all());

        return ['newsdet' => $newsdet];
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

        $newsdet = News_det::findOrFail($id);

        $newsdet->delete();

        return ['message' => 'News detail deleted'];
    }
}
