<?php
/**
 * \file UniqueDocumentValidator.php
 * \author Pierre TRANCHARD <pierre@tranchard.net>
 * \version 1.0
 * \date 03/06/15
 * \brief
 * \details
 */

namespace Spark\FrameworkBundle\Validator\Constraints;

use Doctrine\Bundle\MongoDBBundle\ManagerRegistry;
use Spark\FrameworkBundle\Exception\NotImplementedException;
use Symfony\Component\PropertyAccess\PropertyAccess;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

/**
 * Class UniqueDocumentValidator
 *
 * @package Spark\FrameworkBundle\Validator\Constraints
 */
class UniqueDocumentValidator extends ConstraintValidator
{

    /**
     * @var ManagerRegistry|null
     */
    protected $managerRegistry;

    /**
     * Constructor
     *
     * @param ManagerRegistry|null $managerRegistry
     */
    public function __construct(ManagerRegistry $managerRegistry = null)
    {
        $this->managerRegistry = $managerRegistry;
    }

    /**
     * Checks if the passed value is valid.
     *
     * @param mixed      $value      The value that should be validated
     * @param Constraint $constraint The constraint for the validation
     *
     * @throws \Exception
     * @api
     */
    public function validate($value, Constraint $constraint)
    {
        if (is_null($this->managerRegistry) === false) {
            /** @var UniqueDocument $constraint */

            $documentManager = $this->managerRegistry->getManager($constraint->dm);

            $repository = $documentManager->getRepository(get_class($value));
            $method     = $constraint->repositoryMethod;
            if (method_exists($repository, $method) === false) {
                throw NotImplementedException::repository($method, get_class($repository));
            }
            $fields   = $constraint->fields;
            $accessor = PropertyAccess::createPropertyAccessor();
            $fields   = array_flip($fields);
            foreach ($fields as $field => &$fieldValue) {
                $fieldValue = $accessor->getValue($value, $field);
            }

            $documents      = $repository->$method($fields);
            $errorPath      = $constraint->errorPath;
            $errorPathValue = $accessor->getValue($value, $errorPath);
            $nbOfDocuments = count($documents);
            if ($nbOfDocuments > 0 && ($value !== $documents[0])) {
                $this->buildViolation($constraint->alreadyUsed, array('%value%' => $errorPathValue))->atPath(
                    $errorPath
                )->addViolation();
            }
        } else {
            throw new \Exception('You have to construct the validator with a doctrine mongodb manager registry');
        }
    }
}
