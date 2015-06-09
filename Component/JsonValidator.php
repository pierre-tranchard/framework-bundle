<?php
/**
 * \file JsonValidator.php
 * \project 2spark-Library
 * \author Pierre TRANCHARD
 * \version 1.0
 * \date 08/01/15
 * \brief
 * \details
 */

namespace Spark\FrameworkBundle\Component;

/**
 * Class JsonValidator
 *
 * @package Spark\FrameworkBundle\Component
 */
class JsonValidator
{
    /**
     * Determine if the content is a valid json string.
     *
     * @param string $string
     *
     * @return bool
     */
    public static function isValidJsonString($string = '')
    {
        json_decode($string);

        return (json_last_error() === JSON_ERROR_NONE);
    }
}
