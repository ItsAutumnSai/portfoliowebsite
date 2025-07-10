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

        $imagePath = $request->file('image')->store('portfolios', 'public');

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
        Storage::disk('public')->delete($content->image_path);
        $content->delete();

        return back()->with('success', 'Content deleted successfully!');
    }
}