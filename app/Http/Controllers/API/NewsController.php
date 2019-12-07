<?php

namespace App\Http\Controllers\API;

use App\News;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Traits\StoreImageTrait;

class NewsController extends Controller
{
    use StoreImageTrait;

    /**
     * News Controller constructor.
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
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $news = News::orderBy('news_date', 'desc')->take(1)->get();//To get the output in array

        return response()->json($news);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function newsBack()
    {
        $news = News::orderBy('news_date', 'desc')->get();//To get the output in array

        return response()->json($news);
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
            'title' => 'required|string|max:191'
        ]);

        if ($request->pic_id !== null) {
            $this->savePhoto($request, 'news', 'pic_id');
        }

        return News::create([
            'title' => $request['title'],
            'body' => $request['body'],
            'pic_id' => $request['pic_id'],
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $news = News::findOrFail($id);

        return response()->json($news);
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

        $news = News::findOrFail($id);

        $this->validate($request, [
            'title' => 'required|string|max:191'
        ]);

        if ($request->pic_id !== null) {
            $this->savePhoto($request, 'news', 'pic_id');
        }

        $news->update($request->all());

        return ['news' => $news];
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

        $news = News::findOrFail($id);

        $news->delete();

        return ['message' => 'News deleted'];
    }
}
