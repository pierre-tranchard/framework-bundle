<?php
/**
 * \file MultiCollectionsParamConverter.php
 * \project 2spark-Library
 * \author Pierre TRANCHARD
 * \version 1.0
 * \date 09/06/15
 * \brief
 * \details
 */

namespace Spark\FrameworkBundle\Request\ParamConverter;

use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\ORM\NoResultException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Request\ParamConverter\DoctrineParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Request\ParamConverter\ParamConverterInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * Class MultiCollectionsParamConverter
 *
 * @package Spark\FrameworkBundle\Request\ParamConverter
 */
class MultiCollectionsParamConverter extends DoctrineParamConverter implements ParamConverterInterface
{

    /**
     * Constructor
     *
     * @param ManagerRegistry|null $managerRegistry
     */
    public function __construct(ManagerRegistry $managerRegistry = null)
    {
        parent::__construct($managerRegistry);
    }

    /**
     * Stores the object in the request.
     *
     * @param Request        $request       The request
     * @param ParamConverter $configuration Contains the name, class and options of the object
     *
     * @return bool True if the object has been successfully set, else false
     */
    public function apply(Request $request, ParamConverter $configuration)
    {
        $name    = $configuration->getName();
        $classes = explode("|", $configuration->getClass());
        $options = $this->getOptions($configuration);

        if (null === $request->attributes->get($name, false)) {
            $configuration->setIsOptional(true);
        }

        foreach ($classes as $index => $class) {
            if (false === $object = $this->find($class, $request, $options, $name)) {
                if (false === $object = $this->findOneBy($class, $request, $options)) {
                    if ($configuration->isOptional()) {
                        $object = null;
                    } else {
                        throw new \LogicException(
                            'Unable to guess how to get a Doctrine instance from the request information.'
                        );
                    }
                }
            }

            if (null === $object) {
                if ($index == (count($classes) - 1) && $configuration->isOptional() === false) {
                    throw new NotFoundHttpException(sprintf('%s object not found.', implode(", ", $classes)));
                }
                continue;
            } else {
                $request->attributes->set($name, $object);
                break;
            }
        }

        return true;
    }

    /**
     * Checks if the object is supported.
     *
     * @param ParamConverter $configuration Should be an instance of ParamConverter
     *
     * @return bool True if the object is supported, else false
     */
    public function supports(ParamConverter $configuration)
    {
        if (null === $this->registry || !count($this->registry->getManagers())) {
            return false;
        }

        if (null === $configuration->getClass() || count(explode("|", $configuration->getClass())) === 0) {
            return false;
        }

        $options = $this->getOptions($configuration);

        $isSupported = true;
        foreach (explode("|", $configuration->getClass()) as $index => $class) {
            $manager = $this->getManager($options['manager'], $class);
            if (null === $manager) {
                $isSupported = false;
            } else {
                $isSupported = $manager->getMetadataFactory()->isTransient($class) === false;
            }
            if ($isSupported === false) {
                break;
            }
        }

        return $isSupported;
    }

    /**
     * @param ParamConverter $configuration
     *
     * @return array
     */
    protected function getOptions(ParamConverter $configuration)
    {
        return array_replace(
            array(
                'manager'    => null,
                'exclude'    => array(),
                'mapping'    => array(),
                'strip_null' => false,
            ),
            $configuration->getOptions()
        );
    }

    /**
     * @param $name
     * @param $class
     *
     * @return \Doctrine\Common\Persistence\ObjectManager|null
     */
    private function getManager($name, $class)
    {
        if (null === $name) {
            return $this->registry->getManagerForClass($class);
        }

        return $this->registry->getManager($name);
    }

    /**
     * @param         $class
     * @param Request $request
     * @param         $options
     *
     * @return bool|mixed|void
     */
    protected function findOneBy($class, Request $request, $options)
    {
        if (!$options['mapping']) {
            $keys               = $request->attributes->keys();
            $options['mapping'] = $keys ? array_combine($keys, $keys) : array();
        }

        foreach ($options['exclude'] as $exclude) {
            unset($options['mapping'][$exclude]);
        }

        if (!$options['mapping']) {
            return false;
        }

        if (isset($options['id']) && null === $request->attributes->get($options['id'])) {
            return false;
        }

        $criteria = array();
        $manager  = $this->getManager($options['manager'], $class);
        $metadata = $manager->getClassMetadata($class);

        $mapMethodSignature = isset($options['repository_method'])
            && isset($options['map_method_signature'])
            && $options['map_method_signature'] === true;

        foreach ($options['mapping'] as $attribute => $field) {
            if ($metadata->hasField($field)
                || ($metadata->hasAssociation($field) && $metadata->isSingleValuedAssociation($field))
                || $mapMethodSignature
            ) {
                $criteria[$field] = $request->attributes->get($attribute);
            }
        }

        if ($options['strip_null']) {
            $criteria = array_filter(
                $criteria,
                function ($value) {
                    return !is_null($value);
                }
            );
        }

        if (!$criteria) {
            return false;
        }

        if (isset($options['repository_method'])) {
            $repositoryMethod = $options['repository_method'];
        } else {
            $repositoryMethod = 'findOneBy';
        }

        try {
            if ($mapMethodSignature) {
                return $this->findDataByMapMethodSignature($manager, $class, $repositoryMethod, $criteria);
            }

            return $manager->getRepository($class)->$repositoryMethod($criteria);
        } catch (NoResultException $e) {
            return;
        }
    }

    /**
     * @param ObjectManager $manager
     * @param               $class
     * @param               $repositoryMethod
     * @param               $criteria
     *
     * @return mixed
     */
    private function findDataByMapMethodSignature(ObjectManager $manager, $class, $repositoryMethod, $criteria)
    {
        $arguments  = array();
        $repository = $manager->getRepository($class);
        $ref        = new \ReflectionMethod($repository, $repositoryMethod);
        foreach ($ref->getParameters() as $parameter) {
            if (array_key_exists($parameter->name, $criteria)) {
                $arguments[] = $criteria[$parameter->name];
            } elseif ($parameter->isDefaultValueAvailable()) {
                $arguments[] = $parameter->getDefaultValue();
            } else {
                throw new \InvalidArgumentException(
                    sprintf(
                        'Repository method "%s::%s" requires that you provide a value for the "$%s" argument.',
                        get_class($repository),
                        $repositoryMethod,
                        $parameter->name
                    )
                );
            }
        }

        return $ref->invokeArgs($repository, $arguments);
    }

    /**
     * @param         $class
     * @param Request $request
     * @param         $options
     * @param         $name
     *
     * @return bool|void
     */
    protected function find($class, Request $request, $options, $name)
    {
        if ($options['mapping'] || $options['exclude']) {
            return false;
        }

        $identifier = $this->getIdentifier($request, $options, $name);

        if (false === $identifier || null === $identifier) {
            return false;
        }

        if (isset($options['repository_method'])) {
            $method = $options['repository_method'];
        } else {
            $method = 'find';
        }

        try {
            return $this->getManager($options['manager'], $class)->getRepository($class)->$method($identifier);
        } catch (NoResultException $e) {
            return;
        }
    }
}
