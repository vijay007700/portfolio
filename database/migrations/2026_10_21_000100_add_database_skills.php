<?php

use App\Models\Skill;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    private array $skills = [
        ['SQLite', 'SQL'],
        ['MongoDB', 'MDB'],
        ['Supabase', 'SB'],
        ['Firebase', 'FB'],
    ];

    public function up(): void
    {
        $nextOrder = max(12, ((int) Skill::query()->max('sort_order')) + 1);

        foreach ($this->skills as $index => [$name, $icon]) {
            Skill::query()->firstOrCreate(['name' => $name], [
                'category' => 'Databases',
                'level' => null,
                'years' => null,
                'icon' => $icon,
                'sort_order' => $nextOrder + $index,
                'is_active' => true,
            ]);
        }
    }

    public function down(): void
    {
        // These rows become admin-editable portfolio content; preserve them on rollback.
    }
};
