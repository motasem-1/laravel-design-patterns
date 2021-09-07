<?php

namespace App\Repository;

use App\Post;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class PostRepo implements PostRepoInterface
{

        /// view data 
    public function index()
    {
        $posts = Post::orderBy('updated_at','desc')->get();
        return view('Post.index', compact('posts'));
    }

        /// save data in db
    public function store($request)
    {
        $request->validate([
            'title' => 'required',
            'body' => 'required',
        ]);

        Post::create([
            'title' => $request->title,
            'body' => $request->body,
            'user_id' => auth()->user()->id,
        ]);
        Session::flash('success', 'Post Saved successfully !!');
        return redirect()->back();
    }
    public function update($request, $id)
    {
        $request->validate([
            'title' => 'required',
            'body' => 'required',
        ]);

        $posts = Post::find($id);
        $posts->update([

            'title' => $request->title,
            'body' => $request->body,
            'user_id' => auth()->user()->id,
        ]);
        Session::flash('success', 'Post Updated successfully !!');
        return redirect()->back();
    }
 
  
    public function multi_delete($request)
    {
            $ids = $request->ids;
            Post::whereIn('id', explode(",", $ids))->delete();
            return response()->json(['status' => true, 'message' => "POSTS deleted successfully."]);
        }
   
}