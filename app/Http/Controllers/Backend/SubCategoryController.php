<?php
namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\SubCategory;

class SubCategoryController extends Controller
{
     public function AllSubCategory(){
        $subcategories = SubCategory::latest()->get();
        return view('backend.subcategory.subcategory_all',compact('subcategories'));
    } // End Method 

    public function AddSubCategory(){
        $categories = Category::orderBy('category_name','ASC')->get();
        return view('backend.subcategory.subcategory_add', compact('categories'));
    } // End Method 

    public function StoreSubCategory(Request $request){
        //dd($request);
         $request->validate([
        'category_id' => 'required',
        'subcategory_name' => 'required|unique:sub_categories',         
         ]);

        SubCategory::insert([
            'category_id' => $request->category_id,
            'subcategory_name' => $request->subcategory_name,
            'subcategory_slug' => strtolower(str_replace(' ', '-',$request->subcategory_name)),
            
        ]);

         $notification = array(
            'message' => 'Subcategory Inserted Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('all.subcategory')->with($notification);       
    }

    public function EditSubCategory($id){
         $subcategory = Subcategory::findOrFail($id);
        return view('backend.subcategory.subcategory_edit', compact('subcategory'));
    }

    public function UpdateSubcategory(Request $request, $id){

        // $request->validate([
        //     'subcategory_name' => 'required'
        // ]);

        Subcategory::findOrFail($id)->update([
            'subcategory_name' => $request->subcategory_name
        ]);

         $notification = array(
            'message' => 'Subcategory Name Updated Successfully',
            'alert-type' => 'success'
        );

         return redirect()->route('all.subcategory')->with($notification); 
    }
    public function DeleteSubcategory($id){
        SubCategory::findOrFail($id)->delete();

        $notification = array(
            'message' => 'Subcategory Deleted Successfully',
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notification); 
        
    }

    public function GetSubCategory($category_id){
        $subcat = SubCategory::where('category_id',$category_id)->orderBy('subcategory_name','ASC')->get();
            return json_encode($subcat);
 
    }// End Method 

}



