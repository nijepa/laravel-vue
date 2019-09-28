<?php

namespace App\Http\Controllers\API;

use App\Contact;
use http\Message;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Traits\StoreImageTrait;

class ContactsController extends Controller
{
    use StoreImageTrait;

    /**
     * ContactsController constructor.
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
     * @return json response
     */
    public function index()
    {
        $contacts = Contact::orderBy('name')->get();//To get the output in array

        return response()->json($contacts);
    }

    /**
     * Display a listing of the resource.
     *
     * @return array
     */
    public function contactF()
    {
        $contacts = Contact::orderBy('name')->get();

        return response()->json($contacts);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return array
     *
     * @throws
     */
    public function store(Request $request)
    {
        $this->authorize('isAdmin');

        $this->validate($request, [
            'name' => 'required|string|max:191',
            'email' => 'required|string|email|max:191|unique:users',
        ]);

        $this->uploadFiles($request);

        return Contact::create([
            'name' => $request['name'],
            'email' => $request['email'],
        ]);
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

        $contact = Contact::findOrFail($id);

        $this->validate($request, [
            'name' => 'required|string|max:191',
            'email' => 'required|string|email|max:191|unique:users,email,'.$contact->id,
        ]);

        $this->uploadFiles($request);

        $contact->update($request->all());

        return ['contact' => $contact];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return array
     *
     * @throws
     */
    public function destroy($id)
    {
        $this->authorize('isAdmin');

        $contact = Contact::findOrFail($id);

        $contact->delete();

        return ['message' => 'Contact deleted'];
    }

    /**
     * Upload files and save names in specified fields
     *
     * @param Request $request
     *
     * @return void
     */
    public function uploadFiles(Request $request)
    {
        $imgFields = ['photo_id'];

        foreach ($imgFields as $imgField) {

            if ($request->$imgField !== null) {
                $this->savePhoto($request, 'profile', $imgField);
            }
        }
    }
}
