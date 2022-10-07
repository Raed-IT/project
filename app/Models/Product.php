<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
  use HasFactory;
  protected $fillable = [
    'name',
    "desc",
    "price",
    "category_id",
  ];
  public function images()
  {
    return $this->morphMany(Image::class, "imageable");
  }
  public function category()
  {
    return $this->belongsTo(Category::class);
  }
}
