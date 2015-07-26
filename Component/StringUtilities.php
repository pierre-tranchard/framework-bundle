<?php
/**
 * \file StringUtilities.php
 * \author Pierre TRANCHARD <pierre@tranchard.net>
 * \version 1.0
 * \date 26/02/15
 * \brief Provide a set of methods for manipulating string
 * \details
 */

namespace Spark\FrameworkBundle\Component;

/**
 * Class StringUtilities
 *
 * @package Spark\FrameworkBundle\Component
 */
class StringUtilities
{
    /**
     * Replace spaces by a character in a given string
     *
     * @param string $subject
     * @param string $replace
     *
     * @return string
     */
    public static function replaceSpacesBy($subject, $replace = "-")
    {
        return str_replace(" ", $replace, $subject);
    }

    /**
     * Remove extension from a string representation of a file
     *
     * @param $subject
     *
     * @return string
     */
    public static function removeFileExtension($subject)
    {
        return preg_replace('/\\.[^.\\s]{3,4}$/', '', $subject);
    }

    /**
     * @static
     *
     * @param $text
     *
     * @return null|string
     */
    public static function slugify($text)
    {

        $text = preg_replace('~[^\\pL\d]+~u', '-', $text);

        $text = trim($text, '-');

        if (function_exists('iconv')) {
            $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);
        }

        $text = strtolower($text);

        $text = preg_replace('~[^-\w]+~', '', $text);

        return empty($text) ? null : $text;
    }
}