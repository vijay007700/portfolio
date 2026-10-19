<?php

namespace App\Http\Controllers\Admin;

use App\Models\Testimonial;

class TestimonialController extends CrudController
{
    protected string $modelClass = Testimonial::class;
    protected string $title = 'Testimonials';
    protected string $routeName = 'testimonials';
    protected array $fields = ['client_name' => ['label' => 'Client name', 'type' => 'text'], 'client_role' => ['label' => 'Client role', 'type' => 'text'], 'company' => ['label' => 'Company', 'type' => 'text'], 'quote' => ['label' => 'Testimonial', 'type' => 'textarea'], 'rating' => ['label' => 'Rating 1-5', 'type' => 'number'], 'avatar' => ['label' => 'Avatar', 'type' => 'image'], 'sort_order' => ['label' => 'Sort order', 'type' => 'number'], 'is_active' => ['label' => 'Active', 'type' => 'checkbox']];
    protected array $rules = ['client_name' => ['required', 'string', 'max:120'], 'client_role' => ['nullable', 'string', 'max:120'], 'company' => ['nullable', 'string', 'max:120'], 'quote' => ['required', 'string', 'max:1500'], 'rating' => ['required', 'integer', 'min:1', 'max:5'], 'avatar' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'], 'sort_order' => ['nullable', 'integer'], 'is_active' => ['nullable', 'boolean']];
}
