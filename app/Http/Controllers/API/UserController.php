<?php

namespace App\Http\Controllers\API;

use App\Message;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Traits\StoreImageTrait;

class UserController extends Controller
{

    use StoreImageTrait;

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
    public function index()
    {
        return User::orderBy('name')->get();
    }

    public function chat()
    {
        // get all users except the authenticated one
        $contacts = User::where('id', '!=', auth()->id())->get();
        // get a collection of items where sender_id is the user who sent us a message
        // and messages_count is the number of unread messages we have from him
        $unreadIds = Message::select(\DB::raw('`from` as sender_id, count(`from`) as messages_count'))
            ->where('to', auth()->id())
            ->where('read', false)
            ->groupBy('from')
            ->get();
        // add an unread key to each contact with the count of unread messages
        $contacts = $contacts->map(function($contact) use ($unreadIds) {
            $contactUnread = $unreadIds->where('sender_id', $contact->id)->first();
            $contact->unread = $contactUnread ? $contactUnread->messages_count : 0;
            return $contact;
        });
        return response()->json($contacts);
        /*$user = User::where('id', '!=', auth()->id())->get();
        return response()->json($user);*/
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     *
     * @throws
     */
    public function store(Request $request)
    {
        $this->authorize('isAdmin');

        $this->validate($request, [
            'name' => 'required|string|max:191',
            'email' => 'required|string|email|max:191|unique:users',
            'password' => 'required|string|min:6',
            'type' => 'required',
        ]);

        if ($request->photo !== null) {
            $this->savePhoto($request, 'profile', 'photo');
        }
 /*       if ($request->photo !== null && strlen($request->photo) > 1000) {
            $name = $this->savePhoto($request, 'profile', 'photo');
            //dd($name);
            $request->merge(['photo' => $name]);
        }*/
/*        $name = time().'.' . explode('/',
                explode(':',
                    substr($request->photo, 0,
                        strpos($request->photo, ';')))[1])[1];

        \Image::make($request->photo)->save(public_path('img/profile/').$name);

        $request->merge(['photo' => $name]);*/

        return User::create([
            'name' => $request['name'],
            'email' => $request['email'],
            'password' => Hash::make($request['password']),
            'type' => $request['type'],
            'bio' => $request['bio'],
            'photo' => $request['photo']
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     *
     * @throws
     */
    public function update(Request $request, $id)
    {
        $this->authorize('isAdmin');

        $user = User::findOrFail($id);

        $this->validate($request, [
            'name' => 'required|string|max:191',
            'email' => 'required|string|email|max:191|unique:users,email,'.$user->id,
            'password' => 'sometimes|min:6',
            'type' => 'required',
        ]);

        if ($request->photo !== null) {
           // dd($request->photo);
            $this->savePhoto($request, 'profile', 'photo');
            //$request->merge(['photo' => $name]);
        }
/*        if ($request->photo !== null && strlen($request->photo) > 1000) {
            $name = $this->savePhoto($request, 'profile', 'photo', $user);
            $request->merge(['photo' => $name]);
        }*/
        //$this->savePhoto($request, $user);
        /*$currentPhoto = $user->photo;

        if($request->photo !== $currentPhoto){
            $name = time().'.' . explode('/',
                    explode(':',
                        substr($request->photo, 0,
                            strpos($request->photo, ';')))[1])[1];

            \Image::make($request->photo)->save(public_path('img/profile/').$name);

            $request->merge(['photo' => $name]);

            $userPhoto = public_path('img/profile/').$currentPhoto;

            if(file_exists($userPhoto)){
                @unlink($userPhoto);
            }
        }*/

        $user->update($request->all());

        return ['user' => $user];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     *
     * @throws
     */
    public function destroy($id)
    {
        $this->authorize('isAdmin');

        $user = User::findOrFail($id);

        $user->delete();

        return ['message' => 'User deleted'];
    }

    /**
     * Logged user profile
     *
     * @return \Illuminate\Contracts\Auth\Authenticatable|null
     */
    public function profile()
    {
        return auth('api')->user();
    }

    /**
     * Update user profile
     *
     * @param Request $request
     * @return array
     * @throws \Illuminate\Validation\ValidationException
     */
    public function updateProfile(Request $request)
    {
        $user = auth('api')->user();

        $this->validate($request, [
            'name' => 'required|string|max:191',
            'email' => 'required|string|email|max:191|unique:users,email,'.$user->id,
            'password' => 'sometimes|required|min:6'
        ]);

        if ($request->photo !== null) {
            $this->savePhoto($request, 'profile', 'photo');
        }
   /*     $name = $this->savePhoto($request, 'profile', 'photo', $user );
        $request->merge(['photo' => $name]);*/
        //$this->savePhoto($request, $user);

        /*$currentPhoto = $user->photo;

        if($request->photo !== $currentPhoto){
            $name = time().'.' . explode('/',
                    explode(':',
                        substr($request->photo, 0,
                            strpos($request->photo, ';')))[1])[1];

            \Image::make($request->photo)->save(public_path('img/profile/').$name);

            $request->merge(['photo' => $name]);

            $userPhoto = public_path('img/profile/').$currentPhoto;

            if(file_exists($userPhoto)){
                @unlink($userPhoto);
            }
        }*/

        if(!empty($request->password)){
            $request->merge(['password' => Hash::make($request['password'])]);
        }

        $user->update($request->all());

        return ['message' => 'Profile updated'];
    }

    /**
     * Search users
     *
     * @return mixed
     */
    public function search() {
        if ($search = \Request::get('q')) {
            $users = User::where(function($query) use ($search) {
                $query->where('name', 'LIKE', "%$search%")
                        ->orWhere('email', 'LIKE', "%$search%")
                        ->orWhere('type', 'LIKE', "%$search%");
            })->paginate(5);
        } else {
            $users = User::latest()->paginate(5);
        }

        return $users;
    }

    /**
     * Save photo
     *
     * @param $request
     * @param $user
     */
    /*public function savePhoto($request, $user)
    {
        $currentPhoto = $user->photo;

        if($request->photo !== $currentPhoto){
            $name = time().'.' . explode('/',
                    explode(':',
                        substr($request->photo, 0,
                            strpos($request->photo, ';')))[1])[1];

            \Image::make($request->photo)->save(public_path('img/profile/').$name);

            $request->merge(['photo' => $name]);

            $userPhoto = public_path('img/profile/').$currentPhoto;

            if(file_exists($userPhoto)){
                @unlink($userPhoto);
            }
        }
    }*/
}
