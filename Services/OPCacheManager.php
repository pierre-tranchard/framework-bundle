<?php

/**
 * \file OPCacheManager.php
 * \author Anton Lytvynov <anton.lytvynov@2spark.com>
 * \version 1.0
 * \date 09/03/16
 * \brief
 * \details
 */

namespace Spark\FrameworkBundle\Services;

/**
 * Class OPCacheManager
 *
 * @codeCoverageIgnore
 */
class OPCacheManager
{

    /**
     * Add file to OPCache.
     *
     * @param string $filePath
     *
     * @return bool
     */
    public function save($filePath)
    {
        return opcache_compile_file($filePath);
    }

    /**
     * Remove file from OPCache.
     *
     * @param string $filePath
     *
     * @return bool
     */
    public function remove($filePath)
    {
        return opcache_invalidate($filePath, true);
    }

    /**
     * Reset OPCache.
     *
     * @return bool
     */
    public function reset()
    {
        return opcache_reset();
    }
}