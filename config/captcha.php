<?php

return [
    'secret' => config('captcha.secret'),
    'sitekey' => config('captcha.sitekey'),
    'options' => [
        'timeout' => 30,
    ],
];
