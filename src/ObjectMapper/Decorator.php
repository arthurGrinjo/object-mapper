<?php

declare(strict_types=1);

namespace App\ObjectMapper;

use ReflectionClass;
use ReflectionException;
use stdClass;
use Symfony\Component\DependencyInjection\Attribute\AsDecorator;
use Symfony\Component\ObjectMapper\Attribute\Map;
use Symfony\Component\ObjectMapper\ObjectMapperInterface;

#[AsDecorator(decorates: ObjectMapperInterface::class)]
readonly class Decorator implements ObjectMapperInterface
{
    /**
     * todo: Add validator
     */

    public function __construct(
        private ObjectMapperInterface $innerMapper
    ) {}

    /**
     * @throws ReflectionException
     */
    public function map(object $source, object|string|null $target = null, array $context = []): object
    {
        /**
         * Map object classes per property
         */
        foreach (new ReflectionClass($target)->getConstructor()->getParameters() as $param) {
            /**
             * Map object class
             */
            $type = $param->getType()->getName();
            if (class_exists($type)) {
                $map[$param->getName()] = $type;
                continue;
            }

            /**
             * Map object class for array of objects
             */
            $reflectionAttribute = null;
            if (
                is_array($param->getAttributes())
                && empty($param->getAttributes()) === false
            ) {
                $reflectionAttribute = $param->getAttributes()[0];
            }

            if (
                isset($reflectionAttribute)
                && $reflectionAttribute->getName() === Map::class
                && array_key_exists('target', $reflectionAttribute->getArguments())
            ) {
                $map[$param->getName()] = $reflectionAttribute->getArguments()['target'];
            }
        }

        /**
         * Loop over properties and map the data
         */
        $newSource = (new stdClass());
        foreach ($source as $key => $value) {
            $newKey = $this->convertKeysToCamelCase($key);

            if (is_object($value) and isset($map[$key])) {
                $value = $this->innerMapper->map(
                    $value,
                    $map[$key]
                );
            }

            if (is_array($value) and isset($map[$key])) {
                foreach($value as $arrayKey => $arrayValue) {
                    $value[$arrayKey] = $this->innerMapper->map(
                        $arrayValue,
                        $map[$key],
                    );
                }
            }

            $newSource->$newKey = $value;
        }
        return $this->innerMapper->map($newSource, $target);
    }

    private function convertKeysToCamelCase(string $key): string
    {
        return lcfirst(str_replace('_', '', ucwords($key, '_')));
    }
}
