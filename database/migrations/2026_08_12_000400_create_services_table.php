<?php
use Illuminate\Database\Migrations\Migration; use Illuminate\Database\Schema\Blueprint; use Illuminate\Support\Facades\Schema;
return new class extends Migration { public function up(): void { Schema::create('services', function(Blueprint $t){ $t->id(); $t->string('title'); $t->string('icon')->nullable(); $t->text('short_description'); $t->longText('description')->nullable(); $t->unsignedInteger('sort_order')->default(0); $t->boolean('is_active')->default(true); $t->timestamps(); }); } public function down(): void { Schema::dropIfExists('services'); } };
