<?php
/**
 * \file ConnectionLogger.php
 * \project 2spark-Library
 * \author Pierre TRANCHARD
 * \version 1.0
 * \date 26/02/15
 * \brief Trait for providing a set of methods related to Doctrine DBAL Connection
 * \details
 */

namespace Spark\FrameworkBundle\Traits;

use Doctrine\DBAL\Connection;

/**
 * Class ConnectionLogger
 *
 * @package Spark\FrameworkBundle\Traits
 */
trait ConnectionLogger
{
    /**
     * Disable the connection logger
     *
     * @param Connection $connection
     *
     * @return Connection
     */
    protected function disableConnectionLogger(Connection $connection)
    {
        $connection->getConfiguration()->setSQLLogger(null);

        return $connection;
    }
}