<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;
use Inertia\Response;
use Intervention\Image\Facades\Image;

class CategoryController extends Controller
{
    public function index(): Response
    {
        return Inertia::render('Admin/Categories', [
            'categories' => Category::all(),
        ]);
    }

    public function update(Category $category)
    {
        $category->update(request()->validate([
            'display_name' => 'required',
        ]));

        return redirect()->back();
    }

    public function uploadImage(Category $category)
    {
        request()->validate([
            'image' => 'required|image',
        ]);

        $imageName = $category->name.'.jpg';

        $image = Image::make(request()->image)->fit(300, 300, function ($constraint) {
            $constraint->aspectRatio();
            $constraint->upsize();
        })->encode('jpg');

        Storage::disk('public')->put('images/'.$imageName, (string) $image);

        $category->update([
            'image' => $imageName,
        ]);

        return response()->json(['message' => 'Image uploaded successfully', 'image' => $imageName, 'severity' => 'success', 'title' => 'Success'], 200);
    }
}
