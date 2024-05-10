<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubCategory extends Model
{
    use HasFactory;


    public function kategori()
    {
       
        return $this->belongsTo(Category::class);
    }
    public function kategoriAnak()
    {
        return $this->hasMany(ChildCategory::class, 'sub_kategori_id');
    }
}
