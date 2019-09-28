<?php

namespace App\Http\Controllers\API;

use App\Http\Resources\ToDoResource;
use App\ToDo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;

class ToDoController extends Controller
{
    /**
     * UserController constructor.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($userId = 0)
    {
        if($userId){
            $todos = ToDo::with('user')->where('user_id', $userId)->paginate(8);
        }else {
            $todos = ToDo::orderBy('created_at', 'desc')->with('user')->paginate(8);
        }
        return response()->json($todos);
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

        $user = Auth::user()->id;
        $request->merge(['user_id' => $user]);

        return ToDo::create([
            'title' => $request['title'],
            'user_id' => $request['user_id'],
            'completed' => $request['completed'],
            'priority' => $request['priority']
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\ToDo  $toDo
     * @return \Illuminate\Http\Response
     */
    public function show(ToDo $toDo)
    {
        //
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

        $todo = ToDo::findOrFail($id);

        $this->validate($request, [
            'title' => 'required|string|max:191'
        ]);

        $user = Auth::user()->id;
        $request->merge(['user_id' => $user]);

        $todo->update($request->all());

        return ['todo' => $todo];
    }

    /**
     * Mark ToDos as complete
     *
     * @param Request $request
     * @param $id
     * @return array
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function markCompleted(Request $request, $id) {
        $this->authorize('isAdmin');

        $todo = ToDo::findOrFail($id);

        $todo->update($request->completed);

        return ['todo' => $todo];
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

        $todo = ToDo::findOrFail($id);

        $todo->delete();

        return ['message' => 'ToDo deleted'];
    }
}
