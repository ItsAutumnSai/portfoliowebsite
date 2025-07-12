<?php

namespace App\Http\Controllers;

use App\Models\Content;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ContentController extends Controller
{
    /**
     * Store a new content for a portfolio.
     */
    public function store(Request $request, $portfolioId)
    {
        if (!auth()->check() || !auth()->user()->is_admin) {
            abort(403);
        }

        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'description' => 'required|string',
        ]);

        // Store directly in public/storage/portfolios
        $image = $request->file('image');
        $imageName = time() . '_' . $image->getClientOriginalName();
        
        // Ensure the directory exists
        $uploadPath = public_path('storage/portfolios');
        if (!file_exists($uploadPath)) {
            mkdir($uploadPath, 0755, true);
        }
        
        // Move the file to public/storage/portfolios
        $image->move($uploadPath, $imageName);
        
        // Store relative path in database
        $imagePath = 'portfolios/' . $imageName;

        Content::create([
            'portfolio_id' => $portfolioId,
            'image_path' => $imagePath,
            'description' => $request->description,
        ]);

        return back()->with('success', 'Content added successfully!');
    }

    /**
     * Remove the specified content.
     */
    public function destroy($id)
    {
        if (!auth()->check() || !auth()->user()->is_admin) {
            abort(403);
        }

        $content = Content::findOrFail($id);
        
        // Delete from public/storage instead of storage/app/public
        $filePath = public_path('storage/' . $content->image_path);
        if (file_exists($filePath)) {
            unlink($filePath);
        }
        
        $content->delete();

        return back()->with('success', 'Content deleted successfully!');
    }
}