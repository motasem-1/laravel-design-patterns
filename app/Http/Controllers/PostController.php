<?php

namespace App\Http\Controllers;

use App\Repository\PostRepoInterface;
use Illuminate\Http\Request;

class PostController extends Controller
{
            
    protected $post;
    public function __construct(PostRepoInterface $post)
    {
        $this->middleware('auth'); /// authentication  
        $this->post = $post;  /// connect Repo with controller
    }

    public function index()
    {
        return $this->post->index();
    } // end index fun ...


    public function store(Request $request)
    {
        return $this->post->store($request);
    } // end store fun ...



    public function update(Request $request, $id)
    {
        return $this->post->update($request, $id);
    } // end update fun ...



    public function multi_delete(Request $request)
    {
        return $this->post->multi_delete($request);
    }
}