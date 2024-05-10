<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    public function subKategories()
    {
        return $this->hasMany(SubCategory::class, 'kategori_id');
    }
}
