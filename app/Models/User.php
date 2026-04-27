<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Traits\HasRoles;

#[Fillable(['name', 'email', 'password', 'provider', 'provider_id'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable, HasRoles;

    protected $fillable = ['name', 'email', 'password', 'provider', 'provider_id'];
    protected $hidden = ['password', 'remember_token'];
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

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    public function payments()
    {
        return $this->hasMany(Payments::class);
    }

    public function businesses()
    {
        return $this->hasMany(Business::class);
    }

    public function assignPanelRole(string $accountType = 'user'): void
    {
        $roleName = $accountType === 'owner' ? 'owner' : 'user';

        Role::findOrCreate($roleName, 'web');

        if (! $this->hasRole($roleName)) {
            $this->assignRole($roleName);
        }
    }

    public function normalizePanelRole(): string
    {
        if ($this->hasRole('admin')) {
            return 'admin';
        }

        if ($this->hasRole('business') && ! $this->hasRole('owner')) {
            $this->assignPanelRole('owner');
        }

        if ($this->hasRole('owner')) {
            return 'owner';
        }

        if (! $this->hasAnyRole(['admin', 'owner', 'user', 'business'])) {
            $this->assignPanelRole('user');
        }

        return 'user';
    }

    public function dashboardRouteName(): string
    {
        return match ($this->normalizePanelRole()) {
            'admin' => 'admin.layouts.app',
            'owner' => 'owner.dashboard',
            default => 'client.dashboard',
        };
    }
    public function wallet()
    {
        return $this->hasOne(Wallet::class);
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }
}
