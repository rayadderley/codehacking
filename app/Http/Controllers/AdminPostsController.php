<?php

namespace App\Http\Controllers;

use App\Category;
use App\CommentReply;
use Illuminate\Http\Request;
use App\Post;
use App\Photo;
use App\Http\Requests\PostsCreateRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class AdminPostsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = Post::all();
        return view('admin.posts.index', compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $categories = Category::lists('name', 'id')->all();

        return view('admin.posts.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param PostsCreateRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(PostsCreateRequest $request)
    {
        // Get the User that logged in
        $user = Auth::user();

        $input = $request->all();

        // Check if photo exist or not
        if($file = $request->file('photo_id')){
            // Check whether photo exist or not
            //return "photo available";

            $name = time() . $file->getClientOriginalName();

            $file->move('images', $name);

            $photo = Photo::create(['file'=>$name]);
            
            $input['photo_id'] = $photo->id;
        }

        $user->posts()->create($input);

        return redirect('/admin/posts');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $post = Post::findOrFail($id);
        $categories = Category::lists('name', 'id');
        return view('admin.posts.edit', compact('post' , 'categories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $input = $request->all();

        // Check if photo exist or not
        if($file = $request->file('photo_id')){
            // Check whether photo exist or not
            //return "photo available";

            $name = time() . $file->getClientOriginalName();

            $file->move('images', $name);

            $photo = Photo::create(['file'=>$name]);

            $input['photo_id'] = $photo->id;
        }

        // Updating the post of the user - not updating the post only - it should be thru the user
        Auth::user()->posts()->whereId($id)->first()->update($input);

        return redirect('/admin/posts');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // Find the post based on Id
        $post = Post::findOrFail($id);

        // Find the photo of the post to delete the photo together - unlink:delete
        unlink(public_path() . $post->photo->file);

        // Delete the post
        $post->delete();

        // Create Session to display Flash Message
        Session::flash('deleted_post', 'The post has been deleted');

        return redirect('/admin/posts');
    }


    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function post($id)
    {
        $post = Post::findOrFail($id);

        $comments = $post->comments()->whereIsActive(1)->get();

        return view('post', compact('post', 'comments', 'replies'));
    }
}
