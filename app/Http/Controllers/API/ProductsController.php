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
        $this->middleware('auth:api')->only('store', 'update', 'destroy');
    }

    /**
     * Display a listing of the resource.
     *
     * @return json Response
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

        return response()->json($products);
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
            'name' => 'required|string|max:191',
        ]);

        if ($request->photo_id !== null) {
            $this->savePhoto($request, 'products', 'photo_id');
        }

        return Product::create([
            'name' => $request['name'],
            'description' => $request['description'],
            'body' => $request['body'],
            'photo_id' => $request['photo_id']
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
        $product = Product::findOrFail($id);

        return response()->json($product);
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
     * @return array
     *
     * @throws
     */
    public function destroy($id)
    {
        $this->authorize('isAdmin');

        $product = Product::findOrFail($id);

        $product->delete();

        return ['message' => 'Product deleted'];
    }
}
