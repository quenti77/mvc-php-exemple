<?php

return [
    'name' => 'Mon super blog MVC',
    'env' => 'dev',

    'dic' => ROOT_PATH . '/app/configs/dic.php',
    'routes' => [
        ROOT_PATH . '/app/routes/account.php',
        ROOT_PATH . '/app/routes/blog.php'
    ]
];
