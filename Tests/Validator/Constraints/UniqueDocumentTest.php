<?php
/**
 * \file UniqueDocumentTest.php
 * \author Pierre TRANCHARD <pierre@tranchard.net>
 * \version 1.0
 * \date 02/07/15
 * \brief
 * \details
 */

namespace Spark\FrameworkBundle\Tests\Validator\Constraints;

use Spark\FrameworkBundle\Validator\Constraints\UniqueDocument;

/**
 * Class UniqueDocumentTest
 *
 * @package Spark\FrameworkBundle\Tests\Validator\Constraints
 */
class UniqueDocumentTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Test properties
     */
    public function testProperties()
    {
        $constraint = new UniqueDocument(array('fields' => array('id')));
        $this->assertEquals("%value% is not available", $constraint->alreadyUsed);
        $this->assertEquals("default", $constraint->dm);
        $this->assertEquals(null, $constraint->errorPath);
        $this->assertEquals(array('id'), $constraint->fields);
        $this->assertEquals('findBy', $constraint->repositoryMethod);
        $this->assertEquals(UniqueDocument::CLASS_CONSTRAINT, $constraint->getTargets());
        $this->assertEquals('unique_document_validator', $constraint->validatedBy());
    }
}
