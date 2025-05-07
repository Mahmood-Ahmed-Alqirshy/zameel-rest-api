<?php

return [

    /*
    |--------------------------------------------------------------------------
    | OpenAI API Key and Organization
    |--------------------------------------------------------------------------
    |
    | Here you may specify your OpenAI API Key and organization. This will be
    | used to authenticate with the OpenAI API - you can find your API key
    | and organization on your OpenAI dashboard, at https://openai.com.
    */

    'api_key' => env('OPENAI_API_KEY'),
    'organization' => env('OPENAI_ORGANIZATION'),
    'assistant_key' => env('OPENAI_ASSISTANT_KEY'),
    'chat_model' => env('OPENAI_CHAT_MODEL', 'gpt-4.1-nano'),
    'summary_model' => env('OPENAI_SUMMARY_MODEL', 'gpt-4.1-nano'),
    'quiz_model' => env('OPENAI_QUIZ_MODEL', 'gpt-4.1-nano'),

    /*
    |--------------------------------------------------------------------------
    | Request Timeout
    |--------------------------------------------------------------------------
    |
    | The timeout may be used to specify the maximum number of seconds to wait
    | for a response. By default, the client will time out after 30 seconds.
    */

    'request_timeout' => env('OPENAI_REQUEST_TIMEOUT', 30),
];
