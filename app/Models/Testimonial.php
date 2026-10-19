<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Testimonial extends Model
{
    use HasFactory;

    protected $fillable = ['client_name','client_role','company','quote','rating','avatar','sort_order','is_active'];

    protected function casts(): array
    {
        return ['rating'=>'integer','sort_order'=>'integer','is_active'=>'boolean'];
    }
}
