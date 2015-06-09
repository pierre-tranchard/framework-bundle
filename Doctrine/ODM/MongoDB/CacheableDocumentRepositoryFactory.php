<?php
/**
 * \file CacheableDocumentRepositoryFactory.php
 * \project 2spark-Library
 * \author Pierre TRANCHARD
 * \version 1.0
 * \date 02/06/15
 * \brief
 * \details
 */

namespace Spark\FrameworkBundle\Doctrine\ODM\MongoDB;

use Doctrine\Common\Cache\CacheProvider;
use Doctrine\ODM\MongoDB\DocumentManager;
use Doctrine\ODM\MongoDB\Repository\RepositoryFactory;

/**
 * Class CacheableDocumentRepositoryFactory
 *
 * @package Spark\FrameworkBundle\Doctrine\ODM\MongoDB
 */
class CacheableDocumentRepositoryFactory implements RepositoryFactory
{

    /**
     * @var CacheProvider
     */
    protected $cacheProvider;

    /**
     * @var array
     */
    protected $repositoryList;

    /**
     * Constructor
     *
     * @param CacheProvider $cacheProvider
     */
    public function __construct(CacheProvider $cacheProvider)
    {
        $this->cacheProvider  = $cacheProvider;
        $this->repositoryList = array();
    }

    /**
     * Gets the repository for a document class.
     *
     * @param DocumentManager $documentManager The DocumentManager instance.
     * @param string          $documentName    The name of the document.
     *
     * @return \Doctrine\Common\Persistence\ObjectRepository
     */
    public function getRepository(DocumentManager $documentManager, $documentName)
    {
        $documentName = ltrim($documentName, '\\');

        if (isset($this->repositoryList[$documentName])) {
            return $this->repositoryList[$documentName];
        }

        $repository = $this->createRepository($documentManager, $documentName);

        $this->repositoryList[$documentName] = $repository;

        return $repository;
    }

    /**
     * Create a new repository instance for a document class.
     *
     * @param DocumentManager $documentManager The DocumentManager instance.
     * @param string          $documentName    The name of the document.
     *
     * @return \Doctrine\Common\Persistence\ObjectRepository
     */
    protected function createRepository(DocumentManager $documentManager, $documentName)
    {
        $metadata            = $documentManager->getClassMetadata($documentName);
        $repositoryClassName = $metadata->customRepositoryClassName;

        if ($repositoryClassName === null) {
            $configuration       = $documentManager->getConfiguration();
            $repositoryClassName = $configuration->getDefaultRepositoryClassName();
        }

        $reflection         = new \ReflectionClass($repositoryClassName);
        $numberOfParameters = $reflection->getMethod('__construct')->getNumberOfParameters();
        if ($numberOfParameters === 3) {
            return new $repositoryClassName($documentManager, $documentManager->getUnitOfWork(), $metadata);
        } else {
            return new $repositoryClassName(
                $documentManager,
                $documentManager->getUnitOfWork(),
                $metadata,
                $this->cacheProvider
            );
        }
    }
}
