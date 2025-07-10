<?php

namespace App\Http\Controllers;

use App\Models\Portfolio;
use App\Models\Content;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PortfolioController extends Controller
{
    /**
     * Display the home page with all portfolios.
     */
    public function index()
    {
        $portfolios = Portfolio::with('firstContent')->get();
        return view('home', compact('portfolios'));
    }

    /**
     * Display a specific portfolio.
     */
    public function show($id)
    {
        $portfolio = Portfolio::with(['contents', 'comments.user'])->findOrFail($id);
        return view('portfolio.show', compact('portfolio'));
    }

    /**
     * Show the admin dashboard.
     */
    public function admin()
    {
        if (!auth()->check() || !auth()->user()->is_admin) {
            return redirect('/login');
        }

        $portfolios = Portfolio::with('contents')->get();
        return view('admin.dashboard', compact('portfolios'));
    }

    /**
     * Show the create portfolio form.
     */
    public function create()
    {
        if (!auth()->check() || !auth()->user()->is_admin) {
            abort(403);
        }

        return view('admin.create');
    }

    /**
     * Store a new portfolio.
     */
    public function store(Request $request)
    {
        if (!auth()->check() || !auth()->user()->is_admin) {
            abort(403);
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'contents' => 'required|array|min:1',
            'contents.*.image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'contents.*.description' => 'required|string',
        ]);

        $portfolio = Portfolio::create([
            'title' => $request->title,
        ]);

        foreach ($request->contents as $contentData) {
            $imagePath = $contentData['image']->store('portfolios', 'public');
            
            Content::create([
                'portfolio_id' => $portfolio->id,
                'image_path' => $imagePath,
                'description' => $contentData['description'],
            ]);
        }

        return redirect()->route('admin.dashboard')->with('success', 'Portfolio created successfully!');
    }

    /**
     * Show the edit portfolio form.
     */
    public function edit($id)
    {
        if (!auth()->check() || !auth()->user()->is_admin) {
            abort(403);
        }

        $portfolio = Portfolio::with('contents')->findOrFail($id);
        return view('admin.edit', compact('portfolio'));
    }

    /**
     * Update the specified portfolio.
     */
    public function update(Request $request, $id)
    {
        if (!auth()->check() || !auth()->user()->is_admin) {
            abort(403);
        }

        $portfolio = Portfolio::findOrFail($id);

        $request->validate([
            'title' => 'required|string|max:255',
        ]);

        $portfolio->update([
            'title' => $request->title,
        ]);

        return redirect()->route('admin.dashboard')->with('success', 'Portfolio updated successfully!');
    }

    /**
     * Remove the specified portfolio.
     */
    public function destroy($id)
    {
        if (!auth()->check() || !auth()->user()->is_admin) {
            abort(403);
        }

        $portfolio = Portfolio::findOrFail($id);
        
        // Delete associated images
        foreach ($portfolio->contents as $content) {
            Storage::disk('public')->delete($content->image_path);
        }
        
        $portfolio->delete();

        return redirect()->route('admin.dashboard')->with('success', 'Portfolio deleted successfully!');
    }

    /**
     * Add a comment to a portfolio.
     */
    public function addComment(Request $request, $id)
    {
        if (!auth()->check()) {
            return redirect('/login');
        }

        $request->validate([
            'comment' => 'required|string|max:1000',
        ]);

        Comment::create([
            'portfolio_id' => $id,
            'user_id' => auth()->id(),
            'comment' => $request->comment,
        ]);

        return back()->with('success', 'Comment added successfully!');
    }
}