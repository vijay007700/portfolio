<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('projects', function (Blueprint $table): void {
            $table->longText('problem')->nullable()->after('summary');
            $table->longText('solution')->nullable()->after('problem');
            $table->longText('responsibilities')->nullable()->after('solution');
            $table->json('screenshots')->nullable()->after('image');
            $table->string('seo_title', 180)->nullable()->after('screenshots');
            $table->text('seo_description')->nullable()->after('seo_title');
            $table->boolean('is_published')->default(true)->after('is_featured');
            $table->boolean('is_demo')->default(false)->after('is_published');
        });
    }

    public function down(): void
    {
        Schema::table('projects', function (Blueprint $table): void {
            $table->dropColumn([
                'problem', 'solution', 'responsibilities', 'screenshots', 'seo_title',
                'seo_description', 'is_published', 'is_demo',
            ]);
        });
    }
};
