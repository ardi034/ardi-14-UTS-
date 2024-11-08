<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Student;
use Illuminate\Support\Facades\Storage;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $students = Student::paginate(2); // Menampilkan mahasiswa dengan pagination
        return view('student.index', compact('students'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('student.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validasi input untuk kolom yang baru ditambahkan, termasuk foto
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'nim' => 'required|string|max:20|unique:students', // Pastikan NIM unik
            'kelas' => 'required|string|max:10',
            'tempat_lahir' => 'required|string|max:255',
            'tanggal_lahir' => 'required|date',
            'profile_image' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048', // Validasi foto
        ]);

        // Membuat instance baru dan menyimpan data mahasiswa
        $student = new Student();
        $student->name = $validated['name'];
        $student->nim = $validated['nim'];
        $student->kelas = $validated['kelas'];
        $student->tempat_lahir = $validated['tempat_lahir'];
        $student->tanggal_lahir = $validated['tanggal_lahir'];

        // Proses upload foto jika ada
        if ($request->hasFile('profile_image')) {
            // Menyimpan gambar ke folder 'public/profile_images'
            $imagePath = $request->file('profile_image')->store('profile_images', 'public');
            // Simpan path foto ke dalam database
            $student->profile_image = $imagePath;
        }

        // Simpan data mahasiswa
        $student->save();

        // Redirect ke halaman index dengan pesan sukses
        return redirect()->route('student.index')->with('success', 'Data mahasiswa berhasil disimpan.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $student = Student::find($id);
        return view('student.edit', compact('student'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // Validasi input untuk kolom yang baru ditambahkan, termasuk foto
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'nim' => 'required|string|max:20|unique:students,nim,' . $id, // Validasi NIM unik, kecuali untuk data yang sedang diedit
            'kelas' => 'required|string|max:10',
            'tempat_lahir' => 'required|string|max:255',
            'tanggal_lahir' => 'required|date',
            'profile_image' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048', // Validasi foto
        ]);

        // Temukan mahasiswa yang akan diperbarui
        $student = Student::find($id);
        
        // Perbarui data mahasiswa
        $student->name = $validated['name'];
        $student->nim = $validated['nim'];
        $student->kelas = $validated['kelas'];
        $student->tempat_lahir = $validated['tempat_lahir'];
        $student->tanggal_lahir = $validated['tanggal_lahir'];

        // Proses upload foto baru jika ada
        if ($request->hasFile('profile_image')) {
            // Jika mahasiswa sudah memiliki foto sebelumnya, hapus foto lama
            if ($student->profile_image) {
                Storage::disk('public')->delete($student->profile_image);
            }
            
            // Menyimpan gambar ke folder 'public/profile_images'
            $imagePath = $request->file('profile_image')->store('profile_images', 'public');
            // Simpan path foto ke dalam database
            $student->profile_image = $imagePath;
        }

        // Simpan data mahasiswa
        $student->save();

        // Redirect ke halaman index dengan pesan sukses
        return redirect()->route('student.index')->with('success', 'Data mahasiswa berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // Temukan mahasiswa yang akan dihapus
        $student = Student::find($id);

        // Jika mahasiswa ditemukan, hapus foto (jika ada) dan data
        if ($student) {
            // Hapus gambar dari storage jika ada
            if ($student->profile_image) {
                Storage::disk('public')->delete($student->profile_image);
            }

            // Hapus data mahasiswa
            $student->delete();
        }

        // Redirect ke halaman index dengan pesan sukses
        return redirect()->route('student.index')->with('success', 'Data mahasiswa berhasil dihapus.');
    }
}