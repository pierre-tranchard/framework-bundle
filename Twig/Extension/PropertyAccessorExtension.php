<?php
/**
 * \file PropertyAccessorExtension.php
 * \author Pierre TRANCHARD <pierre@tranchard.net>
 * \version 1.0
 * \date 26/11/2015
 * \brief
 * \details
 */

namespace Spark\FrameworkBundle\Twig\Extension;

use Spark\FrameworkBundle\DependencyInjection\Configuration;
use Symfony\Component\PropertyAccess\PropertyAccess;

/**
 * Class PropertyAccessorExtension
 *
 * @package Spark\FrameworkBundle\Twig\Extension
 */
class PropertyAccessorExtension extends \Twig_Extension
{

    /**
     * @return array
     */
    public function getFunctions()
    {
        return array(
            'accessor' => new \Twig_SimpleFunction(
                'accessor', array($this, 'accessor',)
            ),
        );
    }

    /**
     * @param mixed  $objectOrArray
     * @param string $propertyPath
     * @param null   $fallbackValue
     *
     * @return string
     */
    public function accessor($objectOrArray, $propertyPath, $fallbackValue = null)
    {
        $accessor = PropertyAccess::createPropertyAccessor();
        if ($accessor->isReadable($objectOrArray, $propertyPath)) {
            return $accessor->getValue($objectOrArray, $propertyPath);
        }

        return is_null($fallbackValue) ? '' : $fallbackValue;
    }
    
    /**
     * Returns the name of the extension.
     *
     * @return string The extension name
     */
    public function getName()
    {
        return sprintf('%s.property_accessor_extension', Configuration::getRootNode());
    }
}
