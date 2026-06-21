<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::orderBy('sort_order')->orderBy('name_en')->get();
        return view('admin.categories.index', compact('categories'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name_en'    => 'required|string|max:100|unique:categories,name_en',
            'name_ar'    => 'required|string|max:100',
            'image'      => 'required|image|max:4096',
            'span'       => 'required|string|max:50',
            'sort_order' => 'nullable|integer|min:0',
        ]);

        $data['slug']        = $this->uniqueSlug($data['name_en']);
        $data['image']       = $request->file('image')->store('categories', 'public');
        $data['sort_order']  = $request->input('sort_order', 0);

        Category::create($data);

        return redirect()->route('admin.categories.index')
            ->with('success', "Category \"{$data['name_en']}\" created.");
    }

    public function update(Request $request, Category $category)
    {
        $data = $request->validate([
            'name_en'    => 'required|string|max:100|unique:categories,name_en,' . $category->id,
            'name_ar'    => 'required|string|max:100',
            'image'      => 'nullable|image|max:4096',
            'span'       => 'required|string|max:50',
            'sort_order' => 'nullable|integer|min:0',
        ]);

        if ($request->hasFile('image')) {
            Storage::disk('public')->delete($category->image);
            $data['image'] = $request->file('image')->store('categories', 'public');
        } else {
            unset($data['image']);
        }

        $category->update($data);

        return redirect()->route('admin.categories.index')
            ->with('success', "Category \"{$category->name_en}\" updated.");
    }

    public function destroy(Category $category)
    {
        Storage::disk('public')->delete($category->image);
        $name = $category->name_en;
        $category->delete();

        return redirect()->route('admin.categories.index')
            ->with('success', "Category \"{$name}\" deleted.");
    }

    private function uniqueSlug(string $name): string
    {
        $base = Str::slug($name);
        $slug = $base;
        $i = 1;

        while (Category::where('slug', $slug)->exists()) {
            $slug = $base . '-' . ++$i;
        }

        return $slug;
    }
}
