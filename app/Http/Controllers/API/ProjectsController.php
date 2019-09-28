<?php

namespace App\Http\Controllers\API;

use App\Notifications\ProjectCreated;
use App\Project;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use App\Traits\StoreFileTrait;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;

class ProjectsController extends Controller
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
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $projects = Project::orderBy('title')->with('Representation')->with('User')->get();//To get the output in array

        return response()->json($projects);
    }

    /**
     * Display list of projects count per month
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function projectsPerMonth()
    {
        $projects=DB::table('projects')
            ->select(DB::raw('count(id) as total'),DB::raw('month(created_at) as dates'))
            ->groupBy('dates')
            ->orderBy('dates','desc')
            ->get();

        return response()->json($projects);
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
            'title' => 'required|string|max:191',
        ]);

        $this->uploadFile($request, 'img/projects');

        $user = Auth::user()->id;
        $request->merge(['user_id' => $user]);

        $fdate = Carbon::createFromFormat('D M d Y H:i:s e+', $request->project_started);
//        $fdate = Carbon::parse($request->project_started);
        $request->merge(['project_started' => $fdate]);

        $project = Project::create([
            'title' => $request['title'],
            'description' => $request['description'],
            'representation_id' => $request['representation_id'],
            'doc_id' => $request['doc_id'],
            'project_started' => $request['project_started'],
            'user_id' => $request['user_id'],
            'finished' => $request['finished']
        ]);

        $userNote = Auth::user();

        $admins = User::all()->filter(function($project) {
            return $project->hasRole('Admin');
        });

        try {
            Notification::send($admins, new ProjectCreated($project));
        } catch(\Exception $e){
        }

        return $project;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return json Response
     */
    public function show($id)
    {
        $project = Project::findOrFail($id);

        return response()->json($project);
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

        $project = Project::findOrFail($id);

        $this->validate($request, [
            'title' => 'required|string|max:191',
        ]);

        $this->uploadFile($request, 'img/projects');

        $user = Auth::user()->id;
        $request->merge(['user_id' => $user]);

        $fdate = Carbon::parse($request->project_started);
        $request->merge(['project_started' => $fdate]);

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

        $project = Project::findOrFail($id);

        $project->delete();

        return ['message' => 'Project deleted'];
    }

    /**
     * Upload file and set fle name
     *
     * @param Request $request
     */
/*    public function uploadFile(Request $request)
    {
        If ($request->hasFile('doc')) {
            //dd('aa');
            $fileName = time().'.'.$request->doc->getClientOriginalExtension();
            $request->offsetSet('doc_id', $fileName);
            $request->doc->move(public_path('img/projects'), $fileName);
        }
    }*/
}
