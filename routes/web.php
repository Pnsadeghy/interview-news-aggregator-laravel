<?php

use Illuminate\Support\Facades\Route;

Route::get('', function () {

    $sources = \App\Models\NewsReaderSource::query()->get();
    $result = [];

    foreach ($sources as $source) {
        $readerClass = "App\\Services\\Readers\\{$source->reader_class}";
        $reader = new $readerClass($source);
        $articles = $reader->fetchArticles();

        $result[$source->name] = $articles;
    }

    return response()->json($result);
});
