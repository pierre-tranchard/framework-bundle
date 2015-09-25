<?php
/**
 * \file CacheableDocumentRepositoryFactoryTest.php
 * \author Pierre TRANCHARD <pierre@tranchard.net>
 * \version 1.0
 * \date 02/07/15
 * \brief
 * \details
 */

namespace Spark\FrameworkBundle\Tests\Doctrine\ODM\MongoDB;

use Spark\FrameworkBundle\Doctrine\ODM\MongoDB\CacheableDocumentRepositoryFactory;

/**
 * Class CacheableDocumentRepositoryFactoryTest
 *
 * @package Spark\FrameworkBundle\Tests\Doctrine\ODM\MongoDB
 */
class CacheableDocumentRepositoryFactoryTest extends \PHPUnit_Framework_TestCase
{

    /**
     * Test get repository
     */
    public function testGetRepositoryWithDefaultRepository()
    {
        $configurationMock = $this->getMock('\Doctrine\ODM\MongoDB\Configuration', array(), array(), '', false);
        $configurationMock->expects($this->any())
            ->method('getDefaultRepositoryClassName')
            ->willReturn('\Doctrine\ODM\MongoDB\DocumentRepository');

        $uowMock = $this->getMock('\Doctrine\ODM\MongoDB\UnitOfWork', array(), array(), '', false);
        $cacheProviderMock = $this->getMock('\Doctrine\Common\Cache\MemcachedCache', array(), array(), '', false);
        $metaDataMock = $this->getMock('\Doctrine\ODM\MongoDB\Mapping\ClassMetadata', array(), array(), '', false);
        $dmMock = $this->getMock('\Doctrine\ODM\MongoDB\DocumentManager', array(), array(), '', false);
        $dmMock->expects($this->any())
            ->method('getClassMetadata')
            ->withAnyParameters()
            ->willReturn($metaDataMock);
        $dmMock->expects($this->any())
            ->method('getConfiguration')
            ->willReturn($configurationMock);
        $dmMock->expects($this->any())
            ->method('getUnitOfWork')
            ->willReturn($uowMock);
        $factory = new CacheableDocumentRepositoryFactory($cacheProviderMock);

        $this->assertInstanceOf(
            '\Doctrine\ODM\MongoDB\DocumentRepository',
            $factory->getRepository($dmMock, 'SparkFrameworkBundle\Document\Document')
        );
    }

    /**
     * Test get repository
     */
    public function testGetRepositoryWithCacheableRepository()
    {
        $configurationMock = $this->getMock('\Doctrine\ODM\MongoDB\Configuration', array(), array(), '', false);
        $configurationMock->expects($this->any())
            ->method('getDefaultRepositoryClassName')
            ->willReturn('\Spark\FrameworkBundle\Doctrine\ODM\MongoDB\CacheableDocumentRepository');

        $uowMock = $this->getMock('\Doctrine\ODM\MongoDB\UnitOfWork', array(), array(), '', false);
        $cacheProviderMock = $this->getMock('\Doctrine\Common\Cache\MemcachedCache', array(), array(), '', false);
        $metaDataMock = $this->getMock('\Doctrine\ODM\MongoDB\Mapping\ClassMetadata', array(), array(), '', false);
        $dmMock = $this->getMock('\Doctrine\ODM\MongoDB\DocumentManager', array(), array(), '', false);
        $dmMock->expects($this->any())
            ->method('getClassMetadata')
            ->withAnyParameters()
            ->willReturn($metaDataMock);
        $dmMock->expects($this->any())
            ->method('getConfiguration')
            ->willReturn($configurationMock);
        $dmMock->expects($this->any())
            ->method('getUnitOfWork')
            ->willReturn($uowMock);
        $factory = new CacheableDocumentRepositoryFactory($cacheProviderMock);

        $this->assertInstanceOf(
            '\Spark\FrameworkBundle\Doctrine\ODM\MongoDB\CacheableDocumentRepository',
            $factory->getRepository($dmMock, 'SparkFrameworkBundle\Document\Document')
        );
        $reflection = new \ReflectionClass($factory);
        $repositoryList = $reflection->getProperty('repositoryList');
        $repositoryList->setAccessible(true);
        $this->assertNotEmpty($repositoryList->getValue($factory));
        $this->assertInstanceOf(
            '\Spark\FrameworkBundle\Doctrine\ODM\MongoDB\CacheableDocumentRepository',
            $factory->getRepository($dmMock, 'SparkFrameworkBundle\Document\Document')
        );
    }
}
