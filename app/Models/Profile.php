<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    use HasFactory;

    protected $fillable = ['name','title','hero_title','hero_subtitle','bio','email','phone','location','photo','resume_url','github_url','linkedin_url','upwork_url','years_experience','apps_apis','websites','wordpress_sites','availability'];

    protected function casts(): array
    {
        return ['years_experience'=>'decimal:1','apps_apis'=>'integer','websites'=>'integer','wordpress_sites'=>'integer'];
    }
}
