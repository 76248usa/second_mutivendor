<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Banner;
use Image;

class BannerController extends Controller
{
    public function AllBanners(){
        $banners = Banner::latest()->get();
        return view('backend.banner.banner_all', compact('banners'));
    }

    public function AddBanner(){
        return view('backend.banner.banner_add');
    }

     public function StoreBanner(Request $request){

        $image = $request->file('banner_image');
        $name_gen = hexdec(uniqid()).'.'.$image->getClientOriginalExtension();
        Image::make($image)->resize(768,450)->save('upload/banner/'.$name_gen);
        $save_url = 'upload/banner/'.$name_gen;

        Banner::insert([
            'banner_title' => $request->banner_title,
            'banner_url' => $request->banner_url,
            'banner_image' => $save_url, 
        ]);

       $notification = array(
            'message' => 'Banner Inserted Successfully',
            'alert-type' => 'info'
        );

        return redirect()->route('all.banner')->with($notification); 

    }// End Method 


    public function EditBanner($id){
        $banner = Banner::findOrFail($id);
        return view('backend.banner.banner_edit', compact('banner'));
    }

    public function UpdateBanner(Request $request){
        $banner_id = $request->id;
        $old_image = $request->old_image;
        
        if($request->file('banner_image')){
         $image = $request->file('banner_image');
         $name_gen = hexdec(uniqid()).'.'.$image->getClientOriginalExtension();
        Image::make($image)->resize(768,450)->save('upload/banner/'.$name_gen);
        $save_url = 'upload/banner/'.$name_gen;

        Banner::findOrFail($banner_id)->update([
            'banner_title' => $request->banner_title,
            'banner_url' => $request->banner_url,
            'banner_image' => $save_url, 
        ]);

        $notification = array(
            'message' => 'Banner Name and Image Updated Successfully',
            'alert-type' => 'success'
        );

         return redirect()->route('all.banner')->with($notification); 
         
       } else {

        Banner::findOrFail($banner_id)->update([
            'banner_title' => $request->banner_title,
            'banner_url' => $request->banner_url,            
        ]);

        $notification = array(
            'message' => 'Banner Successfully Updated without Image',
            'alert-type' => 'success'
        );

         return redirect()->route('all.slider')->with($notification); 
        }
    }

    public function DeleteBanner($id){
        $banner = Banner::findOrFail($id);
        $banner->delete();

         $notification = array(
            'message' => 'Banner Successfully Deleted',
            'alert-type' => 'success'
        );

         return redirect()->route('all.banner')->with($notification); 
    }
}
