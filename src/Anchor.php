<?php 

namespace NoaPe\Beluga;

class Anchor
{
    use Concerns\HasJsonSchema,
        Concerns\HasInternalJsonSchema,
        Concerns\HasDatabaseSchema;

    
    private static $schemas;

    public static function getSchema($shell, $origin)
    {
        $name = get_class($shell);

        if (isset(self::$schemas[$name])) {
            return self::$schemas[$name];
        }

        $schema = self::getSchemaFromOrigin($shell, $origin);

        self::$schemas[$name] = $schema;

        return $schema;
    }

    /**
     * Get schema from origin.
     *
     * @param  \NoaPe\Beluga\Shell  $shell
     * @param  string  $origin
     * @return \NoaPe\Beluga\Http\Models\Table
     */
    protected static function getSchemaFromOrigin($shell, $origin)
    {
        if (method_exists(self::class, 'getSchemaFrom'.$origin)) {
            return self::{'getSchemaFrom'.$origin}($shell);
        } else {
            throw new \Exception('Schema origin "'.$origin.'" not found.');
        }
    }
}