<?php

namespace App\Http\Controllers\Backend;

use App\Models\Category;
use App\Model\Subcategory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Image;

class CategoryController extends Controller
{
    public function AllCategories(){
        $categories = Category::latest()->get();
        return view('backend.category.category_all', compact('categories'));
    }
    public function AddCategory(){
        return view('backend.category.category_add');
    }


    public function StoreCategory(Request $request){
        $request->validate([
            'category_name' => 'required',
            'category_image' => 'required|unique:categories'
        ]);

        $image = $request->file('category_image');
        $name_gen = hexdec(uniqid()).'.'.$image->getClientOriginalExtension();
        Image::make($image)->resize(300,300)->save('upload/category/'.$name_gen);
        $save_url = 'upload/category/'.$name_gen;

        Category::insert([
            'category_name' => $request->category_name,
            'category_slug' => strtolower(str_replace(' ', '-',$request->category_name)),
            'category_image' => $save_url
        ]);

         $notification = array(
            'message' => 'Category Inserted Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('all.category')->with($notification);
    }

    public function EditCategory($id){
        $category = Category::findOrFail($id);
        return view('backend.category.category_edit', compact('category'));
    }

      public function UpdateCategory(Request $request){
       $category_id = $request->id;
       $old_image = $request->old_image;

     if($request->file('category_image')){
        $image = $request->file('category_image');
        //@unlink(public_path('upload/category/'.$category->photo));
        @unlink($old_image);
        $name_gen = hexdec(uniqid()).'.'.$image->getClientOriginalExtension();
        Image::make($image)->resize(300,300)->save('upload/category/'.$name_gen);
        $save_url = 'upload/category/'.$name_gen;

        Category::findOrFail($category_id)->update([
            'category_name' => $request->category_name,
            'category_slug' => strtolower(str_replace(' ', '-',$request->category_name)),
            'category_image' => $save_url, 
        ]);

        $notification = array(
            'message' => 'Category Name and Image Updated Successfully',
            'alert-type' => 'success'
        );

         return redirect()->route('all.category')->with($notification); 
         
       } else {

         Category::findOrFail($category_id)->update([
            'category_name' => $request->category_name,
            'category_slug' => strtolower(str_replace(' ', '-',$request->category_name)),
             
        ]);

        $notification = array(
            'message' => 'Category Name Updated without Image Successfully',
            'alert-type' => 'success'
        );

         return redirect()->route('all.category')->with($notification); 

       }       
    }

    public function DeleteCategory($id){

        $category = Category::findOrFail($id);
        $img = $category->category_image;
        unlink($img ); 

        Category::findOrFail($id)->delete();

        $notification = array(
            'message' => 'Category Deleted Successfully',
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notification); 

    }// End Method 

    public function ShowSubcategories($id){
         $category = Category::findOrFail($id);
        //dd($category);
        return view('backend.category.category_subcategories', compact('category'));
        
    }
}
