<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PackageGallery;
use Illuminate\Support\Facades\Storage;

class PackageGalleryController extends Controller
{
    // Menampilkan seluruh data galeri
    public function index()
    {
        $galleries = PackageGallery::latest()->get();

        return view('admin.package-gallery', compact('galleries'));
    }

    // Menyimpan foto galeri baru
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'package_type' => 'nullable|string|max:100',
            'image' => 'required|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $imagePath = $request->file('image')->store(
            'package-galleries',
            'public'
        );

        PackageGallery::create([
            'title' => $request->title,
            'description' => $request->description,
            'package_type' => $request->package_type,
            'image' => $imagePath,
        ]);

        return redirect()
            ->route('admin.package-gallery')
            ->with('success', 'Foto galeri berhasil ditambahkan!');
    }

    // Memperbarui data galeri
    public function update(Request $request, $id)
    {
        $gallery = PackageGallery::findOrFail($id);

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'package_type' => 'nullable|string|max:100',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        if ($request->hasFile('image')) {
            if ($gallery->image) {
                Storage::disk('public')->delete($gallery->image);
            }

            $gallery->image = $request->file('image')->store(
                'package-galleries',
                'public'
            );
        }

        $gallery->title = $request->title;
        $gallery->description = $request->description;
        $gallery->package_type = $request->package_type;
        $gallery->save();

        return redirect()
            ->route('admin.package-gallery')
            ->with('success', 'Data galeri berhasil diperbarui!');
    }

    // Menghapus data galeri
    public function destroy($id)
    {
        $gallery = PackageGallery::findOrFail($id);

        if ($gallery->image) {
            Storage::disk('public')->delete($gallery->image);
        }

        $gallery->delete();

        return redirect()
            ->route('admin.package-gallery')
            ->with('success', 'Foto galeri berhasil dihapus!');
    }
}
