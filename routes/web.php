<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    AdminController,
    ClientController,
    ProductController,
    CategoryController,
    SliderController,
    PromoController,
    AvisController,
    ContactController,
    NewsletterController,
    RegisteredUserController,
    RoleController,
    PermissionController,
    RolePermissionController,
    CommandeController
};

/*
|--------------------------------------------------------------------------
| Routes publiques (côté client)
|--------------------------------------------------------------------------
*/

Route::get('/', [ClientController::class, 'home'])->name('home');
Route::get('/store', [ClientController::class, 'store'])->name('store');
Route::get('/productdetail/{id}', [ClientController::class, 'productdetail'])->name('product.detail');
Route::get('/rechercheclient', [ClientController::class, 'rechercheclient'])->name('client.search');
Route::get('/commandeproduit/{id}', [CommandeController::class, 'commandeproduit'])->name('commande.produit');

// Contact & Newsletter (publiques)
Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');
Route::post('/newsletters', [NewsletterController::class, 'store'])->name('newsletter.store');

/*
|--------------------------------------------------------------------------
| Routes admin (protégées)
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'password.confirm', 'CheckRoles:Admin,super-Admin'])->prefix('admin')->group(function () {

    // === Dashboard ===
    Route::get('/', [AdminController::class, 'home'])->name('admin.dashboard');

    // === Produits ===
    Route::get('/product', [AdminController::class, 'product'])->name('admin.product');
    Route::get('/addproduct', [AdminController::class, 'addproduct'])->name('admin.addproduct');
    Route::post('/saveproduct', [ProductController::class, 'saveproduct'])->name('admin.saveproduct');
    Route::get('/editeproduct/{id}', [ProductController::class, 'editeproduct'])->name('admin.editeproduct');
    Route::put('/updateproduct/{id}', [ProductController::class, 'updateproduct'])->name('admin.updateproduct');
    Route::delete('/yesdeleteproduct/{id}', [ProductController::class, 'yesdeleteproduct'])->name('admin.yesdeleteproduct');
   // Route::get('/deleteproduct/{id}', [ProductController::class, 'deleteproduct'])->name('admin.deleteproduct');
    Route::delete('/admin/productimage/{id}', [ProductController::class, 'destroyProductImage'])->name('admin.productimage.destroy');
    Route::get('/detailproduit/{id}', [AdminController::class, 'detailproduit'])->name('admin.detailproduit');

    // Activation / Désactivation produits
    Route::put('/activateproduct/{id}', [ProductController::class, 'activateproduct'])->name('admin.activateproduct');
    Route::put('/unactivateproduct/{id}', [ProductController::class, 'unactivateproduct'])->name('admin.unactivateproduct');

    // === Catégories ===
    Route::get('/category', [AdminController::class, 'category'])->name('admin.category');
    Route::get('/addcategory', [AdminController::class, 'addcategory'])->name('admin.addcategory');
    Route::post('/savecategory', [CategoryController::class, 'savecategory'])->name('admin.savecategory');
    Route::get('/editecategory/{id}', [CategoryController::class, 'editecategory'])->name('admin.editecategory');
    Route::put('/updatecategory/{id}', [CategoryController::class, 'updatecategory'])->name('admin.updatecategory');
   // Route::get('/deletecategory/{id}', [CategoryController::class, 'deletecategory'])->name('admin.deletecategory');
    Route::delete('/yesdeletecategory/{id}', [CategoryController::class, 'yesdeletecategory'])->name('admin.yesdeletecategory');

    // === Sliders ===
    Route::get('/slider', [AdminController::class, 'slider'])->name('admin.slider');
    Route::get('/addslider', [AdminController::class, 'addslider'])->name('admin.addslider');
    Route::post('/saveslider', [SliderController::class, 'saveslider'])->name('admin.saveslider');
    Route::get('/editeslider/{id}', [SliderController::class, 'editeslider'])->name('admin.editeslider');
    Route::put('/updateslider/{id}', [SliderController::class, 'updateslider'])->name('admin.updateslider');
    Route::delete('/slider/{id}', [SliderController::class, 'destroy'])->name('admin.destroy');
    Route::delete('/yesdeleteslider/{id}', [SliderController::class, 'yesdeleteslider'])->name('admin.yesdeleteslider');
    Route::put('/activateslider/{id}', [SliderController::class, 'activateslider'])->name('admin.activateslider');
    Route::put('/unactivateslider/{id}', [SliderController::class, 'unactivateslider'])->name('admin.unactivateslider');

    // === Promotions ===
    Route::get('/promo', [AdminController::class, 'promo'])->name('admin.promo');
    Route::get('/addpromo', [AdminController::class, 'addpromo'])->name('admin.addpromo');
    Route::post('/savepromo', [PromoController::class, 'savepromo'])->name('admin.savepromo');
    Route::get('/editepromo/{id}', [PromoController::class, 'editepromo'])->name('admin.editepromo');
    Route::put('/updatepromo/{id}', [PromoController::class, 'updatepromo'])->name('admin.updatepromo');
    Route::get('/deletepromo/{id}', [PromoController::class, 'deletepromo'])->name('admin.deletepromo');
    Route::delete('/yesdeletepromo/{id}', [PromoController::class, 'yesdeletepromo'])->name('admin.yesdeletepromo');
    Route::put('/activatepromo/{id}', [PromoController::class, 'activatepromo'])->name('admin.activatepromo');
    Route::put('/unactivatepromo/{id}', [PromoController::class, 'unactivatepromo'])->name('admin.unactivatepromo');

    // === Avis ===
    Route::get('/review', [AdminController::class, 'review'])->name('admin.review');
    Route::put('/activateAvi/{id}', [AvisController::class, 'activateAvi'])->name('admin.activateAvi');
    Route::put('/unactivateAvi/{id}', [AvisController::class, 'unactivateAvi'])->name('admin.unactivateAvi');
    Route::delete('/deleteAvi/{id}', [AvisController::class, 'deleteAvi'])->name('admin.deleteAvi');

    // === Contacts & Newsletter ===
    Route::get('/contact', [AdminController::class, 'contact'])->name('admin.contact');
    Route::get('/detailcontact/{id}', [AdminController::class, 'detailcontact'])->name('admin.detailcontact');
    //Route::get('/deletecontact/{id}', [AdminController::class, 'deletecontact'])->name('admin.deletecontact');
    Route::delete('/yesdeletecontact/{id}', [ContactController::class, 'destroy'])->name('admin.contact.destroy');

    Route::get('/newsletter', [AdminController::class, 'newsletter'])->name('admin.newsletter');
    Route::get('/deletenewsletter/{id}', [AdminController::class, 'deletenewsletter'])->name('admin.deletenewsletter');
    Route::delete('/yesdeletenewsletter/{id}', [NewsletterController::class, 'destroy'])->name('admin.newsletter.destroy');

    // === Gestion des utilisateurs (réservé au super-Admin) ===
    Route::middleware(['super-Admin'])->group(function () {

        // Utilisateurs
        Route::get('/userregister', [AdminController::class, 'userregister'])->name('admin.userregister');
        Route::get('/deleteuser/{id}', [RegisteredUserController::class, 'deleteuser'])->name('admin.deleteuser');
        Route::delete('/yesdeleteuser/{id}', [RegisteredUserController::class, 'yesdeleteuser'])->name('admin.yesdeleteuser');
        Route::get('/editeroleuser/{id}', [RegisteredUserController::class, 'editeroleuser'])->name('admin.editeroleuser');
        Route::post('/assignroleuser/{id}', [RegisteredUserController::class, 'assignroleuser'])->name('admin.assignroleuser');

        // Rôles
        Route::get('/roles', [AdminController::class, 'roles'])->name('admin.roles');
        Route::post('/createrole', [RoleController::class, 'createrole'])->name('admin.createrole');
        Route::get('/editerole/{id}', [RoleController::class, 'editerole'])->name('admin.editerole');
        Route::put('/updaterole/{id}', [RoleController::class, 'updaterole'])->name('admin.updaterole');
        Route::get('/deleterole/{id}', [RoleController::class, 'deleterole'])->name('admin.deleterole');
        Route::delete('/yesdeleterole/{id}', [RoleController::class, 'yesdeleterole'])->name('admin.yesdeleterole');

        // Permissions
        Route::get('/permissions', [AdminController::class, 'permissions'])->name('admin.permissions');
        Route::post('/createpermission', [PermissionController::class, 'createpermission'])->name('admin.createpermission');
        Route::get('/editepermission/{id}', [PermissionController::class, 'editepermission'])->name('admin.editepermission');
        Route::put('/updatepermission/{id}', [PermissionController::class, 'updatepermission'])->name('admin.updatepermission');
        Route::get('/deletepermission/{id}', [PermissionController::class, 'deletepermission'])->name('admin.deletepermission');
        Route::delete('/yesdeletepermission/{id}', [PermissionController::class, 'yesdeletepermission'])->name('admin.yesdeletepermission');

        // Attribution rôle/permission
        Route::get('/assignroletopermission', [AdminController::class, 'assignroletopermission'])->name('admin.assignroletopermission');
        Route::post('/saveassignment', [RolePermissionController::class, 'saveassignment'])->name('admin.saveassignment');
    });
});
