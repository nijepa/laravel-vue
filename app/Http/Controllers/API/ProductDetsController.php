<?php

namespace App\Http\Controllers\API;

use App\ProductDet;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Traits\StoreImageTrait;

class ProductDetsController extends Controller
{
    use StoreImageTrait;

    /**
     * ProductsDets Controller constructor.
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
        $productdets = ProductDet::orderBy('title')->get();//To get the output in array

        return response()->json($productdets);
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
            'title' => 'required|string|max:191',
        ]);

        if ($request->photo_id !== null) {
            $this->savePhoto($request, 'products', 'photo_id');
        }

        return ProductDet::create([
            'product_id' => $request['product_id'],
            'title' => $request['title'],
            'description' => $request['description'],
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
        $product = ProductDet::where('product_id', $id)->get();

        return response()->json($product);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param  int  $id
     * @return array
     * @throws
     */
    public function update(Request $request, $id)
    {
        $this->authorize('isAdmin');

        $product = ProductDet::findOrFail($id);

        $this->validate($request, [
            'title' => 'required|string|max:191',
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
     * @throws
     */
    public function destroy($id)
    {
        $this->authorize('isAdmin');

        $product = ProductDet::findOrFail($id);

        $product->delete();

        return ['message' => 'Product deleted'];
    }
}
