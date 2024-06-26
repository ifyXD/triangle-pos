<?php

namespace App\Models;

use App\Models\Figures\Product;
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

class User extends Authenticatable implements HasMedia, MustVerifyEmail
{
    use HasFactory, Notifiable, HasRoles, InteractsWithMedia;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name',
        'middle_name',
        'last_name',
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
        return $this->belongsToMany(Category::class, 'store_id', 'id');
    }
    public function setting()
    {
        return $this->hasOne(Setting::class);
    }
    public function themecustom()
    {
        return $this->hasOne(ThemeSetting::class);
    }
    public function store()
    {
        return $this->hasOne(Store::class);
    }
    public function stocks()
    {
        return $this->hasMany(Stock::class);
    }
    public function userpermissions()
    {
        return $this->hasMany(UserPermission::class);
    }
    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function hasAccessToPermission($permissionName)
    {
        // // Implement your logic to check if the user has access to the given permission
        // // For example, checking if status is true
        // if (auth()->user()->hasRole('Super Admin')) {
        //     return true;
        // }
        // // return $this->userpermissions()
        // // ->join('permissions', 'user_permissions.permission_id', '=', 'permissions.id')
        // // ->where('permissions.name', $permissionName)
        // // ->where('user_permissions.status', 'true')
        // // ->where('user_permissions.user_id', $this->id)
        // // ->exists();

        // // I want to change that want to auth()->user()->hasRole('Admin')

        if (auth()->user()->hasRole('Super Admin')) {
            return true;
        }
    
        // Check if the user has the 'Admin' role and the specific permission
        if (auth()->user()->hasRole('Admin') && auth()->user()->can($permissionName)) {
            return true;
        }
    
        return false;
    

    }
}
