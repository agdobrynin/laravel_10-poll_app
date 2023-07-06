<?php
/*
 * Main config for Poll App.
 */
return [
    'limit' => [
        'vote' => [
            /*
            * Turn off limit set "max_attempts" is null or zero (0).
            */
            'max_attempts' => env('APP_POLL_VOTE_LIMIT_ATTEMPTS', 1),
            'decay_seconds' => env('APP_POLL_VOTE_LIMIT_DECAY_SECONDS', 600),
        ],
    ],
];
