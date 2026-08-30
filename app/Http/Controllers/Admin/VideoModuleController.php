<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\VideoModule;
use App\Models\Video;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class VideoModuleController extends Controller
{
    public function index(Request $request)
    {
        $query = VideoModule::with('videos');
        if ($request->filled('search')) {
            $query->where('title', 'like', '%' . $request->search . '%')
                  ->orWhere('badge', 'like', '%' . $request->search . '%');
        }
        $modules = $query->latest()->paginate(10);
        return view('admin.video_modules.index', compact('modules'));
    }

    public function create()
    {
        return view('admin.video_modules.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'badge' => 'required|string|max:50',
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'cover_image' => 'required|image|max:2048',
            'videos' => 'required|array|min:1',
            'videos.*.title' => 'required|string|max:255',
            'videos.*.type' => 'required|in:youtube,upload',
        ]);

        $coverPath = $request->file('cover_image')->store('modules/covers', 'public');

        $module = VideoModule::create([
            'badge' => $request->badge,
            'title' => $request->title,
            'description' => $request->description,
            'cover_image' => $coverPath,
        ]);

        $this->saveVideos($request, $module);

        return redirect()->route('admin.video-modules.index')->with('success', 'Modul & Video berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $module = VideoModule::with('videos')->findOrFail($id);
        return view('admin.video_modules.edit', compact('module'));
    }

    public function update(Request $request, $id)
    {
        $module = VideoModule::findOrFail($id);

        $request->validate([
            'badge' => 'required|string|max:50',
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'cover_image' => 'nullable|image|max:2048',
            'videos' => 'required|array|min:1',
        ]);

        if ($request->hasFile('cover_image')) {
            if ($module->cover_image) Storage::disk('public')->delete($module->cover_image);
            $module->cover_image = $request->file('cover_image')->store('modules/covers', 'public');
        }

        $module->update([
            'badge' => $request->badge,
            'title' => $request->title,
            'description' => $request->description,
        ]);

        // Hapus file video lama bertipe upload jika diganti
        foreach ($module->videos as $oldVideo) {
            if ($oldVideo->type === 'upload' && $oldVideo->video_url) {
                Storage::disk('public')->delete($oldVideo->video_url);
            }
        }
        $module->videos()->delete();

        $this->saveVideos($request, $module);

        return redirect()->route('admin.video-modules.index')->with('success', 'Modul & Video berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $module = VideoModule::findOrFail($id);
        if ($module->cover_image) Storage::disk('public')->delete($module->cover_image);
        foreach ($module->videos as $vid) {
            if ($vid->type === 'upload' && $vid->video_url) Storage::disk('public')->delete($vid->video_url);
        }
        $module->delete();

        return redirect()->route('admin.video-modules.index')->with('success', 'Modul berhasil dihapus!');
    }

    private function saveVideos(Request $request, VideoModule $module)
    {
        foreach ($request->videos as $index => $v) {
            $type = $v['type'];
            $videoUrl = '';

            if ($type === 'youtube') {
                $videoUrl = $this->parseYoutubeId($v['youtube_url'] ?? '');
            } else {
                if ($request->hasFile("videos.$index.video_file")) {
                    $videoUrl = $request->file("videos.$index.video_file")->store('videos/uploads', 'public');
                } else {
                    $videoUrl = $v['existing_file'] ?? '';
                }
            }

            Video::create([
                'video_module_id' => $module->id,
                'title' => $v['title'],
                'type' => $type,
                'video_url' => $videoUrl,
                'duration' => $v['duration'] ?? '00:00',
                'description' => $v['description'] ?? null,
                'order' => $index + 1,
            ]);
        }
    }

    private function parseYoutubeId($url)
    {
        preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $url, $match);
        return $match[1] ?? $url;
    }
}
