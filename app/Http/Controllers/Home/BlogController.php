<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\BlogCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Image;

class BlogController extends Controller
{
    // all blog page
    public function allBlog()
    {
        $allBlog = Blog::latest()->get();

        return view('admin.blog.all_blog', compact('allBlog'));
    } // end blog

    // add blog page
    public function addBlog()
    {
        $category = BlogCategory::orderBy('blog_category', 'ASC')->get(); // category data in table
        return view('admin.blog.add_blog', compact('category'));

    } // end blog

    // store blog data to db
    public function storeBlog(Request $request)
    {
        $image = $request->file('blogImage');
        $name_gen =
        hexdec(uniqid()) . '.' . $image->getClientOriginalExtension(); // 132345.jpg

        Image::make($image)
            ->resize(430, 327)
            ->save('upload/blog_images/' . $name_gen); // resize with image

        $save_url = 'upload/blog_images/' . $name_gen; // create image path

        // store in database
        Blog::insert([
            'blog_category_id' => $request->blogCategoryId,
            'blog_title' => $request->blogTitle,
            'blog_image' => $save_url,
            'blog_tag' => $request->blogTag,
            'blog_description' => $request->blogDescription,
            'created_at' => Carbon::now(),
        ]);

        $noti = [
            'message' => 'Blog Inserted Successfully',
            'alert-type' => 'success',
        ];

        return redirect()
            ->route('all#blog')
            ->with($noti);
    } // end method

    // edit blog
    public function editBlog($id)
    {
        $blogs = Blog::findOrFail($id);
        $category = BlogCategory::orderBy('blog_category', 'ASC')->get(); // category data in table
        return view('admin.blog.edit_blog', compact('blogs', 'category'));

    } // end blog

    // update blog
    public function updateBlog(Request $request)
    {
        $blog_id = $request->id;

        if ($request->file('blogImage')) {
            $image = $request->file('blogImage');
            $name_gen =
            hexdec(uniqid()) . '.' . $image->getClientOriginalExtension(); // 132345.jpg

            Image::make($image)
                ->resize(430, 327)
                ->save('upload/blog_images/' . $name_gen); // resize with image

            $save_url = 'upload/blog_images/' . $name_gen; // create image path

            // store in database
            Blog::findorFail($blog_id)->update([
                'blog_category_id' => $request->blogCategoryId,
                'blog_title' => $request->blogTitle,
                'blog_image' => $save_url,
                'blog_tag' => $request->blogTag,
                'blog_description' => $request->blogDescription,
            ]);
            $noti = [
                'message' => 'Blog Updated with Image Successfully',
                'alert-type' => 'success',
            ];

            return redirect()
                ->route('all#blog')
                ->with($noti);
        } else {
            // store in database
            Blog::findorFail($blog_id)->update([
                'blog_category_id' => $request->blogCategoryId,
                'blog_title' => $request->blogTitle,
                'blog_tag' => $request->blogTag,
                'blog_description' => $request->blogDescription,
            ]);
            $noti = [
                'message' => 'Blog Updated without Image Successfully',
                'alert-type' => 'success',
            ];
            return redirect()
                ->route('all#blog')
                ->with($noti);
        } // end else
    } // end method

     // delete Blog
     public function deleteBlog($id){
        $blog = Blog::findOrFail($id);
        $image = $blog->blog_image;
        unlink($image);

        Blog::findOrFail($id)->delete();

        $noti = [
            'message' => 'Blog Data Deleted Successfully',
            'alert-type' => 'success',
        ];
        return redirect()
        ->back()
        ->with($noti);

    }// end method

    // detail blog for frontend
    public function detailBlog($id){
        $allblogs= Blog::latest()->limit(5)->get();
        $blog = Blog::findOrFail($id);
        $category = BlogCategory::orderBy('blog_category', 'ASC')->get(); // category data in table
        return view('frontend.detail_blog',compact('blog','allblogs','category'));
    }//end method

    // category blog
    public function categoryBlog($id){
        $blogpost = Blog::where('blog_category_id',$id)->orderBy('id','DESC')->get();
        $allblogs= Blog::latest()->limit(5)->get();
        $category = BlogCategory::orderBy('blog_category', 'ASC')->get(); // category data in table
        $categoryname = BlogCategory::findOrFail($id);

        return view('frontend.category_blog_details',compact('blogpost','allblogs','category','categoryname'));
    }// end method

    // home blog
    public function homeBlog(){
        $allblogs = Blog::latest()->paginate(3);
        $category = BlogCategory::orderBy('blog_category', 'ASC')->get();

        return view('frontend.blog',compact('allblogs','category'));
    } // end method
}
