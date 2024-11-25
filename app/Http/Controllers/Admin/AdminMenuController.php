<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MenuItem;
use Illuminate\Http\Request;

class AdminMenuController extends Controller
{
    public function index()
    {
        // Fetch all menu items for admin
        $menuItems = MenuItem::all();
        return view('admin.menu.index', compact('menuItems'));
    }

    public function create()
    {
        return view('admin.menu.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Image validation
        ]);

        // Handle image upload (if any)
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('menu_images', 'public');
        }

        // Create menu item
        MenuItem::create([
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'image' => $imagePath ?? null,  // Save image path
        ]);

        return redirect()->route('admin.menu')->with('success', 'Menu item created successfully!');
    }

    public function edit(MenuItem $menuItem)
    {
        return view('admin.menu.edit', compact('menuItem'));
    }

    public function update(Request $request, MenuItem $menuItem)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Handle image upload (if any)
        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($menuItem->image) {
                unlink(storage_path('app/public/' . $menuItem->image));
            }
            $imagePath = $request->file('image')->store('menu_images', 'public');
        }

        $menuItem->update([
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'image' => $imagePath ?? $menuItem->image, // Update image if a new one is uploaded
        ]);

        return redirect()->route('admin.menu')->with('success', 'Menu item updated successfully!');
    }

    public function destroy(MenuItem $menuItem)
    {
        // Delete the image from storage if exists
        if ($menuItem->image) {
            unlink(storage_path('app/public/' . $menuItem->image));
        }

        $menuItem->delete();

        return redirect()->route('admin.menu')->with('success', 'Menu item deleted successfully!');
    }
}
