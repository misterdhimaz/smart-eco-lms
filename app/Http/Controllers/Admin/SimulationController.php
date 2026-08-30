<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Simulation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SimulationController extends Controller
{
    public function index(Request $request)
    {
        $query = Simulation::query();
        if ($request->filled('search')) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }
        $simulations = $query->latest()->paginate(10);
        return view('admin.simulations.index', compact('simulations'));
    }

    public function create()
    {
        return view('admin.simulations.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'badge' => 'required|string|max:50',
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'cover_image' => 'required|image|max:2048',
            'type' => 'required|in:embed,native_carbon',
            'embed_url' => 'required_if:type,embed|nullable|url',
        ]);

        $coverPath = $request->file('cover_image')->store('simulations/covers', 'public');

        Simulation::create([
            'badge' => $request->badge,
            'title' => $request->title,
            'description' => $request->description,
            'cover_image' => $coverPath,
            'type' => $request->type,
            'embed_url' => $request->type === 'embed' ? $request->embed_url : null,
        ]);

        return redirect()->route('admin.simulations.index')->with('success', 'Simulasi berhasil ditambahkan!');
    }

    public function destroy(Simulation $simulation)
    {
        if ($simulation->cover_image) Storage::disk('public')->delete($simulation->cover_image);
        $simulation->delete();
        return back()->with('success', 'Simulasi dihapus!');
    }
}
