<?php

namespace App\Http\Controllers\Api\Ecommerce;

use App\Http\Controllers\Controller;
use App\Http\Requests\ImageRequest;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class ProductImageController extends Controller
{
    public function index(){}


    public function store(ImageRequest $request)
    {


        $path = $request->file('image')->store('Images' , 'public');

         $image = ProductImage::create([
            'product_id' => $request->product_id,
            'image_path' => $path,
            'is_main' => false
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Product Image added successfully',
            'data' => $image
        ]);


    }

    public function show(Request $request)
    {
        return response()->file(storage_path('app/'.'public/'.'Images/'. $request->path));

    }

    public function delete($id){


        try {

            $image = ProductImage::findorfail($id);
            // 1. التحقق من وجود الملف وحذفه
            Storage::disk('public')->delete($image->image_path);
            $image->delete();
            return response()->json([
                'success' => true,
                'message' => 'Product Image deleted successfully',
            ]);

        }catch(\Exception $e){
            return $e->getMessage();
        }
    }
}
