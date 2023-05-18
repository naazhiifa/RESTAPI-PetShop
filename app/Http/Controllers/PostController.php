<?php

namespace App\Http\Controllers;

use App\Http\Resources\PostDetailResource;
use App\Http\Resources\PostResource;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    public function index()
    {
        $posts = Post::All();
        return PostDetailResource::collection($posts->loadMissing('seller:id,username'));
    }

    public function show($id) {
        $post = Post::with('seller:id,username')->findOrFail($id);
        return new PostDetailResource($post->loadMissing('seller:id,username'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'Product' => 'required|max:255',
            'Price' => 'required',
            'Description' => 'required',
        ]);

        if ($request->file){

            $fileName = $this->generateRandomString();
            $extension = $request->file->extension();

            Storage::putFileAs('image', $request->file, $fileName.'.'.$extension);
        }

        $request['image']= $fileName.'.'.$extension;

        $request['Branch'] = Auth::user()->id;
        $post = Post::create($request->all());
        return new PostDetailResource($post->loadMissing('seller:id,username'));

        }


    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'Product' => 'required|max:255',
            'Price' => 'required',
            'Description' => 'required',
        ]);

        $post = Post::findOrFail($id);
        $post->update($request->all());
        return new PostDetailResource($post->loadMissing('seller:id,username')); 
    }

    public function destroy($id)
    {
        $post =  Post::findOrFail($id);
        $post->delete();

        return new PostDetailResource($post->loadMissing('seller:id,username'));
    }

    function generateRandomString($length = 30) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[random_int(0, $charactersLength - 1)];
        }
        return $randomString;
    }
}
