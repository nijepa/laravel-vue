<?php

namespace App\Http\Controllers\API;

use App\City;
use App\Country;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CitiesController extends Controller
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
    public function index()
    {
        $cities = City::orderBy('name')->with('Country')->paginate(10);//To get the output in array

        return response()->json($cities);
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
            'name' => 'required|string|max:191'
        ]);

        return City::create([
            'name' => $request['name'],
            'country_id' => $request['country_id']
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

        $city = City::findOrFail($id);

        $this->validate($request, [
            'name' => 'required|string|max:191'
        ]);

        $city->update($request->all());

        return ['city' => $city];
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

        $city = City::findOrFail($id);

        $city->delete();

        return ['message' => 'City deleted'];
    }

    /**
     * Search cities
     *
     * @return mixed
     */
    public function search() {
        if ($search = \Request::get('q')) {
            $cities = City::where(function($query) use ($search) {
                $query->where('name', 'LIKE', "%$search%");
            })->paginate(5);
        } else {
            $cities = City::latest()->paginate(5);
        }

        return $cities;
    }
}
