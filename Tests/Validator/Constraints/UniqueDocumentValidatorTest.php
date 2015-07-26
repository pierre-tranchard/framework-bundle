<?php
/**
 * \file UniqueDocumentValidatorTest.php
 * \author Pierre TRANCHARD <pierre@tranchard.net>
 * \version 1.0
 * \date 02/07/15
 * \brief
 * \details
 */

namespace Spark\FrameworkBundle\Tests\Validator\Constraints;

use Spark\FrameworkBundle\Validator\Constraints\UniqueDocument;
use Spark\FrameworkBundle\Validator\Constraints\UniqueDocumentValidator;

/**
 * Class UniqueDocumentValidatorTest
 *
 * @package Spark\FrameworkBundle\Tests\Validator\Constraints
 */
class UniqueDocumentValidatorTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Test validate with null registry
     */
    public function testValidateWithNullRegistry()
    {
        $validator  = new UniqueDocumentValidator(null);
        $reflection = new \ReflectionClass($validator);
        $registry   = $reflection->getProperty('managerRegistry');
        $registry->setAccessible(true);
        $this->assertEquals(null, $registry->getValue($validator));

        try {
            $validator->validate(array('name' => 'document 1'), new UniqueDocument(array('fields' => array('name'))));
        } catch (\Exception $exception) {
            $this->throwException($exception);
            $this->assertEquals(
                'You have to construct the validator with a doctrine mongodb manager registry',
                $exception->getMessage()
            );
        }
    }

    /**
     * Test validate with a mock of mongodb registry
     *
     * @TODO Make test pass
     */
    public function testValidate()
    {
//        $constraint     = new UniqueDocument(
//            array('fields' => array('[name]'), 'errorPath' => '[name]', 'repositoryMethod' => 'findBy')
//        );
//        $repositoryMock = $this->getMock('\Doctrine\ODM\MongoDB\DocumentRepository', array(), array(), '', false);
//        $repositoryMock->expects($this->any())
//            ->method($constraint->repositoryMethod)
//            ->withAnyParameters()
//            ->willReturn(array(array('name' => 'document 1')));
//        $documentManagerMock = $this->getMock('\Doctrine\ODM\MongoDB\DocumentManager', array(), array(), '', false);
//        $documentManagerMock->expects($this->any())
//            ->method('getRepository')
//            ->withAnyParameters()
//            ->willReturn($repositoryMock);
//        $registryMock = $this->getMock(
//            '\Doctrine\Bundle\MongoDBBundle\ManagerRegistry',
//            array(),
//            array(),
//            '',
//            false
//        );
//        $registryMock->expects($this->any())
//            ->method('getManager')
//            ->withAnyParameters()
//            ->willReturn($documentManagerMock);
//
//        $validator = new UniqueDocumentValidator($registryMock);
//        $validator->validate(array('name' => 'document 1'), $constraint);
    }
}
