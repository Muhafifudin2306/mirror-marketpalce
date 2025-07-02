<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BlogController extends Controller
{

    public function index()
    {
        $blogs = Blog::latest()->get();
        return view('adminpage.blogs.index', compact('blogs'));
    }

    public function articles(Request $request)
    {
        $query = Blog::query();
        
        $filter = $request->get('filter', 'semua');
        if ($filter !== 'semua') {
            // $query->where('type', $filter);
        }
        
        $sort = $request->get('sort', 'terbaru');
        if ($sort === 'terlama') {
            $query->oldest();
        } else {
            $query->latest();
        }
        
        $blogs = $query->paginate(12);
        
        return view('landingpage.articles', compact('blogs', 'filter', 'sort'));
    }
    
    // Method untuk menampilkan detail artikel
    public function show($slug)
    {
        $blog = Blog::where('slug', $slug)->firstOrFail();
        return view('landingpage.article-detail', compact('blog'));
    }

    public function create()
    {
        return view('adminpage.blogs.form');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'nullable',
            'content' => 'nullable',
            'banner' => 'nullable',
        ]);

        $bannerPath = $request->file('banner')?->store('banners', 'public');

        Blog::create([
            'slug' => Str::slug($request->title) . '-' . uniqid(),
            'content' => $request->content,
            'title' => $request->title,
            'banner' => $bannerPath,
            'user_id' => auth()->id(),
        ]);

        return redirect()->route('admin.blog.index')->with('success', 'Blog created');
    }

    public function edit($id)
    {
        $blog = Blog::findOrFail($id);
        return view('adminpage.blogs.form_edit', compact('blog'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'nullable',
            'content' => 'nullable',
            'banner' => 'nullable',
        ]);

        $blog = Blog::findOrFail($id);

        if ($request->hasFile('banner')) {
            // Storage::disk('public')->delete($blog->banner);
            $blog->banner = $request->file('banner')->store('banners', 'public');
        }

        $blog->update([
            'slug' => Str::slug($request->title) . '-' . uniqid(),
            'content' => $request->content,
            'title' => $request->title,
            'user_id' => auth()->id(),
        ]);

        return redirect()->route('admin.blog.index')->with('success', 'Blog updated');
    }

    public function destroy($id)
    {
        // Storage::disk('public')->delete($blog->banner);
        $blog = Blog::findOrFail($id);
        // dd($blog);
        $blog->delete();
        return redirect()->route('admin.blog.index')->with('success', 'Blog deleted');
    }
}