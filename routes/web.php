<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DemoController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Home\BlogController;
use App\Http\Controllers\Home\AboutController;
use App\Http\Controllers\Home\FooterController;
use App\Http\Controllers\Home\ContactController;
use App\Http\Controllers\Home\PortfolioController;
use App\Http\Controllers\Home\HomeSliderController;
use App\Http\Controllers\Home\BlogCategoryController;

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

// Route::get('/', function () {
//     return view('frontend.index');
// })->name('Home');

//
Route::controller(DemoController::class)->group(function(){
    Route::get('/','homePage')->name('Home'); // home page

});

Route::get('/dashboard', function () {
    return view('admin.index');
})->middleware(['auth', 'verified'])->name('dashboard');


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Admin All Route
Route::middleware(['auth'])->group(function () {
    Route::controller(AdminController::class)->group(function(){
        Route::get('/admin/logout','destroy')->name('admin.logout');
        Route::get('/admin/porfile','profile')->name('admin.profile');
        Route::get('/edit/profile','editProfile')->name('edit#profile'); // admin data update page
        Route::post('/store/profile','storeProfile')->name('store#profile'); // admin data update
        Route::get('/admin/changePassword','changePassword')->name('admin#changePassword'); // admin password change
        Route::post('/admin/updatePassword','updatePassword')->name('admin#updatePassword'); // admin password update
    });
});



// Home Slide Route
Route::controller(HomeSliderController::class)->group(function(){
    Route::get('/homeSlide','homeSlider')->name('home#slide'); // go to home slide page
    Route::post('/updateSlide','updateSlider')->name('update#slide'); //update home slide

});

// About Page Route
Route::controller(AboutController::class)->group(function(){
    Route::get('/about','aboutPage')->name('about#page'); // go for update about page from backend
    Route::post('/updateAbout','UpdateAbout')->name('update#about'); // update about data form backend
    Route::get('/home/about','homeAboutPage')->name('home#about'); // go to about page form frontend
    Route::get('/about/multiImage','aboutMulti')->name('about#multiImages'); // go to about multi image form backend
    Route::post('/store/mulitImages','storeMulitImages')->name('store#multiImages'); //  multiImage to store database
    Route::get('/all/multiImage','allMultiImages')->name('all#multiImages'); // all multi image page backend
    Route::get('/edit/multiImage/{id}','editMultiImages')->name('edit#multiImage'); // edit multi image page
    Route::post('/update/multiImage','updateMultiImages')->name('update#multiImages'); // update multi image page
    Route::get('/delete/multiImage/{id}','deleteMultiImages')->name('delete#multiImage'); // delete multi image page

});

// Portfolio All Route
Route::controller(PortfolioController::class)->group(function(){
    Route::get('/all/portfolio','allPortfolio')->name('all#portfolio');// all portfolio page backend
    Route::get('/add/portfolio','addPortfolio')->name('add#portfolio');// add portfolio page
    Route::post('/store/portfolio','storePortfolio')->name('store#portfolio');// store portfolio to database
    Route::get('/edit/portfolio/{id}','editPortfolio')->name('edit#portfolio');// edit portfolio page
    Route::post('/update/portfolio','updatePortfolio')->name('update#portfolio');// update portfolio to database
    Route::get('/delete/portfolio/{id}','deletePortfolio')->name('delete#portfolio');// delete portfolio page
    Route::get('/details/portfolio/{id}','detailPortfolio')->name('detail#portfolio');// details portfolio page (frontend)
    Route::get('/home/portfolio','HomePortfolio')->name('home#portfolio');// home portfolio page (frontend)


});

// Blog Category All Route
Route::controller(BlogCategoryController::class)->group(function(){
    Route::get('all/BlogCategory','allBlogCategory')->name('all#BlogCategory');// all blog category page
    Route::get('add/BlogCategory','addBlogCategory')->name('add#BlogCategory');// add blog category page
    Route::post('store/BlogCategory','storeBlogCategory')->name('store#blogCategory');// store blog category page
    Route::get('edit/BlogCategory/{id}','editBlogCategory')->name('edit#blogCategory'); // edit blog category page
    Route::post('update/BlogCategory','updateBlogCategory')->name('update#blogCategory'); // update blog category to db
    Route::get('delete/BlogCategory/{id}','deleteBlogCategory')->name('delete#blogCategory'); // delete blog category from db

});

// Blog All Route
Route::controller(BlogController::class)->group(function(){
    Route::get('/all/blog','allBlog')->name('all#blog'); // all blog page
    Route::get('/add/blog','addBlog')->name('add#blog'); // add blog page
    Route::post('/store/blog','storeBlog')->name('store#blog'); // store blog
    Route::get('/edit/blog/{id}','editBlog')->name('edit#blog'); // edit blog
    Route::post('/update/blog','updateBlog')->name('update#blog'); // update blog
    Route::get('/delete/blog/{id}','deleteBlog')->name('delete#blog'); // delete blog

    Route::get('detail/blog/{id}','detailBlog')->name('detail#blog'); // detail blog for frontend
    Route::get('/category/blog/{id}','categoryBlog')->name('category#blog'); // blog by category
    Route::get('/blog','homeBlog')->name('home#blog');// home blog page

});

// Footer All Route
Route::controller(FooterController::class)->group(function(){
    Route::get('/setup/footer','setupFooter')->name('setup#footer'); // footer setup page
    Route::post('/update/footer','updateFooter')->name('update#footer'); // update footer data

});

// Contact All Route
Route::controller(ContactController::class)->group(function(){
    Route::get('/contact','contactMe')->name('contact#me'); // contact page
    Route::post('/store/message','storeMessage')->name('store#message'); // store message
    Route::get('/contact/message','contactMessage')->name('contact#message'); // contact message ______backend
    Route::get('/delete/message/{id}','DeleteMessage')->name('delete#message'); // contact message delete ____backend


});

require __DIR__.'/auth.php';
