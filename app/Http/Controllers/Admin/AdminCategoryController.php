<?php
/********************************
Developer: Abdullah Alharbi, Iddrisu Musah
University ID: 230046409, 230222232
 ********************************/

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use Illuminate\Support\Facades\Storage;
class AdminCategoryController extends Controller
{
    /**
     * display a list of categories .
     */
    public function index()
    {

        $categories = Category::where('delete', 0)->orderBy('name')->get();
        return view('admin.categories.index', compact('categories')); }

    /**
     * show the form for creating a new category.
     */
    public function create()
    {
        return view('admin.categories.create');
    }

    /**
     * Store a new created category in storage.
     */
    public function store(Request $request)
    {
        $request->validate([

            'name' => 'required|string|max:20|unique:categories,name',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',

        ]);

        $imagePath = null;

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('categories', 'public');
        }

        $category = new Category();
        $category->name = $request->name;
        $category->description = $request->description;
        $category->image = $imagePath;
        $category->delete = 0;
        $category->save();

        return redirect()->route('admin.categories.index')

            ->with('success', 'Category created successfully');
    }

    /**
     * show the form for editing the chosen category.
     */
    public function edit(Category $category)
    {

        return view('admin.categories.edit', compact('category'));

    }

    /**
     * Update the chosen category in storage.
     */
    public function update(Request $request, Category $category)
    {
        $request->validate([
            'name' => 'required|string|max:20|unique:categories,name,' . $category->id,
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('image')) {

            if ($category->image) {
                Storage::disk('public')->delete($category->image);
            }


            $imagePath = $request->file('image')->store('categories', 'public');

            $category->image = $imagePath;
        }

        $category->name = $request->name;

        $category->description = $request->description;
        $category->save();

        return redirect()->route('admin.categories.index')
            ->with('success', 'Category updated successfully');
    }

    /**
     * Remove the chosen  category from storage.
     */

    public function destroy(Category $category)
    {

        if ($category->products()->count() > 0) {
            $category->delete = 1;
            $category->save();
            return redirect()->route('admin.categories.index')
                ->with('success', 'Category has been marked as deleted.');
        }

        
        if ($category->image) {
            Storage::disk('public')->delete($category->image);
        }

        $category->delete();

        return redirect()->route('admin.categories.index')
            ->with('success', 'Category has been permanently deleted.');
    }
}
