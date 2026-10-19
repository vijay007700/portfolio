<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Experience extends Model
{
    use HasFactory;

    protected $fillable = ['role','company','employment_type','start_date','end_date','is_current','summary','highlights','sort_order'];

    protected function casts(): array
    {
        return ['start_date'=>'date','end_date'=>'date','is_current'=>'boolean','sort_order'=>'integer'];
    }
}
