<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\VendorController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Backend\BrandController;
use App\Http\Controllers\Backend\CategoryController;
use App\Http\Controllers\Backend\SubCategoryController;
use App\Http\Controllers\Backend\ProductController;
use App\Http\Controllers\Backend\VendorProductController;
use App\Http\Controllers\Backend\SliderController;
use App\Http\Controllers\Backend\BannerController;
use App\Http\Middleware\RedirectIfAuthenticated;

Route::get('/', function () {
    return view('frontend.index');
});

Route::middleware(['auth'])->group(function() {
Route::get('/dashboard', [UserController::class, 'UserDashboard'])->name('dashboard');
Route::post('/user/profile/store', [UserController::class, 'UserProfileStore'])->name('user.profile.store');
Route::get('user/logout', [UserController::class, 'UserLogout'])->name('user.logout');
Route::post('user/update/password', [UserController::class, 'UserUpdatePassword'])
    ->name('user.update.password');
}); 


Route::get('admin/dashboard', [AdminController::class, 'AdminDashboard'])->name('admin.dashboard')->middleware(RedirectIfAuthenticated::class);;
Route::get('vendor/dashboard', [VendorController::class, 'VendorDashboard'])->name('vendor.dashboard')->middleware(RedirectIfAuthenticated::class);;

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
});

require __DIR__.'/auth.php';

//ADMIN
Route::middleware(['auth', 'role:admin'])->group(function(){
    Route::get('/admin/dashboard', [AdminController::class, 'AdminDashboard'])->name('admin.dashboard');
    Route::get('/admin/logout', [AdminController::class, 'AdminDestroy'])->name('admin.logout');
    Route::get('/admin/profile', [AdminController::class, 'AdminProfile'])->name('admin.profile');
    Route::post('/admin/profile/store', [AdminController::class, 'AdminProfileStore'])
    ->name('admin.profile.store');
    Route::get('/admin/change/password', [AdminController::class, 'AdminChangePassword'])
    ->name('admin.change.password');
    Route::post('admin/update/password', [AdminController::class, 'AdminUpdatePassword'])->name('update.password');
});
//VENDOR
Route::middleware(['auth','role:vendor'])->group(function(){
    Route::get('vendor/dashboard', [VendorController::class, 'VendorDashboard'])->name('vendor.dashboard');
    Route::get('/vendor/logout', [VendorController::class, 'VendorDestroy'])->name('vendor.logout');
    Route::get('/vendor/profile', [VendorController::class, 'VendorProfile'])->name('vendor.profile');
    Route::post('/vendor/profile/store', [VendorController::class, 'VendorProfileStore'])
    ->name('vendor.profile.store');
    Route::get('vendor/change/password', [VendorController::class, 'VendorChangePassword'])
    ->name('vendor.change.password');
    Route::post('vendor/update/password', [VendorController::class, 'VendorUpdatePassword'])
    ->name('update.password');

Route::controller(VendorProductController::class)->group(function(){
    Route::get('vendor/all/product', 'VendorAllProduct')->name('vendor.all.product');
    Route::get('vendor/add/product', 'VendorAddProduct')->name('vendor.add.product');
    Route::post('vendor/store/product', 'VendorStoreProduct')->name('vendor.store.product');
    Route::get('vendor/subcategory/ajax/{category_id}' , 'VendorGetSubCategory');
    Route::get('vendor/edit/product/{id}', 'VendorEditProduct')->name('vendor.edit.product');
    Route::post('vendor/update/product/{id}', 'VendorUpdateProduct')->name('vendor.update.product');
    Route::post('/vendor/update/thumbnail' , 'VendorUpdateThumbnail')->name('vendor.update.thumbnail');
    Route::post('/vendor/update/multiimage' , 'VendorUpdateMultiImage')->name('vendor.update.multiimage');
    Route::get('/vendor/product/multiimg/delete/{id}' , 'VendorMultiimgDelete')->name('vendor.product.multiimg.delete');
    Route::get('/vendor/product/inactive/{id}' , 'VendorProductInactive')->name('vendor.product.inactive');
    Route::get('/vendor/product/active/{id}' , 'VendorProductActive')->name('vendor.product.active');
    Route::get('/vendor/delete/product/{id}' , 'VendorProductDelete')->name('vendor.delete.product');
});
});

Route::get('/admin/login', [AdminController::class, 'AdminLogin']);
Route::get('/vendor/login', [VendorController::class, 'VendorLogin'])->name('vendor.login');
Route::get('become/vendor', [VendorController::class, 'BecomeVendor'])->name('become.vendor');
Route::post('vendor/register', [VendorController::class, 'RegisterVendor'])->name('vendor.register');

//BRAND
Route::middleware(['auth', 'role:admin'])->group(function(){
Route::controller(BrandController::class)->group(function(){
    Route::get('/all/brand', 'AllBrand')->name('all.brand');
    Route::get('/add/brand', 'AddBrand')->name('add.brand');
    Route::post('/brand/store', 'StoreBrand')->name('brand.store');
    Route::get('/edit/brand/{id}', 'EditBrand')->name('edit.brand');
    Route::post('/update/brand', 'UpdateBrand')->name('update.brand');
    Route::get('/delete/brand/{id}', 'DeleteBrand')->name('delete.brand');
});
}); //End Middleware

//Category
Route::middleware(['auth', 'role:admin'])->group(function(){
Route::controller(CategoryController::class)->group(function(){
    Route::get('/all/category', 'AllCategories')->name('all.category');
    Route::get('/add/category', 'AddCategory')->name('add.category');
    Route::post('/category/store', 'StoreCategory')->name('category.store');
    Route::get('/edit/category/{id}', 'EditCategory')->name('edit.category');
    Route::post('/update/category', 'UpdateCategory')->name('update.category');
    Route::get('/delete/category/{id}', 'DeleteCategory')->name('delete.category');
    Route::get('/category/subcategories/{id}', 'ShowSubcategories')->name('category.subcategories');
});
}); //End Middleware

//SubCategory
Route::middleware(['auth', 'role:admin'])->group(function(){
Route::controller(SubCategoryController::class)->group(function(){
    Route::get('/all/subcategory', 'AllSubCategory')->name('all.subcategory');
    Route::get('/add/subcategory', 'AddSubCategory')->name('add.subcategory');
    Route::post('/subcategory/store', 'StoreSubCategory')->name('subcategory.store');
    Route::get('/edit/subcategory/{id}', 'EditSubCategory')->name('edit.subcategory');
    Route::post('/update/subcategory/{id}', 'UpdateSubcategory')->name('update.subcategory');
    Route::get('/delete/subcategory/{id}', 'DeleteSubcategory')->name('delete.subcategory');
    Route::get('/subcategory/ajax/{category_id}' , 'GetSubCategory');

});
});


//Vendor Active/Inactive
Route::controller(VendorController::class)->group(function(){
    Route::get('/inactive/vendor', 'InactiveVendor')->name('inactive.vendor');
    Route::get('/active/vendor', 'ActiveVendor')->name('active.vendor');
    Route::get('/inactive/vendor/details/{id}', 'InactiveVendorDetails')->name('inactive.vendor.details');   
    Route::post('/active/vendor/approve' , 'ActiveVendorApprove')->name('active.vendor.approve'); 
    Route::get('/active/vendor/details/{id}', 'ActiveVendorDetails')->name('active.vendor.details');
    Route::post('/deactivate/vendor/approve' , 'DeactivateVendorApprove')->name('deactivate.vendor.approve');
  


});

//Products
Route::middleware(['auth', 'role:admin'])->group(function(){
Route::controller(ProductController::class)->group(function(){
    Route::get('/all/product', 'AllProduct')->name('all.product');
    Route::get('/add/product', 'AddProduct')->name('add.product');
    Route::post('/store/product', 'StoreProduct')->name('product.store');
    Route::get('/edit/product/{id}', 'EditProduct')->name('edit.product');
    Route::post('/update/product', 'UpdateProduct')->name('update.product');
    Route::post('/update/product/thumbnail', 'UpdateProductThumbnail')->name('update.product.thumbnail');
    Route::post('/update/product/multiimage', 'UpdateProductMultiImage')->name('update.product.multiimage');
    Route::get('/product/multiimage/delete/{id}', 'MultiImageDelete')->name('product.multiimg.delete');
    Route::get('/delete/product/{id}' , 'ProductDelete')->name('delete.product');
    Route::get('/product/inactive/{id}' , 'ProductInactive')->name('product.inactive');
    Route::get('/product/active/{id}' , 'ProductActive')->name('product.active');
});
}); 
//Slider
Route::controller(SliderController::class)->group(function(){
    Route::get('/all/slider', 'AllSliders')->name('all.slider');
    Route::get('/add/slider', 'AddSlider')->name('add.slider');
    Route::post('/slider/store', 'StoreSlider')->name('store.slider');
    Route::get('/edit/slider/{id}', 'EditSlider')->name('edit.slider');
    Route::post('/update/slider', 'UpdateSlider')->name('update.slider');
    Route::get('/delete/slider/{id}', 'DeleteSlider')->name('delete.slider');
    Route::get('/category/subcategories/{id}', 'ShowSubcategories')->name('category.subcategories');
});

//Banner
Route::controller(BannerController::class)->group(function(){
    Route::get('/all/banner', 'AllBanners')->name('all.banner');
    Route::get('/add/banner', 'AddBanner')->name('add.banner');
    Route::post('/banner/store', 'StoreBanner')->name('store.banner');
    Route::get('/edit/banner/{id}', 'EditBanner')->name('edit.banner');
    Route::post('/update/banner', 'UpdateBanner')->name('update.banner');
    Route::get('/delete/banner/{id}', 'DeleteBanner')->name('delete.banner');
    Route::get('/category/subcategories/{id}', 'ShowSubcategories')->name('category.subcategories');
});




