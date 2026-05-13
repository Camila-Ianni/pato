<?php

use Illuminate\Support\Facades\Artisan;

Artisan::command('inspire', function (): void {
    $this->comment('Legado Pato listo para inspirar.');
})->purpose('Display an inspiring message');
