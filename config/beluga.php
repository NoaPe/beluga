<?php

// config for NoaPe/Beluga
return [
    /**
     * Schema path
     */
    'schema_path' => __DIR__.'/../database/schemas',

    /**
     * Default schema information value.
     */
    'default_schema_properties' => [
        'id' => true,
        'timestamps' => true
    ],

    /**
     * Default data properties.
     */
    'default_data_properties' => [
        'type' => 'integer',
        'required' => false
    ]
];
