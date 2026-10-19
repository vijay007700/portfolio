<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContactMessage extends Model
{
    use HasFactory;

    protected $fillable = ['name','email','company','budget','project_type','message','status'];

    protected function casts(): array
    {
        return [];
    }
}
