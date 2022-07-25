<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class BrandController extends Controller
{
    public function AllBrand()
    {
        $brands = Brand::latest()->paginate(3);
        return view('admin.brand.index', compact('brands'));
    }



    public function SaveBrand(Request $request)
    {  // New Brand Form Validation

        $validated = $request->validate([
            'brand_name' => 'required|unique:brands|min:4',
            'brand_image' => 'required|mimes:jpg,jpeg,png',

        ],
        [
            'brand_name.required' => 'The Brand name is required',
            'brand_image.min' => 'Brand longer than 4 characters'

        ]);
         //Insert New Category into Categories table into DB



            $brand_image = $request->file('brand_image');


            $name_gen = hexdec(uniqid());
            $img_ext = strtolower($brand_image->getClientOriginalExtension());
            $img_name = $name_gen. '.'.$img_ext;

            $up_location = 'image/brand/';
            $last_img = $up_location.$img_name;
            $brand_image->move($up_location, $img_name);

            Brand::insert( [
                'brand_name' => $request->brand_name,
                 'brand_image' =>  $last_img ,
                'created_at'=>Carbon::now()

            ]);

        return redirect()->back()->with('success', 'Brand Added Successfully');
    }


}
