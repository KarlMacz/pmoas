<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Default Filesystem Disk
    |--------------------------------------------------------------------------
    |
    | Here you may specify the default filesystem disk that should be used
    | by the framework. A "local" driver, as well as a variety of cloud
    | based drivers are available for your choosing. Just store away!
    |
    | Supported: "local", "ftp", "s3", "rackspace"
    |
    */

    'default' => 'local',

    /*
    |--------------------------------------------------------------------------
    | Default Cloud Filesystem Disk
    |--------------------------------------------------------------------------
    |
    | Many applications store files both locally and in the cloud. For this
    | reason, you may specify a default "cloud" driver here. This driver
    | will be bound as the Cloud disk implementation in the container.
    |
    */

    'cloud' => 's3',

    /*
    |--------------------------------------------------------------------------
    | Filesystem Disks
    |--------------------------------------------------------------------------
    |
    | Here you may configure as many filesystem "disks" as you wish, and you
    | may even configure multiple disks of the same driver. Defaults have
    | been setup for each driver as an example of the required options.
    |
    */

    'disks' => [

        'local' => [
            'driver' => 'local',
            'root' => storage_path('app'),
        ],

        'public' => [
            'driver' => 'local',
            'root' => storage_path('app/public'),
            'visibility' => 'public',
        ],

        's3' => [
            'driver' => 's3',
            'key' => 'your-key',
            'secret' => 'your-secret',
            'region' => 'your-region',
            'bucket' => 'your-bucket',
        ],

        // Custom Storage
        'database' => [
            'driver' => 'local',
            'root' => storage_path('app/databases'),
            'visibility' => 'public',
        ],
        'compressed_file' => [
            'driver' => 'local',
            'root' => storage_path('app/compressed_files'),
        ],
        'document' => [
            'driver' => 'local',
            'root' => storage_path('app/documents'),
        ],
        'contract' => [
            'driver' => 'local',
            'root' => storage_path('app/contracts'),
        ],
        'sales_report' => [
            'driver' => 'local',
            'root' => storage_path('app/reports/sales'),
        ],
        'inventory_report' => [
            'driver' => 'local',
            'root' => storage_path('app/reports/inventories'),
        ],
        'delivery_report' => [
            'driver' => 'local',
            'root' => storage_path('app/reports/deliveries'),
        ],
        'supplier_report' => [
            'driver' => 'local',
            'root' => storage_path('app/reports/suppliers'),
        ],
        'product_information_report' => [
            'driver' => 'local',
            'root' => storage_path('app/reports/product_information'),
        ],
        'receipts' => [
            'driver' => 'local',
            'root' => storage_path('app/receipts'),
        ],
    ],

];
