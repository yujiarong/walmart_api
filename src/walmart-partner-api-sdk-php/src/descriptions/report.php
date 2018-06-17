<?php return [
    'baseUrl' => 'https://marketplace.walmartapis.com',
    'apiVersion' => 'v2',
    'operations' => [
        'report' => [
            'httpMethod' => 'GET',
            'uri' => '/{ApiVersion}/getReport',
            'responseModel' => 'Result',
            'data' => [
                'xmlRoot' => [
                    'name' => 'Report',
                ],
            ],
            'parameters' => [
                'ApiVersion' => [
                    'required' => true,
                    'type'     => 'string',
                    'location' => 'uri',
                ],
                'Content-type' => [
                    'required' => true,
                    'type' => 'string',
                    'location' => 'header',
                    'default' => 'application/xml',
                ],
                'type' => [
                    'required' => true,
                    'type' => 'string',
                    'location' => 'query'
                ],
            ],
        ],

    ],
    'models' => [
        'Result' => [
            'type' => 'object',
            'properties' => [
                'statusCode' => ['location' => 'statusCode'],
            ],
            'additionalProperties' => [
                'location' => 'body'
            ],
        ]
    ]
];
