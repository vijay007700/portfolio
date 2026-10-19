<?php

namespace App\Http\Controllers\Admin;

use App\Models\Experience;

class ExperienceController extends CrudController
{
    protected string $modelClass = Experience::class;
    protected string $title = 'Experience';
    protected string $routeName = 'experiences';
    protected array $fields = ['role' => ['label' => 'Role', 'type' => 'text'], 'company' => ['label' => 'Company / Work mode', 'type' => 'text'], 'employment_type' => ['label' => 'Employment type', 'type' => 'text'], 'start_date' => ['label' => 'Start date', 'type' => 'date'], 'end_date' => ['label' => 'End date', 'type' => 'date'], 'is_current' => ['label' => 'Current role', 'type' => 'checkbox'], 'summary' => ['label' => 'Summary', 'type' => 'textarea'], 'highlights' => ['label' => 'Highlights (one per line)', 'type' => 'textarea'], 'sort_order' => ['label' => 'Sort order', 'type' => 'number']];
    protected array $rules = ['role' => ['required', 'string', 'max:160'], 'company' => ['nullable', 'string', 'max:160'], 'employment_type' => ['nullable', 'string', 'max:80'], 'start_date' => ['nullable', 'date'], 'end_date' => ['nullable', 'date'], 'is_current' => ['nullable', 'boolean'], 'summary' => ['required', 'string'], 'highlights' => ['nullable', 'string'], 'sort_order' => ['nullable', 'integer']];
}
