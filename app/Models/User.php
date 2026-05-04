<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\Activitylog\Models\Concerns\LogsActivity;
use Spatie\Activitylog\Support\LogOptions;


#[Fillable(['unit_kerja_id', 'name', 'username', 'avatar', 'phone', 'address', 'bio', 'nip', 'nik', 'jabatan', 'keterangan', 'gender', 'email', 'password', 'is_active', 'last_login_at', 'last_login_ip', 'google_id', 'google_token', 'google_refresh_token'])]
#[Hidden(['password', 'remember_token', 'google_token', 'google_refresh_token'])]
class User extends Authenticatable implements HasMedia
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable, HasRoles, HasUlids, InteractsWithMedia, LogsActivity;

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logFillable()
            ->logExcept(['password', 'remember_token', 'google_token', 'google_refresh_token'])
            ->logOnlyDirty()
            ->useLogName('user')
            ->setDescriptionForEvent(fn(string $eventName) => "User account has been {$eventName}");
    }

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
            'is_active' => 'boolean',
        ];
    }

    /**
     * Get the unit kerja that the user belongs to.
     */
    public function unitKerja(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(\App\Models\Master\UnitKerja::class, 'unit_kerja_id');
    }

    /**
     * Get the kegiatans for the user.
     */
    public function kegiatans(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(\App\Models\Kegiatan\Kegiatan::class, 'petugas_id');
    }

    /**
     * Register Media Collections
     */
    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('avatar')
             ->singleFile()
             ->useFallbackUrl(asset('assets/img/default-avatar.png'))
             ->useFallbackPath(public_path('assets/img/default-avatar.png'));

        $this->addMediaCollection('cover')
             ->singleFile()
             ->useFallbackUrl(asset('assets/img/default-cover.jpg'))
             ->useFallbackPath(public_path('assets/img/default-cover.jpg'));
    }
}
