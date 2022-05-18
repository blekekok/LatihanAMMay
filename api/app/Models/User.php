<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use App\Models\UserFile;
use App\Models\University;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $appends = ['university_name'];

    protected $fillable = [
        'university_id',
        'email',
        'password',
        'username',
        'image_url',
        'phone',
        'role',
    ];

    protected $hidden = [
        'password'
    ];

    public function getUniversityNameAttribute()
    {
        return University::where('id', $this->university_id)->first()->name;
    }

    public function userFiles(): HasMany
    {
        return $this->hasMany(UserFile::class)->join('file_categories', 'user_files.file_category_id', '=', 'file_categories.id');
    }

    public function hasRole($role)
    {
        return $this->role == $role;
    }
}
