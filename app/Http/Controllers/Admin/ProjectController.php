<?php

namespace App\Http\Controllers\Admin;

use App\Models\Project;

class ProjectController extends CrudController
{
    protected string $modelClass = Project::class;
    protected string $title = 'Projects';
    protected string $routeName = 'projects';
    protected array $fields = [
        'title' => ['label' => 'Project title', 'type' => 'text'],
        'slug' => ['label' => 'Slug (optional)', 'type' => 'text'],
        'type' => ['label' => 'Category', 'type' => 'text', 'placeholder' => 'Laravel / API / E-commerce'],
        'summary' => ['label' => 'Short overview', 'type' => 'textarea'],
        'problem' => ['label' => 'Problem', 'type' => 'textarea'],
        'solution' => ['label' => 'Solution', 'type' => 'textarea'],
        'description' => ['label' => 'Project details', 'type' => 'textarea'],
        'responsibilities' => ['label' => 'Your responsibilities (one per line)', 'type' => 'textarea'],
        'tech_stack' => ['label' => 'Technologies (comma separated)', 'type' => 'text'],
        'project_url' => ['label' => 'Live project URL (optional)', 'type' => 'url'],
        'image' => ['label' => 'Card cover image', 'type' => 'image'],
        'screenshots' => ['label' => 'Case study screenshots (select multiple)', 'type' => 'images'],
        'seo_title' => ['label' => 'SEO title', 'type' => 'text'],
        'seo_description' => ['label' => 'SEO description', 'type' => 'textarea'],
        'is_featured' => ['label' => 'Featured on homepage', 'type' => 'checkbox'],
        'is_published' => ['label' => 'Published', 'type' => 'checkbox'],
        'is_demo' => ['label' => 'Demo / sample project', 'type' => 'checkbox'],
        'sort_order' => ['label' => 'Sort order', 'type' => 'number'],
    ];
    protected array $rules = [
        'title' => ['required', 'string', 'max:180'],
        'slug' => ['nullable', 'string', 'max:190'],
        'type' => ['required', 'string', 'max:100'],
        'summary' => ['required', 'string', 'max:600'],
        'problem' => ['nullable', 'string', 'max:5000'],
        'solution' => ['nullable', 'string', 'max:5000'],
        'description' => ['nullable', 'string', 'max:12000'],
        'responsibilities' => ['nullable', 'string', 'max:5000'],
        'tech_stack' => ['nullable', 'string', 'max:1000'],
        'project_url' => ['nullable', 'url', 'max:255'],
        'image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:4096'],
        'screenshots' => ['nullable', 'array', 'max:8'],
        'screenshots.*' => ['image', 'mimes:jpg,jpeg,png,webp', 'max:4096'],
        'seo_title' => ['nullable', 'string', 'max:180'],
        'seo_description' => ['nullable', 'string', 'max:300'],
        'is_featured' => ['nullable', 'boolean'],
        'is_published' => ['nullable', 'boolean'],
        'is_demo' => ['nullable', 'boolean'],
        'sort_order' => ['nullable', 'integer', 'min:0'],
    ];
}
