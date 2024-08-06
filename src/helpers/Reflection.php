<?php
/**
 * Template Comments plugin for Craft CMS
 *
 * Adds a HTML comment to demarcate each Twig template that is included or extended.
 *
 * @link      https://nystudio107.com/
 * @copyright Copyright (c)  nystudio107
 */

namespace nystudio107\templatecomments\helpers;

use ReflectionException;
use ReflectionObject;
use ReflectionProperty;

/**
 * @author    nystudio107
 * @package   TemplateComments
 * @since     4.0.2
 */
class Reflection
{
    // Public static Methods
    // =========================================================================
    /**
     * @param object $object
     * @param string $propertyName
     *
     * @return ReflectionProperty
     * @throws ReflectionException
     */
    public static function getReflectionProperty(object $object, string $propertyName): ReflectionProperty
    {
        $reflectionObject = new ReflectionObject($object);

        $reflectionProperty = null;

        if ($reflectionObject->hasProperty($propertyName)) {
            $reflectionProperty = $reflectionObject->getProperty($propertyName);
        } else {

            // This is needed for private parent properties only.
            $parent = $reflectionObject->getParentClass();
            while ($reflectionProperty === null && $parent !== false) {
                if ($parent->hasProperty($propertyName)) {
                    $reflectionProperty = $parent->getProperty($propertyName);
                }

                $parent = $parent->getParentClass();
            }
        }

        if (!$reflectionProperty) {
            throw new ReflectionException("Property not found: " . $propertyName);
        }

        return $reflectionProperty;
    }
}
