<?php

namespace App\Models;

use Filament\Models\Contracts\FilamentUser;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Casts\Attribute;

class User extends Authenticatable implements FilamentUser
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'email_verified_at',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function password(): Attribute
    {
        return Attribute::make(
            set: fn ($value) => bcrypt($value),
        );
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    // Diese Methode ist für Filament 2.x und wird vom Interface verlangt!
    public function canAccessFilament(): bool
    {
        return $this->email === 'queen2026@gmail.com';
    }

    // Optional: Für Filament 3.x (Panels)
    // public function canAccessPanel(Panel $panel): bool
    // {
    //     return $this->email === 'queen2026@gmail.com';
    // }
}
