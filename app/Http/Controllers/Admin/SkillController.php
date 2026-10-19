<?php

namespace App\Http\Controllers\Admin;

use App\Models\Skill;

class SkillController extends CrudController
{
    protected string $modelClass = Skill::class;
    protected string $title = 'Skills';
    protected string $routeName = 'skills';
    protected array $fields = ['name' => ['label' => 'Skill name', 'type' => 'text'], 'category' => ['label' => 'Category', 'type' => 'text', 'placeholder' => 'Backend / Frontend / Database / Tools'], 'level' => ['label' => 'Self-rated proficiency % (optional)', 'type' => 'number'], 'years' => ['label' => 'Years of experience (optional)', 'type' => 'number', 'step' => '0.5'], 'icon' => ['label' => 'Short icon / initials', 'type' => 'text'], 'sort_order' => ['label' => 'Sort order', 'type' => 'number'], 'is_active' => ['label' => 'Active', 'type' => 'checkbox']];
    protected array $rules = ['name' => ['required', 'string', 'max:100'], 'category' => ['required', 'string', 'max:100'], 'level' => ['nullable', 'integer', 'min:1', 'max:100'], 'years' => ['nullable', 'numeric', 'min:0', 'max:50'], 'icon' => ['nullable', 'string', 'max:30'], 'sort_order' => ['nullable', 'integer', 'min:0'], 'is_active' => ['nullable', 'boolean']];
}
