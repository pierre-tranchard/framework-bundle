<?php
/**
 * \file FormFactory.php
 * \author Pierre TRANCHARD <pierre@tranchard.net>
 * \version 1.0
 * \date 26/05/15
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
    public function __construct(FormFactoryInterface $formFactory, $name, $type, array $validationGroups = null)
    {
        $this->formFactory      = $formFactory;
        $this->name             = $name;
        $this->type             = $type;
        $this->validationGroups = $validationGroups;
    }

    /**
     * Create form
     *
     * @return FormInterface
     */
    public function createForm()
    {
        return $this->formFactory->createNamed(
            $this->name,
            $this->type,
            null,
            array('validation_groups' => $this->validationGroups)
        );
    }
}
