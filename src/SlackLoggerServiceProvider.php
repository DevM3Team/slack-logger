<?php

namespace M3Team\SlackLogger;

use Illuminate\Support\ServiceProvider;

class SlackLoggerServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->publishes([
            __DIR__.'/../config/slack-logger.php' => config_path('slack-logger.php')
        ]);
    }
}
