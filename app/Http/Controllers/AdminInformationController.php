<?php

namespace App\Http\Controllers;

use App\Models\Information;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class AdminInformationController extends Controller
{
    // Display all informations
    public function index()
    {
        $informations = Information::with('creator')->latest()->get();
        return view('admin.information.index', compact('informations'));
    }

    // Show create form
    public function create()
    {
        return view('admin.information.create');
    }

    // Store new information
    public function store(Request $request)
    {
        $validated = $request->validate([
            'judul' => 'required|string|max:255',
            'konten' => 'required|string',
            'banner' => 'required|image|mimes:jpeg,jpg,png|max:2048',
            'is_published' => 'boolean'
        ], [
            'judul.required' => 'Judul wajib diisi',
            'konten.required' => 'Konten wajib diisi',
            'banner.required' => 'Banner wajib diupload',
            'banner.image' => 'File harus berupa gambar',
            'banner.mimes' => 'Format gambar harus jpeg, jpg, atau png',
            'banner.max' => 'Ukuran banner maksimal 2MB',
        ]);

        // Upload banner
        $bannerPath = $request->file('banner')->store('banners', 'public');

        // Create information
        Information::create([
            'judul' => $validated['judul'],
            'konten' => $validated['konten'],
            'banner' => $bannerPath,
            'slug' => Str::slug($validated['judul']),
            'created_by' => session('admin_id'),
            'is_published' => $request->has('is_published')
        ]);

        return redirect()->route('admin.information.index')->with('success', 'Informasi berhasil ditambahkan!');
    }

    // Show edit form
    public function edit($id)
    {
        $information = Information::findOrFail($id);
        return view('admin.information.edit', compact('information'));
    }

    // Update information
    public function update(Request $request, $id)
    {
        $information = Information::findOrFail($id);

        $validated = $request->validate([
            'judul' => 'required|string|max:255',
            'konten' => 'required|string',
            'banner' => 'nullable|image|mimes:jpeg,jpg,png|max:2048',
            'is_published' => 'boolean'
        ], [
            'judul.required' => 'Judul wajib diisi',
            'konten.required' => 'Konten wajib diisi',
            'banner.image' => 'File harus berupa gambar',
            'banner.mimes' => 'Format gambar harus jpeg, jpg, atau png',
            'banner.max' => 'Ukuran banner maksimal 2MB',
        ]);

        $updateData = [
            'judul' => $validated['judul'],
            'konten' => $validated['konten'],
            'slug' => Str::slug($validated['judul']),
            'is_published' => $request->has('is_published')
        ];

        // Upload new banner if provided
        if ($request->hasFile('banner')) {
            // Delete old banner
            if ($information->banner && Storage::disk('public')->exists($information->banner)) {
                Storage::disk('public')->delete($information->banner);
            }
            $updateData['banner'] = $request->file('banner')->store('banners', 'public');
        }

        $information->update($updateData);

        return redirect()->route('admin.information.index')->with('success', 'Informasi berhasil diperbarui!');
    }

    // Delete information
    public function destroy($id)
    {
        $information = Information::findOrFail($id);
        
        // Delete banner
        if ($information->banner && Storage::disk('public')->exists($information->banner)) {
            Storage::disk('public')->delete($information->banner);
        }

        $information->delete();

        return redirect()->route('admin.information.index')->with('success', 'Informasi berhasil dihapus!');
    }

    // Toggle publish status
    public function togglePublish($id)
    {
        $information = Information::findOrFail($id);
        $information->update(['is_published' => !$information->is_published]);

        return redirect()->back()->with('success', 'Status publikasi berhasil diubah!');
    }
}
