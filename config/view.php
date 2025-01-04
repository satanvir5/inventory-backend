<?php

return [

    /*
    |--------------------------------------------------------------------------
    | View Storage Paths
    |--------------------------------------------------------------------------
    |
    | Here you may specify an array of paths that should be checked for your
    | views. The first path will be checked first, followed by the next path
    | in the array, and so on. Feel free to add as many paths as you need.
    |
    */

    'paths' => [
        resource_path('views'),
    ],

    /*
    |--------------------------------------------------------------------------
    | Compiled View Path
    |--------------------------------------------------------------------------
    |
    | This is the path where all the compiled Blade templates will be stored.
    | By default, this is within the storage folder. You may change this
    | to any other location if necessary.
    |
    */

    'compiled' => env('VIEW_COMPILED', realpath(storage_path('framework/views'))),

];
