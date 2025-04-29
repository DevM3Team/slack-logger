<?php
return [
    'enabled' => env('SLACK_LOG_ENABLED', false),
    'token' => env('SLACK_BOT_TOKEN'),
    'log-channel' => env('SLACK_LOG_CHANNEL')
];
