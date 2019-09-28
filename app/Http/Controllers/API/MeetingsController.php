<?php

namespace App\Http\Controllers\API;

use App\Meeting;
use App\Traits\StoreFileTrait;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class MeetingsController extends Controller
{
    use StoreFileTrait;

    /**
     * ProductsController constructor.
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
        $meetings = Meeting::orderBy('title')->with('Representation')->with('User')->with('City')->get();//To get the output in array

        return response()->json($meetings);
    }

    /**
     * Display list of meetings count per month
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function meetingsPerMonth()
    {
        $meetings=DB::table('meetings')
            ->select(DB::raw('count(id) as total'),DB::raw('month(created_at) as dates'))
            ->groupBy('dates')
            ->orderBy('dates','desc')
            ->get();

        return response()->json($meetings);
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
            'title' => 'required|string|max:191',
        ]);

        $this->uploadFile($request, 'img/projects');

        $user = Auth::user()->id;
        $request->merge(['user_id' => $user]);

//        $fdate = Carbon::parse($request->meeting_started);
        $fdate = Carbon::createFromFormat('D M d Y H:i:s e+', $request->meeting_started);
        $request->merge(['meeting_started' => $fdate]);

        return Meeting::create([
            'title' => $request['title'],
            'city_id' => $request['city_id'],
            'description' => $request['description'],
            'representation_id' => $request['representation_id'],
            'doc_id' => $request['doc_id'],
            'meeting_started' => $request['meeting_started'],
            'user_id' => $request['user_id'],
            'finished' => $request['finished']
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Meeting  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $meeting = Meeting::findOrFail($id);

        return response()->json($meeting);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request, int $id
     * @param  \App\Meeting  $id
     * @return array
     * @throws
     */
    public function update(Request $request, $id)
    {
        $this->authorize('isAdmin');

        $meeting = Meeting::findOrFail($id);

        $this->validate($request, [
            'title' => 'required|string|max:191',
        ]);

        $this->uploadFile($request, 'img/projects');

        $user = Auth::user()->id;
        $request->merge(['user_id' => $user]);

        //$fdate = Carbon::createFromFormat('D M d Y H:i:s e+', $request->meeting_started);
        $fdate = Carbon::parse($request->meeting_started);
        $request->merge(['project_started' => $fdate]);

        $meeting->update($request->all());

        return ['project' => $meeting];
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

        $meeting = Meeting::findOrFail($id);

        $meeting->delete();

        return ['message' => 'Meeting deleted'];
    }
}
