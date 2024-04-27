<?php

namespace App\Http\Controllers;

use App\Models\Images;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $products = DB::table('products')
            ->select('products.*', 'users.name as user_name','images.name as image_name','images.path as image_path' )
            ->leftJoin('images', 'images.imageable_id', '=', 'products.id')
            ->join('users', 'users.id', '=', 'products.user_id')
            ->orderBy('products.created_at', 'asc')
            ->paginate(2);


        return view('products.index', ['products' => $products]);
    }

    /**
     * Store a newly created resource in storage.
     */

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
        ]);
        $name = $request->get('name');
        $description = $request->get('description');

        $validatedData = ([
            'name' => $name,
            'description' => $description,

        ]);

        $product= auth()->user()->products()->create($validatedData);

        if ($request->files) {
            app(ImagesController::class)->store($request,$product);

        }



        return to_route('products.list')->with('success', 'Product created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id)
    {
        $product = DB::table('products')
            ->select('products.*', 'users.name as user_name','images.name as image_name','images.path as image_path' )
            ->leftjoin('images', 'images.imageable_id', '=', 'products.id')
            ->join('users', 'users.id', '=', 'products.user_id')
            ->where('products.id', $id)->get();


        return view('products.view', ['product' => $product]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request)
    {
        $name = $request->get('name');
        $description = $request->get('description');
        $validatedData = ([
            'name' => $name,
            'description' => $description,
            'user_id' => auth()->id(),
        ]);

        $item = Product::findOrFail($request->get('id'));
        $item->update($validatedData);

        if ($request->files) {
            app(ImagesController::class)->store($request,$item);
        }
        return to_route('products.list')->with('success', 'Product update successfully');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(int $id, Request $request)
    {

        $product = DB::table('products')
            ->select('products.*', 'images.name as image_name','images.path as image_path','images.id as image_id' )
            ->leftjoin('images', 'images.imageable_id', '=', 'products.id')
            ->where('products.id', $id)->get();



        return view('products.edit', ['product' => $product]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $id= $request->get('id');

        $images= Images::where('imageable_id','=',$id)->get();
        foreach ($images as $image){

            if(Storage::disk('public')->exists($image->path)){ //if exists file in route storage/public/namefile
                $patch=Storage::disk('public')->delete($image->path); //recover path
                Storage::delete($patch);//delete file
            }
            Images::find($image->id)->delete();

        }
        Product::find($id)->delete();
        return to_route('products.list')->with('warning', 'Product deleted successfully');
    }
}
