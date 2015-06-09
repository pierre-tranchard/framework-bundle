<?php
/**
 * \file Grouper.php
 * \project 2spark-Library
 * \author Pierre TRANCHARD
 * \version 1.0
 * \date 08/06/15
 * \brief
 * \details
 */

namespace Spark\FrameworkBundle\Component;

use Doctrine\Common\Collections\ArrayCollection;

/**
 * Interface Grouper
 *
 * @package Spark\FrameworkBundle\Component
 */
interface Grouper
{

    /**
     * @param ArrayCollection $collection
     * @param string          $key
     *
     * @return ArrayCollection
     */
    public static function groupBy(ArrayCollection $collection, $key);
}
