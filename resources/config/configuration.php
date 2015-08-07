<?php

return [
    'privacy' => [
        'type'     => 'anomaly.field_type.select',
        'required' => true,
        'config'   => [
            'options' => [
                'public'  => 'anomaly.extension.local_storage_adapter::configuration.privacy.option.public',
                'private' => 'anomaly.extension.local_storage_adapter::configuration.privacy.option.private'
            ]
        ]
    ]
];
