<?php


$factory->define(App\Models\DownloadLog::class, function (Faker\Generator $faker) {
    // Ensure we're on fake storage
    Storage::fake('local');

    $filename = $faker->uuid . '.csv';
    Storage::disk('local')->put($filename, '');
    return [
        'download_name' => $filename,
        'path' => $filename,
    ];
});
