<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class User extends Authenticatable implements JWTSubject
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'username', 
        'email', 
        'password', 
        'role', 
        'points',
        'last_token'
    ];

    public function updateToken($token)
    {
        // Hapus token lama
        $this->tokens()->where('token', $this->last_token)->delete();
        
        // Simpan token baru
        $this->last_token = $token;
        $this->save();
    }

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Get the identifier that will be stored in the JWT payload.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey(); // Typically, this will be the user ID
    }

    /**
     * Get the custom claims to be added to the JWT payload.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return []; // You can add custom claims if needed
    }
}
