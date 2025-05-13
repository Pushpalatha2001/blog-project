<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;

class BlogController extends Controller
{
        public function index()
    {
        $data = [];
        $data['page_title'] = 'Post All';
        $posts = Post::latest()->get();
        return view('backend.blog.index', compact('posts','data'))->with('page_title', $data['page_title']);
    }

    public function create()
    {
        $data = [];
        $data['page_title'] = 'Post Add';
        return view('backend.blog.create',compact('data'))->with('page_title', $data['page_title']);
    }
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,gif,svg|max:2048',
            'description' => 'required',
        ]);

        $imageName = null;

        if ($request->hasFile('image')) {
            // Get the original name or generate a custom name
            $imageName = time() . '.' . $request->image->extension();

            // Move to storage/app/public/images
            $request->image->storeAs('images', $imageName, 'public');
        }

        Post::create([
            'title' => $request->title,
            'image' => $imageName, // Just the filename
            'description' => $request->description,
        ]);

        return redirect('/')->with('success', 'Post added!');
    }
    public function edit($id)
    {
        $data = [];
        $data['page_title'] = 'Post - ' . $id;

        $post = Post::findOrFail($id);

        return view('backend.blog.edit', compact('post', 'data'))->with('page_title', $data['page_title']);
    }

    public function Update(Request $request)
    {
        $post = Post::findOrFail($request->id);

        if ($request->hasFile('image')) {
            $imageName = time() . '.' . $request->image->extension();
            $request->image->storeAs('images', $imageName, 'public');
            $post->image = $imageName;
        }

        $post->title = $request->title;
        $post->description = $request->description;

        $post->save();

        return redirect('/')->with('success', 'Post updated successfully!');
    }


}
