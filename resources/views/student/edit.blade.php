@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <!-- Menampilkan Nama Mahasiswa di Header -->
                <div class="card-header">
                    {{ __('Edit Student: ') . $student->name }}
                </div>

                <div class="card-body">
                    <!-- Form Edit Student -->
                    <form action="{{ route('student.update', $student->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT') <!-- Method PUT digunakan untuk update -->

                        <!-- Input Nama -->
                        <div class="form-group mb-3">
                            <label for="name">Nama</label>
                            <input type="text" class="form-control" id="name" name="name" value="{{ $student->name }}" required>
                        </div>
                        
                        <!-- Input NIM -->
                        <div class="form-group mb-3">
                            <label for="nim">NIM</label>
                            <input type="text" class="form-control" id="nim" name="nim" value="{{ $student->nim }}" required>
                        </div>
                        
                        <!-- Input Kelas -->
                        <div class="form-group mb-3">
                            <label for="kelas">Kelas</label>
                            <input type="text" class="form-control" id="kelas" name="kelas" value="{{ $student->kelas }}" required>
                        </div>

                        <!-- Input Tempat Lahir -->
                        <div class="form-group mb-3">
                            <label for="tempat_lahir">Tempat Lahir</label>
                            <input type="text" class="form-control" id="tempat_lahir" name="tempat_lahir" value="{{ $student->tempat_lahir }}" required>
                        </div>

                        <!-- Input Tanggal Lahir -->
                        <div class="form-group mb-3">
                            <label for="tanggal_lahir">Tanggal Lahir</label>
                            <input type="date" class="form-control" id="tanggal_lahir" name="tanggal_lahir" value="{{ $student->tanggal_lahir ? \Carbon\Carbon::parse($student->tanggal_lahir)->format('Y-m-d') : '' }}" required>
                        </div>

                        <!-- Input Foto Profil -->
                        <div class="form-group mb-3">
                            <label for="profile_image">Foto Profil</label>
                            <input type="file" class="form-control @error('profile_image') is-invalid @enderror" id="profile_image" name="profile_image" accept="image/*">
                            
                            @if ($student->profile_image)
                                <div class="mt-3">
                                    <img src="{{ asset('storage/' . $student->profile_image) }}" alt="Profile Image" style="width: 100px; height: 100px; border-radius: 50%;">
                                </div>
                            @endif

                            @error('profile_image')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <!-- Tombol Submit -->
                        <button type="submit" class="btn btn-primary" onclick="return confirm('Data Berhasil diedit')">
                            {{ __('Update') }}
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
