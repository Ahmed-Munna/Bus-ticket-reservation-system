<?php

use Monolog\Handler\NullHandler;
use Monolog\Handler\StreamHandler;
use Monolog\Handler\SyslogUdpHandler;

return [

    /*
    |--------------------------------------------------------------------------
    | Default Log Channel
    |--------------------------------------------------------------------------
    |
    | This option defines the default log channel that gets used when writing
    | messages to the logs. The name specified in this option should match
    | one of the channels defined in the "channels" configuration array.
    |
    */

    'default' => env('LOG_CHANNEL', 'stack'),

    /*
    |--------------------------------------------------------------------------
    | Deprecations Log Channel
    |--------------------------------------------------------------------------
    |
    | This option controls the log channel that should be used to log warnings
    | regarding deprecated PHP and library features. This allows you to get
    | your application ready for upcoming major versions of dependencies.
    |
    */

    'deprecations' => [
        'channel' => env('LOG_DEPRECATIONS_CHANNEL', 'null'),
        'trace' => false,
    ],

    /*
    |--------------------------------------------------------------------------
    | Log Channels
    |--------------------------------------------------------------------------
    |
    | Here you may configure the log channels for your application. Out of
    | the box, Laravel uses the Monolog PHP logging library. This gives
    | you a variety of powerful log handlers / formatters to utilize.
    |
    | Available Drivers: "single", "daily", "slack", "syslog",
    |                    "errorlog", "monolog",
    |                    "custom", "stack"
    |
    */

    'channels' => [
        'stack' => [
            'driver' => 'stack',
            'channels' => ['single'],
            'ignore_exceptions' => false,
        ],

        'single' => [
            'driver' => 'single',
            'path' => storage_path('logs/laravel.log'),
            'level' => env('LOG_LEVEL', 'debug'),
        ],

        'AuthController' => [
            'driver' => 'single',
            'path' => storage_path('logs/controllers/AuthController.log'),
            'level' => env('LOG_LEVEL', 'debug'),
        ],
        
        'SocialiteLoginController' => [
            'driver' => 'single',
            'path' => storage_path('logs/controllers/SocialiteLoginController.log'),
            'level' => env('LOG_LEVEL', 'debug'),
        ],

        'ProfileUpdateController' => [
            'driver' => 'single',
            'path' => storage_path('logs/controllers/ProfileUpdateController.log'),
            'level' => env('LOG_LEVEL', 'debug'),
        ],

        'ManageStaffController' => [
            'driver' => 'single',
            'path' => storage_path('logs/controllers/ManageStaffController.log'),
            'level' => env('LOG_LEVEL', 'debug'),
        ],

        'CounterController' => [
            'driver' => 'single',
            'path' => storage_path('logs/controllers/CounterController.log'),
            'level' => env('LOG_LEVEL', 'debug'),
        ],
        
        'VehicleTypeController' => [
            'driver' => 'single',
            'path' => storage_path('logs/controllers/VehicleTypeController.log'),
            'level' => env('LOG_LEVEL', 'debug'),
        ],
        
        'VehicleController' => [
            'driver' => 'single',
            'path' => storage_path('logs/controllers/VehicleController.log'),
            'level' => env('LOG_LEVEL', 'debug'),
        ],

        'TripsRouteController' => [
                    'driver' => 'single',
                    'path' => storage_path('logs/controllers/TripsRouteController.log'),
                    'level' => env('LOG_LEVEL', 'debug'),
        ],
        
        'TripsRouteController' => [
                    'driver' => 'single',
                    'path' => storage_path('logs/controllers/TripsRouteController.log'),
                    'level' => env('LOG_LEVEL', 'debug'),
        ],
        'TicketPriceController' => [
                    'driver' => 'single',
                    'path' => storage_path('logs/controllers/TripsRouteController.log'),
                    'level' => env('LOG_LEVEL', 'debug'),
        ],
        'ScheduleController' => [
                    'driver' => 'single',
                    'path' => storage_path('logs/controllers/TripsRouteController.log'),
                    'level' => env('LOG_LEVEL', 'debug'),
        ],
        'TripController' => [
                    'driver' => 'single',
                    'path' => storage_path('logs/controllers/TripController.log'),
                    'level' => env('LOG_LEVEL', 'debug'),
        ],
        'TicketBookingFromAgentController' => [
                    'driver' => 'single',
                    'path' => storage_path('logs/controllers/TicketBookingFromAgentController.log'),
                    'level' => env('LOG_LEVEL', 'debug'),
        ],

        'daily' => [
            'driver' => 'daily',
            'path' => storage_path('logs/laravel.log'),
            'level' => env('LOG_LEVEL', 'debug'),
            'days' => 14,
        ],

        'slack' => [
            'driver' => 'slack',
            'url' => env('LOG_SLACK_WEBHOOK_URL'),
            'username' => 'Laravel Log',
            'emoji' => ':boom:',
            'level' => env('LOG_LEVEL', 'critical'),
        ],

        'papertrail' => [
            'driver' => 'monolog',
            'level' => env('LOG_LEVEL', 'debug'),
            'handler' => env('LOG_PAPERTRAIL_HANDLER', SyslogUdpHandler::class),
            'handler_with' => [
                'host' => env('PAPERTRAIL_URL'),
                'port' => env('PAPERTRAIL_PORT'),
                'connectionString' => 'tls://'.env('PAPERTRAIL_URL').':'.env('PAPERTRAIL_PORT'),
            ],
        ],

        'stderr' => [
            'driver' => 'monolog',
            'level' => env('LOG_LEVEL', 'debug'),
            'handler' => StreamHandler::class,
            'formatter' => env('LOG_STDERR_FORMATTER'),
            'with' => [
                'stream' => 'php://stderr',
            ],
        ],

        'syslog' => [
            'driver' => 'syslog',
            'level' => env('LOG_LEVEL', 'debug'),
        ],

        'errorlog' => [
            'driver' => 'errorlog',
            'level' => env('LOG_LEVEL', 'debug'),
        ],

        'null' => [
            'driver' => 'monolog',
            'handler' => NullHandler::class,
        ],

        'emergency' => [
            'path' => storage_path('logs/laravel.log'),
        ],
    ],

];
