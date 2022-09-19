<?php

namespace App\Http\Controllers\Admin;

use App\Models\Tag;
use App\Models\Post;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class PostController extends Controller
{
    public function index()
    {
        $posts = Post::with('category')->paginate(30);

        return view('admin.posts.index', compact('posts'));
    }

    public function create()
    {
        $categories = Category::all();

        return view('admin.posts.create', compact('categories'));
    }

    public function rules()
    {
        return [
            'title'     => 'required',
            'image'     => 'nullable|image|dimensions:max_width=200,max_height=200',
            'body'      => 'required',
            'category'  => 'required|integer|exists:categories,id',
            'tags'      => 'required'
        ];
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), $this->rules());
        $valid = $validator->validated();
        if ($valid) {
            $tags = explode(',', $valid['tags']);

            $filename = $request->has('image') ? time() . '_' . $request->file('image')->getClientOriginalName() : null;

            $post = auth()->user()->posts()->create([
                'title' => $valid['title'],
                'image' => $filename ?? null,
                'body' => $valid['body'],
                'category_id' => $valid['category']
            ]);

            foreach ($tags as $tagName) {
                $tag = Tag::firstOrCreate(['name' => $tagName]);
                $post->tags()->attach($tag);
            }
            if ($filename) $request->file('image')->storeAs('uploads', $filename, 'public');

            return redirect()->route('admin.posts.index');
        } else {
            return back()->route('admin.posts.create');
        }
    }

    public function show($id)
    {
    }

    public function edit(Post $post)
    {
        $categories = Category::all();
        $tags = $post->tags->implode('name', ', ');
        return view('admin.posts.edit', compact('post', 'tags', 'categories'));
    }

    public function update(Request $request, Post $post)
    {
        $validator = Validator::make($request->all(), $this->rules());
        $valid = $validator->validated();
        if ($valid) {
            $tags = explode(',', $valid['tags']);

            $filename = $request->has('image') ? time() . '_' . $request->file('image')->getClientOriginalName() : null;

            $post->update([
                'title' => $valid['title'],
                'image' => $filename ?? $post->image,
                'body' => $valid['body'],
                'category_id' => $valid['category']
            ]);

            $newTags = [];
            foreach ($tags as $tagName) {
                $tag = Tag::firstOrCreate(['name' => $tagName]);
                array_push($newTags, $tag->id);
            }
            $post->tags()->sync($newTags);

            if ($filename) {
                Storage::delete('public/uploads/' . $post->image);
                $request->file('image')->storeAs('uploads', $filename, 'public');
            }

            return redirect()->route('admin.posts.index');
        } else {
            return back()->route('admin.posts.edit');
        }
    }

    public function destroy(Post $post)
    {
        if ($post->image)
            Storage::delete('public/uploads/' . $post->image);

        $post->tags()->detach();
        $post->delete();

        return redirect()->route('admin.posts.index');
    }
}
