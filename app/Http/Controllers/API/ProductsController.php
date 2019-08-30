<?php

namespace App\Http\Controllers\API;

use App\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Traits\StoreImageTrait;

class ProductsController extends Controller
{
    use StoreImageTrait;

    /**
     * ProductsController constructor.
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
        $products = Product::orderBy('name')->get();//To get the output in array

        return response()->json($products);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function productF()
    {
        $products = Product::orderBy('name')->get();//To get the output in array
        /*        ^               ^
         This will get the user | This will get all the Orders related to the user*/

        return response()->json($products);
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
        ]);

        $this->uploadFiles($request);

        return Product::create([
            'name' => $request['name'],
            'description' => $request['description'],
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
        $product = Product::findOrFail($id);
        /*        ^               ^
         This will get the user | This will get all the Orders related to the user*/

        return response()->json($product);
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

        $product = Product::findOrFail($id);

        $this->validate($request, [
            'name' => 'required|string|max:191',
        ]);

        if ($request->photo_id !== null) {
            $this->savePhoto($request, 'products', 'photo_id');
        }

        $product->update($request->all());

        return ['product' => $product];
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

        $product = Product::findOrFail($id);

        $product->delete();

        return ['message' => 'Product deleted'];
    }

    /**
     * Upload files and save names in specified fields
     *
     * @param Request $request
     */
    public function uploadFiles(Request $request)
    {
        $imgFields = ['photo_id'];

        foreach ($imgFields as $imgField) {

            if ($request->$imgField !== null) {
                $this->savePhoto($request, 'products', $imgField);
            }
        }
    }
}
