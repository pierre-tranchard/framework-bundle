<?php
/**
 * \file MemoryTest.php
 * \author Pierre TRANCHARD <pierre@tranchard.net>
 * \version 1.0
 * \date 16/04/15
 * \brief
 * \details
 */

namespace Spark\FrameworkBundle\Tests\Component;

use Spark\FrameworkBundle\Component\Memory;

/**
 * Class MemoryTest
 *
 * @package Spark\FrameworkBundle\Tests\Component
 */
class MemoryTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Test Memory Usage
     */
    public function testMemoryUsage()
    {
        $this->assertNotEmpty(Memory::memoryUsage());
        $this->assertContains("B", Memory::memoryUsage());
    }

    /**
     * Test Memory Peak
     */
    public function testMemoryPeak()
    {
        $this->assertNotEmpty(Memory::memoryPeak());
        $this->assertContains("B", Memory::memoryPeak());
    }
}
