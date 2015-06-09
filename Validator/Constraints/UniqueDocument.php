<?php
/**
 * \file UniqueDocument.php
 * \project 2spark-symfony2
 * \author Pierre TRANCHARD
 * \version 1.0
 * \date 03/06/15
 * \brief
 * \details
 */

namespace Spark\FrameworkBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

/**
 * Class UniqueDocument
 *
 * @package Spark\FrameworkBundle\Validator\Constraints
 *
 * @Annotation
 */
class UniqueDocument extends Constraint
{

    /**
     * @var string
     */
    public $alreadyUsed = "%value% is not available";
    /**
     * @var string
     */
    public $repositoryMethod = 'findBy';
    /**
     * @var array
     */
    public $fields = array();
    /**
     * @var null
     */
    public $errorPath = null;
    /**
     * @var string
     */
    public $dm = "default";

    /**
     * @return array
     */
    public function getRequiredOptions()
    {
        return array('fields');
    }

    /**
     * @return string
     */
    public function validatedBy()
    {
        return 'unique_document_validator';
    }

    /**
     * @return string
     */
    public function getTargets()
    {
        return self::CLASS_CONSTRAINT;
    }
}
