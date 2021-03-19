<?php


namespace Bx\Service\Gen\Fields;


use Bitrix\Main\UI\ImageEditor\Proxy;
use Bx\Service\Gen\Interfaces\FieldInterface;
use Bx\Service\Gen\Interfaces\SchemaInterface;
use Faker\Generator;

class Factory
{
    /**
     * @var Generator
     */
    private static $faker;

    /**
     * @return Generator
     */
    public static function getGenerator(): Generator
    {
        if (static::$faker instanceof Generator) {
            return static::$faker;
        }

        static::$faker = \Faker\Factory::create();

        return static::$faker;
    }

    /**
     * @param array $data
     * @param array $fullSchema
     * @param string|null $name
     * @param SchemaInterface|null $parent
     * @return FieldInterface
     */
    public static function createField(
        array $data,
        array $fullSchema,
        string $name = null,
        SchemaInterface $parent = null
    ): FieldInterface
    {
        return static::prepareField(
            static::internalGenerator($data, $fullSchema, $name),
            $data,
            $parent
        );
    }

    /**
     * @param array $data
     * @param array $fullSchema
     * @param string|null $name
     * @return FieldInterface
     */
    private static function internalGenerator(
        array $data,
        array $fullSchema,
        string $name = null
    ): FieldInterface
    {
        $type = !empty($data['type']) ? ($data['format'] ?? $data['type']) : null;
        $enum = $data['enum'] ?? null;
        if (!empty($enum)) {
            $type = 'enum';
        }

        $fakerStepFrom = $data['x-faker-step-from'] ?? null;
        $fakerStepTo = $data['x-faker-step-to'] ?? null;
        $fakerOffset = $data['x-faker-offset'] ?? null;
        $fakerLimit = $data['x-faker-limit'] ?? null;
        $fakerType = $data['x-faker-type'] ?? null;
        if (!empty($fakerType)) {
            $type = $fakerType;
        }

        $faker = static::getGenerator();
        $properties = $data['properties'] ?? [];
        $ref = $data['$ref'] ?? null;
        if (empty($properties) && !empty($ref)) {
            $data = static::getRefData($ref, $fullSchema);
            $properties = $data['properties'] ?? [];
        }

        if (!empty($properties)) {
            /**
             * @var SchemaInterface $schema
             */
            $schema = new Schema($faker, $name);
            foreach ($properties as $propertyName => $propertyData) {
                $ref = $propertyData['$ref'];
                if (!empty($ref)) {
                    $propertyData = static::getRefData($ref, $fullSchema);
                }

                static::createField($propertyData, $fullSchema, $propertyName, $schema);
            }

            return $schema;
        }

        switch ($type) {
            case 'integer':
            case 'number':
                return new IntegerField($faker, $name, $fakerOffset, $fakerLimit);
            case 'increment':
                $field = new IncrementField($faker, $name, $fakerOffset, $fakerLimit);
                $field->setStepBetween($fakerStepFrom, $fakerStepTo);
                return $field;
            case 'float':
            case 'double':
                return new FloatField($faker, $name);
            case 'boolean':
                return new BooleanField($faker, $name);
            case 'date':
                return new DateField($faker, $name, $fakerOffset, $fakerLimit);
            case 'date-time':
                return new DateTimeField($faker, $name, $fakerOffset, $fakerLimit);
            case 'enum':
                return new EnumField($faker, $name, $enum);
            case 'file':
                return new FileField($faker, $name);
            case 'image':
                return new ImageField($faker, $name);
            case 'email':
                return new EmailField($faker, $name);
            case 'phone':
                return new PhoneField($faker, $name);
            case 'first-name':
                return new PersonFirstNameField($faker, $name);
            case 'last-name':
                return new PersonLastNameField($faker, $name);
            case 'full-name':
                return new PersonFullNameField($faker, $name);
            case 'array':
                $itemData = $data['items'] ?? [];
                $itemField = static::createField($itemData, $fullSchema, $name);
                return new ArrayField($faker, $name, $itemField, $fakerLimit ?? 30);
            default:
                return new StringField($faker, $name, $fakerLimit);
        }
    }

    /**
     * @param FieldInterface $field
     * @param array $data
     * @param SchemaInterface|null $parent
     * @return FieldInterface
     */
    private static function prepareField(FieldInterface $field, array $data, SchemaInterface $parent = null): FieldInterface
    {
        if (!($field instanceof SchemaInterface)) {
            $fakerSource = $data['x-faker-source'] ?? null;
            $field = new ProxyField($field, $fakerSource);
        }

        if (!$parent) {
            return $field;
        }

        $field->setParent($parent);
        $parent->addField($field);

        return $field;
    }

    /**
     * @param string $ref
     * @param array $fullSchema
     * @return array
     */
    public static function getRefData(string $ref, array $fullSchema): array
    {
        $ref = str_replace('#/', '', $ref);
        $keys = explode('/', $ref);

        $data = $fullSchema;
        foreach ($keys as $key) {
            $data = $data[$key] ?? null;
            if (is_null($data)) {
                break;
            }
        }

        return $data ?? [];
    }
}