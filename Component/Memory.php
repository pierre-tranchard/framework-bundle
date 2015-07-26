<?php
/**
 * \file Memory.php
 * \author Pierre TRANCHARD <pierre@tranchard.net>
 * \version 1.0
 * \date 12/01/15
 * \brief Class designed to provide a readable string of memory consumption
 * \details
 */

namespace Spark\FrameworkBundle\Component;

/**
 * Class Memory
 *
 * @package Spark\FrameworkBundle\Component
 */
class Memory
{
    /**
     * Converts given amount of memory into the best readable unit
     *
     * @param $size
     *
     * @return string
     */
    protected static function convert($size)
    {
        $unit = array('B', 'KB', 'MB', 'GB', 'TB', 'PB');

        return @round($size / pow(1024, ($i = floor(log($size, 1024)))), 2) . ' ' . $unit[intval($i)];
    }

    /**
     * Returns memory usage
     *
     * @return string
     */
    public static function memoryUsage()
    {
        return static::convert(memory_get_usage(true));
    }

    /**
     * Returns memory peak
     *
     * @return string
     */
    public static function memoryPeak()
    {
        return static::convert(memory_get_peak_usage(true));
    }
}
