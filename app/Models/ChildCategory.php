<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChildCategory extends Model
{
    use HasFactory;

    public function kategori()
    {
        return $this->belongsTo(Category::class);
    }

    
    public function subKategori()
    {
        return $this->belongsTo(SubCategory::class);
    }
}
