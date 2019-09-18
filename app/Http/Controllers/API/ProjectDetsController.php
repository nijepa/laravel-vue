<?php

namespace App\Http\Controllers\API;

use App\ProjectDet;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use App\Traits\StoreFileTrait;

class ProjectDetsController extends Controller
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
     * @return json Response
     */
    public function index()
    {
        $projectdets = ProjectDet::orderBy('caption')->with('User')->get();//To get the output in array

        return response()->json($projectdets);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return \Illuminate\Http\Response
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
        //$fdate = Carbon::parse($request->date_added);
        $request->merge(['date_added' => $fdate]);

        return ProjectDet::create([
            'caption' => $request['caption'],
            'note' => $request['note'],
            'project_id' => $request['project_id'],
            'doc_id' => $request['doc_id'],
            'date_added' => $request['date_added'],
            'user_id' => $request['user_id'],
            'finished' => $request['finished']
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
        $product = ProjectDet::where('project_id', $id)->with('User')->get();

        return response()->json($product);
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

        $project = ProjectDet::findOrFail($id);

        $this->validate($request, [
            'caption' => 'required|string|max:191',
        ]);

        $this->uploadFile($request, 'img/projects');

        $user = Auth::user()->id;
        $request->merge(['user_id' => $user]);

        //$fdate = Carbon::createFromFormat('D M d Y H:i:s e+', $request->date_added);
        $fdate = Carbon::parse($request->date_added);
        $request->merge(['date_added' => $fdate]);

        $project->update($request->all());

        return ['project' => $project];
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

        $project = ProjectDet::findOrFail($id);

        $project->delete();

        return ['message' => 'Document deleted'];
    }
}
