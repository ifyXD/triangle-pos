<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Modules\Product\Entities\Category;
use Modules\Setting\Entities\Setting;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\File;
use Spatie\Permission\Contracts\Permission;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable implements HasMedia
{
    use HasFactory, Notifiable, HasRoles, InteractsWithMedia;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'is_active',
        'image'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected $with = ['media'];

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('avatars')
            ->useFallbackUrl('https://www.gravatar.com/avatar/' . md5("test@mail.com"));
    }

    public function scopeIsActive(Builder $builder)
    {
        return $builder->where('is_active', 1);
    }
    public function categories()
    {
        return $this->belongsToMany(Category::class, 'user_id', 'id');
    }
    public function setting()
    {
        return $this->hasOne(Setting::class);
    }
    public function themecustom()
    {
        return $this->hasOne(ThemeSetting::class);
    }
    public function userpermissions()
    {
        return $this->hasMany(UserPermission::class);
    }
    public function hasAccessToPermission($permissionName)
    {
        // Implement your logic to check if the user has access to the given permission
        // For example, checking if status is true
        return $this->userpermissions()
        ->join('permissions', 'user_permissions.permission_id', '=', 'permissions.id')
        ->where('permissions.name', $permissionName)
        ->where('user_permissions.status', 'true')
        ->where('user_permissions.user_id', $this->id)
        ->exists();
    }
}
