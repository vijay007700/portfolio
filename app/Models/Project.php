<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    protected $fillable = [
        'title', 'slug', 'type', 'summary', 'problem', 'solution', 'responsibilities',
        'description', 'tech_stack', 'project_url', 'image', 'screenshots', 'seo_title',
        'seo_description', 'is_featured', 'is_published', 'is_demo', 'sort_order',
    ];

    protected function casts(): array
    {
        return [
            'is_featured' => 'boolean',
            'is_published' => 'boolean',
            'is_demo' => 'boolean',
            'screenshots' => 'array',
            'sort_order' => 'integer',
        ];
    }
}
