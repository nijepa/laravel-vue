<?php

namespace App\Http\Controllers\API;

use App\RepDet;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Traits\StoreImageTrait;

class RepresentationDetsController extends Controller
{
    use StoreImageTrait;

    /**
     * RepDets Controller constructor.
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
        $repdets = RepDet::orderBy('title')->get();

        return response()->json($repdets);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return \Illuminate\Http\Response
     *
     * @throws
     */
    public function store(Request $request)
    {
        $this->authorize('isAdmin');

        $this->validate($request, [
            'title' => 'required|string|max:191'
        ]);

        $this->uploadFile($request);

        return RepDet::create([
            'title' => $request['title'],
            'rep_id' => $request['rep_id'],
            'doc_id' => $request['doc_id'],
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
        //$repdets = RepDet::findOrFail($id);
        $repdets = RepDet::where('rep_id', $id)->get();//To get the output in array

        return response()->json($repdets);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param  int  $id
     * @return array
     *
     * @throws
     */
    public function update(Request $request, $id)
    {
        $this->authorize('isAdmin');

        $rep = RepDet::findOrFail($id);

        $this->validate($request, [
            'title' => 'required|string|max:191'
        ]);

        $this->uploadFile($request);

        $rep->update($request->all());

        return ['rep' => $rep];
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

        $rep = RepDet::findOrFail($id);

        $rep->delete();

        return ['message' => 'Document deleted'];
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function repsD(Request $request)
    {
        $repdets = DB::table('rep_dets')->where($request);

        return response()->json($repdets);
    }

    /**
     * Upload file and set fle name
     *
     * @param Request $request
     */
    public function uploadFile(Request $request)
    {
        If ($request->hasFile('doc')) {
            $fileName = time().'.'.$request->doc->getClientOriginalExtension();
            $request->offsetSet('doc_id', $fileName);
            $request->doc->move(public_path('img/companies/docs'), $fileName);
        }
    }
}
