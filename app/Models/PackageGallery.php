<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PackageGallery extends Model
{
    protected $table = 'package_galleries';

    protected $fillable = [
        'title',
        'description',
        'image',
        'package_type',
    ];
}
