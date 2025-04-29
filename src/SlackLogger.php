<?php

namespace M3Team\SlackLogger;

use Illuminate\Support\Facades\Http;
use Monolog\Handler\AbstractProcessingHandler;
use Monolog\Logger;
use Monolog\LogRecord;

class SlackLogger
{
    public function __invoke(array $config): Logger
    {
        $handler = new class extends AbstractProcessingHandler {
            protected function write(LogRecord $record): void
            {
                $enabled = config('slack-logger.enabled');
                if (!$enabled) return;
                $token = config('slack-logger.token');
                $channel = config('slack-logger.log-channel');
                $level = str($record->level->getName())->upper()->toString();
                $message = $record->message;
                Http::withToken($token)
                    ->post('https://slack.com/api/chat.postMessage', [
                        'channel' => $channel,
                        'blocks' => [
                            [
                                "type" => "header",
                                "text" => [
                                    "type" => "plain_text",
                                    "text" => "$level"
                                ]
                            ], [
                                "type" => "section",
                                "text" => [
                                    "type" => "mrkdwn",
                                    "text" => "$message"
                                ]
                            ],
                        ]
                    ]);
            }
        };
        return new Logger('slack', [$handler]);
    }
}
