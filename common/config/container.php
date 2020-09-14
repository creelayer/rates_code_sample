<?php

$params = require_once 'params.php';
$params_local = require_once 'params-local.php';

use common\sources\Source;
use common\sources\ApiLayerSource;


return [
    'singletons' => [
        Source::class => [
            ['class' => ApiLayerSource::class],
            [$params_local['api_url'], $params_local['api_access_key']]
        ]
    ]
];