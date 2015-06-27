<?php

return [
    'privacy' => [
        'type'     => 'anomaly.field_type.select',
        'disabled' => 'edit',
        'config'   => [
            'options' => [
                'private' => 'anomaly.extension.local_storage_adapter::configuration.privacy.option.private',
                'public'  => 'anomaly.extension.local_storage_adapter::configuration.privacy.option.public'
            ]
        ]
    ]
];
