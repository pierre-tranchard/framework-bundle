<?php
/**
 * \file FileWriterInterface.php
 * \author Anton Lytvynov <anton.lytvynov@2spark.com>
 * \version 1.0
 * \date 09/03/16
 * \brief
 * \details
 */

namespace Spark\FrameworkBundle\Services;

/**
 * Interface FileWriterInterface
 *
 * @package Spark\FrameworkBundle\Services
 */
interface FileWriterInterface
{

    /**
     * @param string $folderPath
     * @param string $filePath
     * @param array  $data
     * @param array  $options
     */
    public function write($folderPath, $filePath, array $data, array $options);
}
