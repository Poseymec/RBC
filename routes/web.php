<?php



use Laravel\Fortify\Fortify;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AvisController;
use App\Http\Controllers\RoleController;
use Spatie\Permission\Models\permission;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\PromoController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\SliderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CommandeController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\RegisteredUserController;
use App\Http\Controllers\RolePermissionController;
use Illuminate\Auth\Middleware\EnsureEmailIsVerified;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\NewsletterController;
//use Laravel\Fortify\Http\Middleware\EnsureEmailIsVerified;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

/*Route::get('/welcome', function () {
    return view('welcome');
});*/



/*route vers le controller client */

        Route::get('/',[ClientController::class , 'home']);
        Route::get('/store',[ClientController::class , 'store']);
        //Route::get('/checkout',[ClientController::class , 'checkout']);
        Route::get('/productdetail/{id}',[ClientController::class , 'productdetail']);
        Route::get('/rechercheclient',[ClientController::class , 'rechercheclient']);
        //Route::get('/notationproduit/{id}',[ClientController::class,'notationproduit']);
        //Route::get('/commandeproduit/{id}',[CommandeController::class,'commandeproduit']);

        //Route::post('/client/saveAvis',[AvisController::class,'saveAvis']);
        //route vers aviscontroller





Route::middleware(['auth.session','password.confirm','CheckRoles:Admin,super-Admin'])->group(function () {
    //routes vers les roles et les permissions

    Route::middleware(['super-Admin'])->group(function(){



        Route::post('/admin/createrole',[RoleController::class,'createrole']);
        Route::post('/admin/saveassignment',[RolePermissionController::class,'saveassignment']);
        Route::get('/admin/editerole/{id}',[RoleController::class,'editerole']);
        Route::put('admin/updaterole/{id}',[RoleController::class,'updaterole']);
        Route::get('/admin/deleterole/{id}',[RoleController::class,'deleterole']);
        Route::delete('/admin/yesdeleterole/{id}',[RoleController::class,'yesdeleterole']);
        //Route::get('/checkrole',[RoleController::class,'checkRole']);

        Route::post('/admin/createpermission',[PermissionController::class,'createpermission']);
        Route::get('/admin/editepermission/{id}',[PermissionController::class,'editepermission']);
        Route::put('admin/updatepermission/{id}',[PermissionController::class,'updatepermission']);
        Route::get('/admin/deletepermission/{id}',[PermissionController::class,'deletepermission']);
        Route::delete('/admin/yesdeletepermission/{id}',[PermissionController::class,'yesdeletepermission']);



        //route vers resgisteruserVontroller



        Route::get('/admin/deleteuser/{id}',[RegisteredUserController::class,'deleteuser']);
        Route::delete ('/admin/yesdeleteuser/{id}',[RegisteredUserController::class,'yesdeleteuser']);
        Route::get('/admin/editeroleuser/{id}',[RegisteredUserController::class,'editeroleuser']);
        Route::post('/admin/assignroleuser/{id}',[RegisteredUserController::class,'assignroleuser']);

        //Route::get('/admin/checkpermission',[PermissionController::class,'checkPermission']);

    });
    /**route vers le controller admin */
    //middleware


    Route::get('/admin',[AdminController::class,'home']);
    Route::get('/admin/addcategory',[AdminController::class,'addcategory']);
    Route::get('/admin/category',[AdminController::class,'category']);
    Route::get('/admin/addslider',[AdminController::class,'addslider']);
    Route::get('/admin/slider',[AdminController::class,'slider']);
    Route::get('/admin/addproduct',[AdminController::class,'addproduct']);
    Route::get('/admin/product',[AdminController::class,'product']);
    Route::get('/admin/promo',[AdminController::class,'promo']);
    Route::get('/admin/addpromo',[AdminController::class,'addpromo']);
    Route::get('/admin/userregister',[AdminController::class,'userregister']);
    Route::get('/admin/review',[AdminController::class,'review']);
    Route::get('/admin/roles',[AdminController::class,'roles']);
    Route::get('/admin/permissions',[AdminController::class,'permissions']);
    Route::get('/admin/assignroletopermission',[AdminController::class,'assignroletopermission']);

    //route vers les categotirs controller


    Route::post('/admin/savecategory',[CategoryController::class,'savecategory']);
    Route::get('/admin/deletecategory/{id}',[CategoryController::class,'deletecategory']);
    Route::delete('/admin/yesdeletecategory/{id}',[CategoryController::class,'yesdeletecategory']);
    Route::get('/admin/editecategory/{id}',[CategoryController::class,'editecategory']);
    Route::put('admin/updatecategory/{id}',[CategoryController::class,'updatecategory']);



    //route vers les sliders controller

    Route::post('/admin/saveslider',[SliderController::class,'saveslider']);
    Route::get('/admin/deleteslider/{id}',[SliderController::class,'deleteslider']);
    Route::delete('/admin/yesdeleteslider/{id}',[SliderController::class,'yesdeleteslider']);
    Route::get('/admin/editeslider/{id}',[SliderController::class,'editeslider']);
    Route::put('/admin/updateslider/{id}',[SliderController::class,'updateslider']);
    Route::put('/admin/unactivateslider/{id}',[SliderController::class,'unactivateslider']);
    Route::put('/admin/activateslider/{id}',[SliderController::class,'activateslider']);


    //route vers les products controller


    Route::post('/admin/saveproduct/',[ProductController::class,'saveproduct']);
    Route::get('/admin/editeproduct/{id}',[ProductController::class,'editeproduct']);
    Route::put('/admin/unactivateproduct/{id}',[ProductController::class,'unactivateproduct']);
Route::put('/admin/activateproduct/{id}',[ProductController::class,'activateproduct']);
Route::get('/admin/deleteproduct/{id}',[ProductController::class,'deleteproduct']);
Route::delete('/admin/yesdeleteproduct/{id}',[ProductController::class,'yesdeleteproduct']);
Route::get('/admin/deleteproductimage/{id}',[ProductController::class,'deleteproductimage']);
Route::delete('/admin/yesdeleteproductimage/{id}',[ProductController::class,'yesdeleteproductimage']);
Route::put('admin/updateproduct/{id}',[ProductController::class,'updateproduct']);


//route vers les promo controller


Route::post('/admin/savepromo/',[PromoController::class,'savepromo']);
Route::get('/admin/editepromo/{id}',[PromoController::class,'editepromo']);
Route::put('/admin/updatepromo/{id}',[PromoController::class,'updatepromo']);
Route::get('/admin/deletepromo/{id}',[PromoController::class,'deletepromo']);
Route::delete('/admin/yesdeletepromo/{id}',[PromoController::class,'yesdeletepromo']);
Route::put('/admin/unactivatepromo/{id}',[PromoController::class,'unactivatepromo']);
Route::put('/admin/activatepromo/{id}',[PromoController::class,'activatepromo']);

Route::put('/admin/unactivateAvi/{id}',[AvisController::class,'unactivateAvi']);
Route::put('/admin/activateAvi/{id}',[AvisController::class,'activateAvi']);
Route::delete('/admin/deleteAvi/{id}',[AvisController::class,'deleteAvi']);


// router vers contact et newsletter
Route::get('/admin/contact',[AdminController::class,'contact']);
Route::get('/admin/newsletter',[AdminController::class,'newsletter']);
Route::get('/admin/deletecontact/{id}',[AdminController::class,'deletecontact']);
Route::delete('/admin/yesdeletecontact/{id}',[AdminController::class,'yesdeletecontact']);
Route::get('/admin/deletenewsletter/{id}',[AdminController::class,'deletenewsletter']);
Route::delete('/admin/yesdeletenewsletter/{id}',[AdminController::class,'yesdeletenewsletter']);




});
//require __DIR__.'/vendor/laravel/fortify/routes/routes.php';


// Formulaire de contact
Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');

// Formulaire de newsletter
Route::post('/newsletter', [NewsLetterController::class, 'store'])->name('newsletter.store');
