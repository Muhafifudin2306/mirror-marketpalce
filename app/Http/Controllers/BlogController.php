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
        $query = Blog::where('is_live', 1);

        $filter = $request->get('filter', 'semua');
        if ($filter !== 'semua') {
            $query->where('blog_type', $filter);
        }

        $sort = $request->get('sort', 'terbaru');
        $sort === 'terlama' ? $query->oldest() : $query->latest();

        $blogs = $query->paginate(12);

        return view('landingpage.articles', compact('blogs', 'filter', 'sort'));
    }
    
    public function show($slug)
    {
        $blog = Blog::where('slug', $slug)
                    ->where('is_live', 1)
                    ->firstOrFail();

        $otherArticles = Blog::where('is_live', 1)
                            ->where('id', '!=', $blog->id)
                            ->latest()
                            ->limit(4)
                            ->get();

        return view('landingpage.article-detail', compact('blog', 'otherArticles'));
    }

    public function create()
    {
        return view('adminpage.blogs.form');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title'     => 'nullable|string',
            'content'   => 'nullable|string',
            'banner'    => 'nullable|image',
            'blog_type' => 'required|in:Promo Sinau,Printips,Company,Printutor',
            'is_live'   => 'required|boolean',
        ]);

        $bannerPath = $request->file('banner')?->store('banners', 'public');

        Blog::create([
            'slug'      => Str::slug($request->title) . '-' . uniqid(),
            'title'     => $request->title,
            'content'   => $request->content,
            'banner'    => $bannerPath,
            'user_id'   => auth()->id(),
            'blog_type' => $request->blog_type,
            'is_live'   => $request->is_live,
        ]);

        return redirect()->route('admin.blog.index')
                        ->with('success', 'Blog created');
    }

    public function edit($id)
    {
        $blog = Blog::findOrFail($id);
        return view('adminpage.blogs.form_edit', compact('blog'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'title'     => 'nullable|string',
            'content'   => 'nullable|string',
            'banner'    => 'nullable|image',
            'blog_type' => 'required|in:Promo Sinau,Printips,Company,Printutor',
            'is_live'   => 'required|boolean',
        ]);

        $blog = Blog::findOrFail($id);
        if ($request->hasFile('banner')) {
            $blog->banner = $request->file('banner')
                            ->store('banners', 'public');
        }

        $blog->update([
            'slug'      => Str::slug($request->title) . '-' . uniqid(),
            'title'     => $request->title,
            'content'   => $request->content,
            'blog_type' => $request->blog_type,
            'is_live'   => $request->is_live,
            'user_id'   => auth()->id(),
        ]);

        return redirect()->route('admin.blog.index')
                        ->with('success', 'Blog updated');
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