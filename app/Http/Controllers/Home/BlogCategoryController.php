<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use App\Models\BlogCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class BlogCategoryController extends Controller
{
    // all blog category
    public function allBlogCategory()
    {
        $allBlogCategory = BlogCategory::latest()->get();
        return view('admin.blog_category.all_blog_category', compact('allBlogCategory'));
    } // end method

    // add blog category
    public function addBlogCategory()
    {
        return view('admin.blog_category.add_blog_category');
    } // end method

    // store blog category
    public function storeBlogCategory(Request $request)
    {

        BlogCategory::insert([
            'blog_category' => $request->blogCategory,
            'created_at' => Carbon::now(),
        ]);
        $noti = [
            'message' => 'Blog Category Inserted Successfully',
            'alert-type' => 'success',
        ];
        return redirect()
            ->route('all#BlogCategory')
            ->with($noti);
    } // end method

    // edit page blog category
    public function editBlogCategory($id)
    {

        $blogCategory = BlogCategory::findOrFail($id);
        return view('admin.blog_category.edit_blog_category', compact('blogCategory'));
    } //end metod

    // update blog category to db
    public function updateBlogCategory(Request $request){
        $category_id = $request->id;

        BlogCategory::findOrFail($category_id)->update([
            'blog_category'=>$request->blogCategory,
        ]);
        $noti = [
            'message' => 'Blog Category update Successfully',
            'alert-type' => 'success',
        ];
        return redirect()
            ->route('all#BlogCategory')
            ->with($noti);
    } // end method

    // delete blog category form db
    public function deleteBlogCategory($id){
        BlogCategory::findOrFail($id)->delete();

        $noti = [
            'message' => 'Blog Category delete Successfully',
            'alert-type' => 'success',
        ];
        return redirect()
            ->route('all#BlogCategory')
            ->with($noti);
    }
}
