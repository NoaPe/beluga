<?php

// config for NoaPe/Beluga
return [
    /**
     * Schema path
     */
    'schema_path' => base_path().'/database/schemas',

    /**
     * Default schema information value.
     */
    'default_schema_properties' => [
        'id' => true,
        'timestamps' => true,
    ],

    /**
     * Default data properties.
     */
    'default_type' => 'String',

    'prefix' => 'beluga',
    'middleware' => ['web'],

    'table_prefix' => 'beluga_',

    /**
     * Shell namespace.
     */
    'shell_namespace' => 'App\\Shells',

    /**
     * Shell namespace for internal shell.
     */
    'internal_shell_namespace' => 'NoaPe\\Beluga\\Http\\Models',

    /**
     * Array who associate data type alias to the object.
     */
    'data_types' => [
        'String' => NoaPe\Beluga\DataTypes\BString::class,
        'Text' => NoaPe\Beluga\DataTypes\Text::class,
        'Integer' => NoaPe\Beluga\DataTypes\Integer::class,
        'Float' => NoaPe\Beluga\DataTypes\BFloat::class,
        'Boolean' => NoaPe\Beluga\DataTypes\Boolean::class,
        'Date' => NoaPe\Beluga\DataTypes\Date::class,
        'DateTime' => NoaPe\Beluga\DataTypes\DateTime::class,
        'Time' => NoaPe\Beluga\DataTypes\Time::class,
        'Timestamp' => NoaPe\Beluga\DataTypes\Timestamp::class,
        'File' => NoaPe\Beluga\DataTypes\File::class,
        'Image' => NoaPe\Beluga\DataTypes\Image::class,

        'BelongsTo' => NoaPe\Beluga\DataTypes\Relations\BelongsTo::class,
        'HasMany' => NoaPe\Beluga\DataTypes\Relations\HasMany::class,
        'HasOne' => NoaPe\Beluga\DataTypes\Relations\HasOne::class,
    ],

    /**
     * Image path.
     */
    'image_path' => 'images',
];
