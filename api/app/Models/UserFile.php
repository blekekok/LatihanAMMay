<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\FileCategory;

class UserFile extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'file_category_id',
        'file_url',
    ];
}
