<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Database\Seeder;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Artisan::command('seed:all', function () {
    $this->info('Starting to seed all data...');
    
    // Run all seeders in the correct order
    $this->call('db:seed', [
        '--class' => 'Database\\Seeders\\AdminUserSeeder'
    ]);
    
    $this->call('db:seed', [
        '--class' => 'Database\\Seeders\\BlogPostSeeder'
    ]);
    
    $this->call('db:seed', [
        '--class' => 'Database\\Seeders\\CatalogueSeeder'
    ]);
    
    $this->call('db:seed', [
        '--class' => 'Database\\Seeders\\FeaturedProductSeeder'
    ]);
    
    $this->call('db:seed', [
        '--class' => 'Database\\Seeders\\PromotionSeeder'
    ]);
    
    $this->info('All seeders have been executed successfully!');
})->purpose('Run all database seeders in the correct order');
