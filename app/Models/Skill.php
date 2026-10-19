<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Skill extends Model
{
    use HasFactory;

    protected $fillable = ['name','category','level','years','icon','sort_order','is_active'];

    protected function casts(): array
    {
        return ['level'=>'integer','years'=>'decimal:1','sort_order'=>'integer','is_active'=>'boolean'];
    }
}
