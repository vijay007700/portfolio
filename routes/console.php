<?php

use Illuminate\Support\Facades\Artisan;

Artisan::command('portfolio:about', function () {
    $this->info('Laravel Developer Portfolio - admin-managed showcase application.');
})->purpose('Show portfolio project information');
