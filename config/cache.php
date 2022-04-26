<?php

return [
    'default' => 'file',

    'stores' => [
        'file' => [
            'driver' => 'file',
            'path' => $_SERVER['HOME'] . "/.slides-cli/storage/cache",
        ],
    ],
];
