<?php

namespace App\Http\Controllers\API;

use App\Contact;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

class ContactsController extends Controller
{
    /**
     * ContactsController constructor.
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
        $contacts = Contact::orderBy('name')->paginate(5);//To get the output in array
        /*        ^               ^
         This will get the user | This will get all the Orders related to the user*/

        return response()->json($contacts);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function contactF()
    {
        $contacts = Contact::orderBy('name')->get();//To get the output in array
        /*        ^               ^
         This will get the user | This will get all the Orders related to the user*/

        return response()->json($contacts);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->authorize('isAdmin');

        $this->validate($request, [
            'name' => 'required|string|max:191',
            'email' => 'required|string|email|max:191|unique:users',
        ]);

/*        $name = time().'.' . explode('/',
                explode(':',
                    substr($request->photo, 0,
                        strpos($request->photo, ';')))[1])[1];

        \Image::make($request->photo)->save(public_path('img/profile/').$name);

        $request->merge(['photo' => $name]);*/

        return Contact::create([
            'name' => $request['name'],
            'email' => $request['email'],
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
     */
    public function update(Request $request, $id)
    {
        $this->authorize('isAdmin');

        $contact = Contact::findOrFail($id);

        $this->validate($request, [
            'name' => 'required|string|max:191',
            'email' => 'required|string|email|max:191|unique:users,email,'.$contact->id,
        ]);

        //$this->savePhoto($request, $user);

        $contact->update($request->all());

        return ['contact' => $contact];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->authorize('isAdmin');

        $contact = Contact::findOrFail($id);

        $contact->delete();

        return ['message' => 'Contact deleted'];
    }
}
