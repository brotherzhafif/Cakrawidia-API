<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Like extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'entity_type', 'entity_id'];

    // Relasi ke User
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

