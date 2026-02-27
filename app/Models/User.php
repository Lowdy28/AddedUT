<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Storage;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table      = 'usuarios';
    protected $primaryKey = 'id_usuario';

    public function getAuthIdentifierName()
    {
        return 'id_usuario';
    }

    protected $fillable = [
        'nombre',
        'email',
        'password',
        'rol',
        'foto',     
        'activo',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

   
    protected $appends = ['foto_url'];

    public function getFotoUrlAttribute(): string
    {
        if (!empty($this->foto) && Storage::disk('public')->exists($this->foto)) {
            return Storage::disk('public')->url($this->foto);
        }

        
        return 'https://ui-avatars.com/api/?name=' . urlencode($this->nombre ?? 'U') . '&background=002D62&color=fff&size=128';
    }

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password'          => 'hashed',
        ];
    }
}