<?php

namespace App\Http\Services;

use App\Models\User;
use App\Models\FileCategory;
use App\Models\UserFile;
use Illuminate\Support\Facades\Storage;

class UserService
{
    public function create(
        string $university_id,
        string $email,
        string $password,
        string $username,
        string $phone,
    )
    {
        return User::create([
            'university_id' => $university_id,
            'email' => $email,
            'password' => bcrypt($password),
            'username' => $username,
            'image_url' => 'none',
            'phone' => $phone,
            'image_url' => 'default.png'
        ]);
    }

    public function emailExist(string $email)
    {
        return $exist = User::where('email', '=', $email)->exists();
    }

    public function addFiles($user_id, $request) {
        $categories = FileCategory::all();

        foreach($categories as $category) {
            $fieldName = 'file_'.$category->id;
            $file = $request->file($fieldName)->get();
            $extension = $request->file($fieldName)->extension();

            $fileDir = 'user/'.$category->name.'_'.$user_id.'.'.$extension;

            Storage::disk('public')->put($fileDir, $file);

            UserFile::create([
                'user_id' => $user_id,
                'file_category_id' => $category->id,
                'file_url' => $fileDir
            ]);
        }
    }
}
