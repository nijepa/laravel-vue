<?php

namespace App\Http\Controllers\API;

use App\Country;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CountriesController extends Controller
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
        return Country::orderBy('name')->paginate(10);
    }

    /**
     * Display all countries.
     *
     * @return mixed
     */
    public function selectAll()
    {
        return Country::orderBy('name', 'asc')->get();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     * @throws
     */
    public function store(Request $request)
    {
        $this->authorize('isAdmin');

        $this->validate($request, [
            'name' => 'required|string|max:191'
        ]);

        return Country::create([
            'name' => $request['name']
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request, int $id
     * @param  int  $id
     * @return array
     * @throws
     */
    public function update(Request $request, $id)
    {
        $this->authorize('isAdmin');

        $country = Country::findOrFail($id);

        $this->validate($request, [
            'name' => 'required|string|max:191'
        ]);

        $country->update($request->all());

        return ['country' => $country];
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

        $country = Country::findOrFail($id);

        $country->delete();

        return ['message' => 'Country deleted'];
    }
}