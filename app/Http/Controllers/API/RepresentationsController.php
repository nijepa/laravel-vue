<?php

namespace App\Http\Controllers\API;

use App\Representation;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Traits\StoreImageTrait;

class RepresentationsController extends Controller
{
    use StoreImageTrait;

    /**
     * RepresentationsController constructor.
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
        $reps = Representation::orderBy('name')->with('City')->get();

        return response()->json($reps);
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
            'name' => 'required|string|max:191'
        ]);

        $slug = str_slug($request->name);

        if ($request->photo_id !== null) {
            $this->savePhoto($request, 'profile', 'photo_id');
        }

        return Representation::create([
            'name' => $request['name'],
            'slug' => $slug,
            'category_id' => $request['category_id'],
            'short_desc' => $request['short_desc'],
            'description' => $request['description'],
            'address' => $request['address'],
            'city_id' => $request['city_id'],
            'phone' => $request['phone'],
            'mobile' => $request['mobile'],
            'email' => $request['email'],
            'website' => $request['password'],
            'photo_id' => $request['photo_id'],
            'logo_id' => $request['logo_id'],
            'logo_small_id' => $request['logo_small_id']
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
        $rep = Representation::findOrFail($id);

        return response()->json($rep);
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

        $rep = Representation::findOrFail($id);

        $this->validate($request, [
            'name' => 'required|string|max:191'
        ]);

        $slug = str_slug($request->name);
        $request->merge(['slug' => $slug]);

        if ($request->photo_id !== null) {
            $this->savePhoto($request, 'profile', 'photo_id');
        }

        $rep->update($request->all());

        return ['rep' => $rep];
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

        $rep = Representation::findOrFail($id);

        $rep->delete();

        return ['message' => 'Company deleted'];
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function reps($id)
    {
        $rep = Representation::findOrFail($id);

        return response()->json($rep);
    }
  }
