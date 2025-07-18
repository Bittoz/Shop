<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Default Filesystem Disk
    |--------------------------------------------------------------------------
    */
    'default' => env('FILESYSTEM_DRIVER', 'local'),

    /*
    |--------------------------------------------------------------------------
    | Default Cloud Filesystem Disk
    |--------------------------------------------------------------------------
    */
    'cloud'   => env('FILESYSTEM_CLOUD', 's3'),

    /*
    |--------------------------------------------------------------------------
    | Enable Laravel to Serve Local Files?
    |--------------------------------------------------------------------------
    | Some packages (and the framework’s own FilesystemServiceProvider)
    | look for a top-level `serve` key. If you never use that feature,
    | keep this false.
    |--------------------------------------------------------------------------
    */
    'serve'   => env('FILESYSTEM_SERVE', false),

    /*
    |--------------------------------------------------------------------------
    | Filesystem Disks
    |--------------------------------------------------------------------------
    */
    'disks'   => [

        'local' => [
            'driver' => 'local',
            'root'   => storage_path('app'),
            // if you ever want to serve these via a route:
            'serve'  => false,
        ],

        'public' => [
            'driver'     => 'local',
            'root'       => storage_path('app/public'),
            'url'        => env('APP_URL').'/storage',
            'visibility' => 'public',
            'serve'      => false,
        ],

        's3' => [
            'driver'   => 's3',
            'key'      => env('AWS_ACCESS_KEY_ID'),
            'secret'   => env('AWS_SECRET_ACCESS_KEY'),
            'region'   => env('AWS_DEFAULT_REGION'),
            'bucket'   => env('AWS_BUCKET'),
            'url'      => env('AWS_URL'),
            'endpoint' => env('AWS_ENDPOINT'),
        ],

        'dropbox' => [
            'driver' => 'dropbox',
            'token'  => env('DROPBOX_TOKEN'),
        ],

        'google' => [
            'driver'       => 'google',
            'clientId'     => env('GOOGLE_DRIVE_CLIENT_ID'),
            'clientSecret' => env('GOOGLE_DRIVE_CLIENT_SECRET'),
            'refreshToken' => env('GOOGLE_DRIVE_REFRESH_TOKEN'),
            'folderId'     => env('GOOGLE_DRIVE_FOLDER_ID'),
        ],

        'wasabi' => [
            'driver'   => 's3',
            'key'      => env('WASABI_KEY'),
            'secret'   => env('WASABI_SECRET'),
            'region'   => env('WASABI_REGION'),
            'bucket'   => env('WASABI_BUCKET'),
            'endpoint' => env('WASABI_ENDPOINT'),
        ],

    ],

    /*
    |--------------------------------------------------------------------------
    | Symbolic Links
    |--------------------------------------------------------------------------
    */
    'links'   => [
        public_path('storage') => storage_path('app/public'),
    ],

];
