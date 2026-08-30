<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\VideoCategory;
use App\Models\Video;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class VideoController extends Controller
{
    public function index(VideoCategory $category)
    {
        $videos = $category->videos()->get();
        return view('admin.videos.index', compact('category', 'videos'));
    }

    public function store(Request $request, VideoCategory $category)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'type' => 'required|in:youtube,upload',
            'youtube_url' => 'required_if:type,youtube|nullable|string',
            'video_file' => 'required_if:type,upload|nullable|mimes:mp4,webm,ogg,mov|max:102400', // max 100MB
            'duration' => 'required|string|max:20',
            'description' => 'nullable|string',
        ]);

        $videoPathOrUrl = '';

        if ($request->type === 'youtube') {
            // Ekstrak YouTube ID jika user memasukkan URL lengkap
            $videoPathOrUrl = $this->parseYoutubeId($request->youtube_url);
        } else {
            $videoPathOrUrl = $request->file('video_file')->store('videos/uploads', 'public');
        }

        Video::create([
            'video_category_id' => $category->id,
            'title' => $request->title,
            'type' => $request->type,
            'video_url' => $videoPathOrUrl,
            'duration' => $request->duration,
            'description' => $request->description,
            'order' => $category->videos()->count() + 1,
        ]);

        return redirect()->route('admin.videos.index', $category->id)->with('success', 'Video berhasil ditambahkan!');
    }

    public function update(Request $request, Video $video)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'type' => 'required|in:youtube,upload',
            'youtube_url' => 'nullable|string',
            'video_file' => 'nullable|mimes:mp4,webm,ogg,mov|max:102400',
            'duration' => 'required|string|max:20',
            'description' => 'nullable|string',
        ]);

        $videoPathOrUrl = $video->video_url;

        if ($request->type === 'youtube') {
            if ($request->filled('youtube_url')) {
                // Hapus video file lama jika sebelumnya tipe upload
                if ($video->type === 'upload' && $video->video_url) {
                    Storage::disk('public')->delete($video->video_url);
                }
                $videoPathOrUrl = $this->parseYoutubeId($request->youtube_url);
            }
        } else {
            if ($request->hasFile('video_file')) {
                if ($video->type === 'upload' && $video->video_url) {
                    Storage::disk('public')->delete($video->video_url);
                }
                $videoPathOrUrl = $request->file('video_file')->store('videos/uploads', 'public');
            }
        }

        $video->update([
            'title' => $request->title,
            'type' => $request->type,
            'video_url' => $videoPathOrUrl,
            'duration' => $request->duration,
            'description' => $request->description,
        ]);

        return redirect()->route('admin.videos.index', $video->video_category_id)->with('success', 'Video berhasil diperbarui!');
    }

    public function destroy(Video $video)
    {
        $categoryId = $video->video_category_id;

        if ($video->type === 'upload' && $video->video_url) {
            Storage::disk('public')->delete($video->video_url);
        }

        $video->delete();

        return redirect()->route('admin.videos.index', $categoryId)->with('success', 'Video berhasil dihapus!');
    }

    private function parseYoutubeId($url)
    {
        preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $url, $match);
        return $match[1] ?? $url;
    }
}
