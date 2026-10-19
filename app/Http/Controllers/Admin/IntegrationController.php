<?php

namespace App\Http\Controllers\Admin;

use App\Models\Integration;

class IntegrationController extends CrudController
{
    protected string $modelClass = Integration::class;
    protected string $title = 'Integrations';
    protected string $routeName = 'integrations';
    protected array $fields = ['name' => ['label' => 'Integration', 'type' => 'text'], 'category' => ['label' => 'Category', 'type' => 'text', 'placeholder' => 'Payments / Realtime / API'], 'description' => ['label' => 'Description', 'type' => 'textarea'], 'icon' => ['label' => 'Short icon / initials', 'type' => 'text'], 'sort_order' => ['label' => 'Sort order', 'type' => 'number'], 'is_active' => ['label' => 'Active', 'type' => 'checkbox']];
    protected array $rules = ['name' => ['required', 'string', 'max:120'], 'category' => ['required', 'string', 'max:100'], 'description' => ['nullable', 'string', 'max:600'], 'icon' => ['nullable', 'string', 'max:30'], 'sort_order' => ['nullable', 'integer'], 'is_active' => ['nullable', 'boolean']];
}
