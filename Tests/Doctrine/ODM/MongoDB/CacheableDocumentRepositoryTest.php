<?php
/**
 * \file CacheableDocumentRepositoryTest.php
 * \author Pierre TRANCHARD <pierre@tranchard.net>
 * \version 1.0
 * \date 02/07/15
 * \brief
 * \details
 */

namespace Spark\FrameworkBundle\Tests\Doctrine\ODM\MongoDB;

use Spark\FrameworkBundle\Doctrine\ODM\MongoDB\CacheableDocumentRepository;

/**
 * Class CacheableDocumentRepositoryTest
 *
 * @package Spark\FrameworkBundle\Tests\Doctrine\ODM\MongoDB
 */
class CacheableDocumentRepositoryTest extends \PHPUnit_Framework_TestCase
{

    /**
     * Test Get Cache Provider
     */
    public function testGetCacheProvider()
    {
        $dmMock            = $this->getMock('\Doctrine\ODM\MongoDB\DocumentManager', array(), array(), '', false);
        $uowMock           = $this->getMock('\Doctrine\ODM\MongoDB\UnitOfWork', array(), array(), '', false);
        $metaDataMock      = $this->getMock('\Doctrine\ODM\MongoDB\Mapping\ClassMetadata', array(), array(), '', false);
        $cacheProviderMock = $this->getMock('\Doctrine\Common\Cache\MemcachedCache', array(), array(), '', false);
        $repository        = new CacheableDocumentRepository($dmMock, $uowMock, $metaDataMock, $cacheProviderMock);

        $this->assertEquals($cacheProviderMock, $repository->getCacheProvider());
    }
}
