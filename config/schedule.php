<?php

return [
    [
        'command' => 'carts:cleanup',
        'frequency' => 'everyTenMinutes',
        'environments' => ['local', 'staging', 'production'],
        'even' => false,
        'withoutOverlapping' => true,
        'runInBackground' => false,
    ],
];
