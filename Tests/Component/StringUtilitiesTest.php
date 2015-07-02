<?php
/**
 * \file StringUtilitiesTest.php
 * \project 2spark-Library
 * \author Pierre TRANCHARD
 * \version 1.0
 * \date 16/04/15
 * \brief
 * \details
 */

namespace Spark\FrameworkBundle\Tests\Component;

use Spark\FrameworkBundle\Component\StringUtilities;

/**
 * Class StringUtilitiesTest
 *
 * @package Spark\FrameworkBundle\Tests\Component
 */
class StringUtilitiesTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Test replace spaces by
     */
    public function testReplaceSpacesBy()
    {
        $initialString = "Hello World !";

        $this->assertEquals("Hello-World-!", StringUtilities::replaceSpacesBy($initialString, "-"));
        $this->assertEquals("HelloWorld!", StringUtilities::replaceSpacesBy("HelloWorld!", "-"));
    }

    /**
     * Test remove file extension from string
     */
    public function testRemoveFileExtension()
    {
        $fileName = "hello.txt";
        $this->assertEquals("hello", StringUtilities::removeFileExtension($fileName));

        $fileName = "hello.tarz";
        $this->assertEquals("hello", StringUtilities::removeFileExtension($fileName));

        $fileName = "hello.txt.test";
        $this->assertEquals("hello.txt", StringUtilities::removeFileExtension($fileName));
    }

    /**
     * Test slugifyer
     */
    public function testSlugify()
    {
        $this->assertEquals("hello-guys", StringUtilities::slugify("hello guys"));
        $this->assertEquals("hello-guys", StringUtilities::slugify("Hello Guys"));
        $this->assertEquals(null, StringUtilities::slugify(""));
    }
}
