<?php

namespace App\Http\Controllers\API;

use App\MeetingDet;
use App\Http\Controllers\Controller;
use App\Traits\StoreFileTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class MeetingDetsController extends Controller
{
    use StoreFileTrait;

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
     * @return Json Response
     */
    public function index()
    {
        $meetingdets = MeetingDet::orderBy('caption')->with('User')->with('Representation')->get();

        return response()->json($meetingdets);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return array
     * @throws
     */
    public function store(Request $request)
    {
        $this->authorize('isAdmin');

        $this->validate($request, [
            'caption' => 'required|string|max:191'
        ]);

        $this->uploadFile($request, 'img/projects');

        $user = Auth::user()->id;
        $request->merge(['user_id' => $user]);

        $fdate = Carbon::createFromFormat('D M d Y H:i:s e+', $request->date_added);
        $request->merge(['date_added' => $fdate]);

        return MeetingDet::create([
            'caption' => $request['caption'],
            'note' => $request['note'],
            'representation_id' => $request['representation_id'],
            'meeting_id' => $request['meeting_id'],
            'doc_id' => $request['doc_id'],
            'date_added' => $request['date_added'],
            'user_id' => $request['user_id'],
            'finished' => $request['finished']
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  $id
     * @return Json Response
     */
    public function show($id)
    {
        $meetingdets = MeetingDet::where('meeting_id', $id)->with('User')->get();

        return response()->json($meetingdets);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param  $id
     * @return array
     * @throws
     */
    public function update(Request $request, $id)
    {
        $this->authorize('isAdmin');

        $meetingDet = MeetingDet::findOrFail($id);

        $this->validate($request, [
            'caption' => 'required|string|max:191',
        ]);

        $this->uploadFile($request, 'img/projects');

        $user = Auth::user()->id;
        $request->merge(['user_id' => $user]);

        $fdate = Carbon::parse($request->date_added);
        $request->merge(['date_added' => $fdate]);

        $meetingDet->update($request->all());

        return ['project' => $meetingDet];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  $id
     * @return array
     * @throws
     */
    public function destroy($id)
    {
        $this->authorize('isAdmin');

        $meetingdet = MeetingDet::findOrFail($id);

        $meetingdet->delete();

        return ['message' => 'Meeting detail deleted'];
    }
}
