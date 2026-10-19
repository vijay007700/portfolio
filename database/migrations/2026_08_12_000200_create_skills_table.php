<?php
use Illuminate\Database\Migrations\Migration; use Illuminate\Database\Schema\Blueprint; use Illuminate\Support\Facades\Schema;
return new class extends Migration { public function up(): void { Schema::create('skills', function(Blueprint $t){ $t->id(); $t->string('name'); $t->string('category'); $t->unsignedTinyInteger('level')->nullable(); $t->decimal('years',3,1)->nullable(); $t->string('icon')->nullable(); $t->unsignedInteger('sort_order')->default(0); $t->boolean('is_active')->default(true); $t->timestamps(); }); } public function down(): void { Schema::dropIfExists('skills'); } };
