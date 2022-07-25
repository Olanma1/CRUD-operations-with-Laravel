<?php

namespace App\Http\Controllers;

use App\Models\category;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class CategoryController extends Controller
{
    public function AllCat(){
       //Read All Data in Desc. Manner
        $categories = Category::latest()->paginate(3);

       //Trash Category
        $trashedCat = Category::onlyTrashed()->latest()->paginate(2);


        //Get All Category
        return view('admin.category.index', compact('categories','trashedCat'));
    }


    public function SaveCat(Request $request)
    {  // New Category Form Validation

        $validated = $request->validate([
            'category_name' => 'required|unique:categories|max:255',

        ],
        [
            'category_name.required' => 'The category name is required'

        ]);
         //Insert New Category into Categories table into DB

        category::insert( [
            'category_name' => $request->category_name,
            'user_id'=> Auth::user()->id,
            'created_at'=>Carbon::now()

        ]);

        return redirect()->back()->with('success', 'Category Added Successfully');
    }
         //Edit Category
    public function EditCat($id)
    {
    $categories = Category::find($id);
    return view('admin.category.edit', compact('categories'));
    }


    //Update Category

    public function UpdateCat(Request $request, $id)
    {
$update = Category::find($id)->update([
    'category_name'=>$request->category_name,
    'user_id'=> Auth::user()->id
]);

return redirect()->route('All.category')->with('success', 'Category Updated Successfully');
    }

public function SoftDeleteCat($id)
{
$delete = Category::find($id)->delete();
return redirect()->back()->with('success', 'Category moved to trash Successfully');

}

public function RestoreCat($id)
{
    $delete = Category::withTrashed()->find($id)->restore();
    return redirect()->back()->with('success', 'Category Restored Successfully');
}

public function DeleteCat($id)
{
    $delete = Category::onlyTrashed()->find($id)->forceDelete();
    return redirect()->back()->with('success', 'Category Deleted!!');
}

}
