<?php
/**
 * \file NotImplementedException.php
 * \project 2spark-symfony2
 * \author Pierre TRANCHARD
 * \version 1.0
 * \date 03/06/15
 * \brief
 * \details
 */

namespace Spark\FrameworkBundle\Exception;

/**
 * Class NotImplementedException
 *
 * @package Spark\FrameworkBundle\Exception
 */
class NotImplementedException extends \RuntimeException
{

    /**
     * @param $method
     * @param $repositoryName
     *
     * @return NotImplementedException
     */
    public static function repository($method, $repositoryName)
    {
        return new self(sprintf("%s method was not found in %s repository", $method, $repositoryName));
    }
}
