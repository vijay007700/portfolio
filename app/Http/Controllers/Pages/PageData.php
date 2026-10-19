<?php

namespace App\Http\Controllers\Pages;

use App\Models\Profile;
use App\Models\Setting;

trait PageData
{
    protected function shellData(): array
    {
        return [
            'profile' => Profile::query()->first(),
            'settings' => Setting::query()->pluck('value', 'key'),
        ];
    }
}
