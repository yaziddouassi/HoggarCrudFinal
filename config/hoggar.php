<?php

return  [
    'storage_disk' => env('HOGGAR_STORAGE_DISK', 'public'),
    'storage_url' => env('HOGGAR_STORAGE_URL', 'http://localhost/storage/')
    'company' =>'My Company',
    'middlewareList' => ['auth'],
];