<?php
/**
 * \file TablePrefixSubscriber.php
 * \author Pierre TRANCHARD <pierre@tranchard.net>
 * \version 1.0
 * \date 10/06/15
 * \brief
 * \details
 */

namespace Spark\FrameworkBundle\Event\Subscriber\Doctrine;

use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Event\LoadClassMetadataEventArgs;
use Doctrine\ORM\Mapping\ClassMetadataInfo;

/**
 * Class TablePrefixSubscriber
 *
 * @package Spark\FrameworkBundle\Event\Subscriber\Doctrine
 *
 * @codeCoverageIgnore
 */
class TablePrefixSubscriber implements EventSubscriber
{

    /**
     * @var string|null
     */
    protected $prefix;

    /**
     * Constructor
     *
     * @param null $prefix
     */
    public function __construct($prefix = null)
    {
        $this->prefix = $prefix;
    }

    /**
     * @param LoadClassMetadataEventArgs $eventArgs
     */
    public function loadClassMetadata(LoadClassMetadataEventArgs $eventArgs)
    {
        /** @var ClassMetadataInfo $classMetadata */
        $classMetadata = $eventArgs->getClassMetadata();
        if (is_null($this->prefix) === false && strlen($this->prefix) > 0) {
            if (0 !== strpos($classMetadata->getTableName(), $this->prefix)) {
                $classMetadata->setPrimaryTable(
                    array('name' => sprintf("%s%s", $this->prefix, $classMetadata->getTableName()))
                );
            }
            foreach ($classMetadata->getAssociationMappings() as $fieldName => $mapping) {
                if ($mapping['type'] == ClassMetadataInfo::MANY_TO_MANY) {
                    if (!isset($classMetadata->associationMappings[$fieldName]['joinTable'])) {
                        continue;
                    }
                    $mappedTableName = $classMetadata->associationMappings[$fieldName]['joinTable']['name'];
                    if (0 !== strpos($mappedTableName, $this->prefix)) {
                        $classMetadata->associationMappings[$fieldName]['joinTable']['name'] = sprintf(
                            "%s%s",
                            $this->prefix,
                            $mappedTableName
                        );
                    }
                }
            }
        }
    }

    /**
     * Returns an array of events this subscriber wants to listen to.
     *
     * @return array
     */
    public function getSubscribedEvents()
    {
        return array('loadClassMetadata');
    }
}
