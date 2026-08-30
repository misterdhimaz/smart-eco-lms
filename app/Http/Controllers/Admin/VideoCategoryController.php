<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\VideoCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class VideoCategoryController extends Controller
{
    public function index(Request $request)
    {
        $query = VideoCategory::withCount('videos');

        if ($request->filled('search')) {
            $query->where('title', 'like', '%' . $request->search . '%')
                  ->orWhere('badge', 'like', '%' . $request->search . '%');
        }

        $categories = $query->latest()->paginate(10);
        return view('admin.video_categories.index', compact('categories'));
    }

    public function create()
    {
        return view('admin.video_categories.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'badge' => 'required|string|max:50',
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'cover_image' => 'required|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        $coverPath = $request->file('cover_image')->store('categories/covers', 'public');

        VideoCategory::create([
            'badge' => $request->badge,
            'title' => $request->title,
            'description' => $request->description,
            'cover_image' => $coverPath,
        ]);

        return redirect()->route('admin.video-categories.index')->with('success', 'Kategori Modul berhasil dibuat!');
    }

    public function edit(VideoCategory $videoCategory)
    {
        return view('admin.video_categories.edit', compact('videoCategory'));
    }

    public function update(Request $request, VideoCategory $videoCategory)
    {
        $request->validate([
            'badge' => 'required|string|max:50',
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'cover_image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        if ($request->hasFile('cover_image')) {
            if ($videoCategory->cover_image) {
                Storage::disk('public')->delete($videoCategory->cover_image);
            }
            $videoCategory->cover_image = $request->file('cover_image')->store('categories/covers', 'public');
        }

        $videoCategory->update([
            'badge' => $request->badge,
            'title' => $request->title,
            'description' => $request->description,
        ]);

        return redirect()->route('admin.video-categories.index')->with('success', 'Kategori Modul berhasil diperbarui!');
    }

    public function destroy(VideoCategory $videoCategory)
    {
        if ($videoCategory->cover_image) {
            Storage::disk('public')->delete($videoCategory->cover_image);
        }

        $videoCategory->delete();
        return redirect()->route('admin.video-categories.index')->with('success', 'Kategori Modul berhasil dihapus!');
    }
}
