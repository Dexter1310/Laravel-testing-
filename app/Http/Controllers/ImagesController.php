<?php

namespace App\Http\Controllers;

use App\Models\Images;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ImagesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    public function feature(Request $request)
    {
        $id=intval($request->get('id'));
        $idProduct=intval($request->get('id_product'));
        $images= DB::table('images')->where('imageable_id',$idProduct)->get();
        foreach ($images as $image) {
            $value= $image->id===$id;

            DB::table('images')->where('id', $image->id)->update(['featured' => $value]);
        }

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Product $product)
    {
        $id = 0;

        foreach ($request->files as $key => $file) {
            $id++;
            $name = $request->get('title_image_' . $id);
            $namePath=time().$request->file($key)->getClientOriginalName();
            $request->file($key)->storeAs('public',$namePath);
            $validateImages = ([
                'name' => $name,
                'path' => $namePath,
                'imageable_type'=>Product::class,
                'imageable_id' => $product->id,
                'featured' => true
            ]);

            Images::create($validateImages);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Images $images)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Images $images)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Images $images)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $idImage= $request->get('id');
        $image= Images::findOrFail($idImage);
//        $idProduct= $image->imageable_id;

        if(Storage::disk('public')->exists($image->path)){ //if exists file in route storage/public/namefile
            $patch=Storage::disk('public')->delete($image->path); //recover path
            Storage::delete($patch);//delete file
        }
        Images::find($image->id)->delete();
        return redirect()->back()->with('success','Image deleted successfully');

    }
}
