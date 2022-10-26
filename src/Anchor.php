<?php

namespace NoaPe\Beluga;

class Anchor
{
    use Concerns\HasJsonSchema,
        Concerns\HasInternalJsonSchema,
        Concerns\HasDatabaseSchema;

    /**
     * Schema array
     *
     * @var array
     */
    private static $schemas;

    /**
     * Return schema from specified origin
     *
     * @param  \NoaPe\Beluga\Shell  $shell
     * @param  string  $origin
     * @return mixed
     */
    public static function getSchema($shell, $origin, $folder)
    {
        $name = get_class($shell);

        if (isset(self::$schemas[$name])) {
            return self::$schemas[$name];
        }

        $schema = self::getSchemaFromOrigin($shell, $origin, $folder);

        self::$schemas[$name] = $schema;

        return $schema;
    }

    /**
     * Get schema from origin.
     *
     * @param  \NoaPe\Beluga\Shell  $shell
     * @param  string  $origin
     * @return mixed
     */
    protected static function getSchemaFromOrigin($shell, $origin, $folder)
    {
        if (method_exists(self::class, 'getSchemaFrom'.$origin)) {
            return self::{'getSchemaFrom'.$origin}($shell, $folder);
        } else {
            throw new \Exception('Schema origin "'.$origin.'" not found.');
        }
    }
}
