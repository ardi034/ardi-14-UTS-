<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;

    // Menambahkan kolom-kolom yang boleh diisi secara massal
    protected $fillable = [
        'name', 'nim', 'kelas', 'tempat_lahir', 'tanggal_lahir'
    ];
}