<?php

namespace App\Http\Controllers\API;

use App\Representation;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Traits\StoreImageTrait;
use Illuminate\Support\Facades\DB;

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
        //$this->middleware('auth:api');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $reps = Representation::orderBy('name')->with('City')->get();

        return response()->json($reps);
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
            'name' => 'required|string|max:191'
        ]);

        $name = $this->savePhoto($request,'companies', 'logo_small_id');

        $request->merge(['logo_small_id' => $name]);

        return Representation::create([
            'name' => $request['name'],
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
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $rep = Representation::findOrFail($id);

        return response()->json($rep);
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
        //$this->authorize('isAdmin');

        $rep = Representation::findOrFail($id);

        $this->validate($request, [
            'name' => 'required|string|max:191'
        ]);

        if ($request->logo_id !== null && strlen($request->logo_id) > 1000){
            $name = $this->savePhoto($request, 'companies', 'logo_id', $rep);
            $request->merge(['logo_id' => $name]);
        }

        if ($request->logo_small_id !== null && strlen($request->logo_small_id) > 1000) {
            $name = $this->savePhoto($request, 'companies/logosSmall', 'logo_small_id', $rep);
            $request->merge(['logo_small_id' => $name]);
        }

        if ($request->photo_id !== null && strlen($request->photo_id) > 1000) {
            $name = $this->savePhoto($request, 'companies', 'photo_id', $rep);
            $request->merge(['photo_id' => $name]);
        }

        $rep->update($request->all());

        return ['rep' => $rep];
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
