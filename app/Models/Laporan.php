<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class Laporan extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'judul',
        'pesan',
        'balasan_admin',
        'status',
    ];

    public function user ()
    {
        return $table = $this->belongsTo(User::class);
    }
}
