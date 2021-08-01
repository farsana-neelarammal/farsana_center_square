<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = [
        'name', 'slug', 'parent_id','created_at', 'updated_at',
    ];

    public function parentCategory()
    {
        return $this->belongsTo(self::class, 'parent_id','id');
    }
}
