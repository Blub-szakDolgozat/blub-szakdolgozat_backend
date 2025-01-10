<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasApiTokens;

    public function isAdmin()  {
        return $this->jogosultsagi_szint === 'admin';
    }
    public function akvariums()
    {
        return $this->hasMany(Akvarium::class, 'felhasznalo_id');
    }

    protected $primaryKey = 'azonosito';

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'felhasznalonev',
        'email',
        'regi_jelszo',
        'uj_jelszo',
        'regisztracio_datum',
        'valtozas_datum',
        'profilkep',
        'jogosultsagi_szint',
    ];
    

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
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
}
