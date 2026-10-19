<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;

    protected $fillable = ['title','icon','short_description','description','sort_order','is_active'];

    protected function casts(): array
    {
        return ['sort_order'=>'integer','is_active'=>'boolean'];
    }
}
