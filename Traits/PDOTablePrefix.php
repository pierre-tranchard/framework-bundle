<?php
/**
 * \file PDOTablePrefix.php
 * \project 2spark-Library
 * \author Pierre TRANCHARD
 * \version 1.0
 * \date 05/02/15
 * \brief Trait for handling table prefix
 * \details
 */

namespace Spark\FrameworkBundle\Traits;

/**
 * Class PDOTablePrefix
 *
 * @package Spark\FrameworkBundle\Traits
 */
trait PDOTablePrefix
{
    /**
     * @var string|null
     */
    protected $tablePrefix;

    /**
     * Get table name.
     *
     * @param $tableName
     *
     * @return string
     */
    protected function getTableName($tableName)
    {
        if (is_null($this->tablePrefix)) {
            return $tableName;
        }

        return sprintf("%s%s", $this->tablePrefix, $tableName);
    }
}
