<?php

namespace App\Http\Controllers\Admin;

use App\Models\Service;

class ServiceController extends CrudController
{
    protected string $modelClass = Service::class;
    protected string $title = 'Services';
    protected string $routeName = 'services';
    protected array $fields = ['title' => ['label' => 'Service title', 'type' => 'text'], 'icon' => ['label' => 'Icon / short code', 'type' => 'text'], 'short_description' => ['label' => 'Short description', 'type' => 'textarea'], 'description' => ['label' => 'Full description', 'type' => 'textarea'], 'sort_order' => ['label' => 'Sort order', 'type' => 'number'], 'is_active' => ['label' => 'Active', 'type' => 'checkbox']];
    protected array $rules = ['title' => ['required', 'string', 'max:160'], 'icon' => ['nullable', 'string', 'max:30'], 'short_description' => ['required', 'string', 'max:500'], 'description' => ['nullable', 'string'], 'sort_order' => ['nullable', 'integer'], 'is_active' => ['nullable', 'boolean']];
}
