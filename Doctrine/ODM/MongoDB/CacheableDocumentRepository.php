<?php
/**
 * \file CacheableDocumentRepository.php
 * \author Pierre TRANCHARD <pierre@tranchard.net>
 * \version 1.0
 * \date 02/06/15
 * \brief
 * \details
 */

namespace Spark\FrameworkBundle\Doctrine\ODM\MongoDB;

use Doctrine\Common\Cache\CacheProvider;
use Doctrine\ODM\MongoDB\DocumentManager;
use Doctrine\ODM\MongoDB\DocumentRepository;
use Doctrine\ODM\MongoDB\UnitOfWork;
use Doctrine\ODM\MongoDB\Mapping;

/**
 * Class CacheableDocumentRepository
 *
 * @package Spark\FrameworkBundle\Doctrine\ODM\MongoDB
 */
class CacheableDocumentRepository extends DocumentRepository
{
    /**
     * @var CacheProvider
     */
    protected $cacheProvider;

    /**
     * Constructor
     *
     * @param DocumentManager       $dm    The DocumentManager to use.
     * @param UnitOfWork            $uow   The UnitOfWork to use.
     * @param Mapping\ClassMetadata $class The class descriptor.
     * @param CacheProvider         $cacheProvider
     */
    public function __construct(
        DocumentManager $dm,
        UnitOfWork $uow,
        Mapping\ClassMetadata $class,
        CacheProvider $cacheProvider
    ) {
        parent::__construct($dm, $uow, $class);
        $this->cacheProvider = $cacheProvider;
    }

    /**
     * @return CacheProvider
     */
    public function getCacheProvider()
    {
        return $this->cacheProvider;
    }
}
