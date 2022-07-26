<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdvertCategory extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'parent_id'];

    public function child()
    {
        return $this->hasMany(AdvertCategory::class, 'parent_id');
    }
}
