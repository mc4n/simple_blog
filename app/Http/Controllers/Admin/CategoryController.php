<?php

namespace App\Http\Controllers\Admin;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    public function index()
    {
        return view('admin.categories.index', ['categories' => Category::paginate(30)]);
    }

    public function create()
    {
        return view('admin.categories.create');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:150',
        ]);
        $valid = $validator->validated();
        if ($valid) {
            $n_category = new Category;
            $n_category->name = $valid['name'];
            $n_category->save();
            return redirect()->route('admin.categories.index');
        } else {
            return back()->route('admin.categories.create');
        }
    }

    public function show($id)
    {
        //
    }

    public function edit(Category $category)
    {
        return view('admin.categories.edit', compact('category'));
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:150',
        ]);
        $valid = $validator->validated();
        if ($valid && ($u_category = Category::find($id))) {;
            $u_category->name = $valid['name'];
            $u_category->save();
            return redirect()->route('admin.categories.index');
        }
        return redirect()->route('admin.categories.edit');
    }

    public function destroy(Category $category)
    {
        if (!$category->posts()->count()) $category->delete();
        return redirect()->route('admin.categories.index');
    }
}
