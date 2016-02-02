<?php
/**
 * \file FormFactory.php
 * \author Pierre TRANCHARD <pierre@tranchard.net>
 * \version 1.5
 * \date 02/06/15
 * \brief
 * \details
 */

namespace Spark\FrameworkBundle\Form\Factory;

use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Form\FormInterface;

/**
 * Class FormFactory
 *
 * @package Spark\FrameworkBundle\Form\Factory
 *
 * @codeCoverageIgnore
 */
class FormFactory
{

    /**
     * @var FormFactoryInterface
     */
    protected $formFactory;
    /**
     * @var string
     */
    protected $name;
    /**
     * @var string
     */
    protected $type;
    /**
     * @var array
     */
    protected $validationGroups;

    /**
     * Constructor.
     *
     * @param FormFactoryInterface $formFactory
     * @param string               $name
     * @param string               $type
     * @param array                $validationGroups
     */
    public function __construct(FormFactoryInterface $formFactory, $name, $type, array $validationGroups = array())
    {
        $this->formFactory      = $formFactory;
        $this->name             = $name;
        $this->type             = $type;
        $this->validationGroups = $validationGroups;
    }

    /**
     * Create form
     *
     * @param array $validationGroups
     *
     * @return FormInterface
     */
    public function createForm(array $validationGroups = array())
    {
        /**
         * BC check
         */
        if (\AppKernel::VERSION_ID < 20800) {

            return $this->formFactory->createNamed(
                $this->name,
                $this->type,
                null,
                array('validation_groups' => array_merge($this->validationGroups, $validationGroups))
            );
        }

        return $this->formFactory->createNamed(
            $this->name,
            is_object($this->type) ? get_class($this->type) : $this->type,
            null,
            array('validation_groups' => array_merge($this->validationGroups, $validationGroups))
        );
    }
}
