<?php

namespace App\Http\Controllers\Admin;

use App\Models\Tag;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class TagController extends Controller
{
    public function index()
    {
        return view('admin.tags.index', ['tags' => Tag::paginate(30)]);
    }

    public function create()
    {
        return view('admin.tags.create');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:150',
        ]);
        $valid = $validator->validated();
        if ($valid) {
            $n_tag = new Tag;
            $n_tag->name = $valid['name'];
            $n_tag->save();
            return redirect()->route('admin.tags.index');
        } else {
            return back()->route('admin.tags.create');
        }
    }

    public function show($id)
    {
        //
    }

    public function edit(Tag $tag)
    {
        return view('admin.tags.edit', compact('tag'));
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:150',
        ]);
        $valid = $validator->validated();
        if ($valid && ($u_tag = Tag::find($id))) {;
            $u_tag->name = $valid['name'];
            $u_tag->save();
            return redirect()->route('admin.tags.index');
        }
        return redirect()->route('admin.tags.edit');
    }

    public function destroy(Tag $tag)
    {
        foreach ($tag->posts as $post) $post->tags()->detach($tag);
        if (!$tag->posts()->count()) $tag->delete();
        return redirect()->route('admin.tags.index');
    }
}
