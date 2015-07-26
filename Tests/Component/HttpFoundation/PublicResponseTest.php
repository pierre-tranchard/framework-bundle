<?php
/**
 * \file PublicResponseTest.php
 * \author Pierre TRANCHARD <pierre@tranchard.net>
 * \version 1.0
 * \date 17/07/15
 * \brief
 * \details
 */

namespace Spark\FrameworkBundle\Tests\Component\HttpFoundation;

use Spark\FrameworkBundle\Component\HttpFoundation\PublicResponse;

/**
 * Class PublicResponseTest
 *
 * @package Spark\FrameworkBundle\Tests\Component\HttpFoundation
 */
class PublicResponseTest extends \PHPUnit_Framework_TestCase
{

    /**
     * Test cache control headers
     */
    public function testCacheControlHeaders()
    {
        $response = new PublicResponse();
        $this->assertArrayHasKey('cache-control', $response->headers->all());
        $this->assertEquals('max-age=60, public, s-maxage=60', $response->headers->get('cache-control'));
    }

    /**
     * Test if response is cacheable
     */
    public function testIsCacheable()
    {
        $response = new PublicResponse();
        $this->assertTrue($response->isCacheable());
    }

    /**
     * Test if response must be revalidated
     */
    public function testMustRevalidate()
    {
        $response = new PublicResponse();
        $this->assertFalse($response->mustRevalidate());
    }

    /**
     * Test if response is successful
     */
    public function testIsSuccessful()
    {
        $response = new PublicResponse();
        $this->assertTrue($response->isSuccessful());
    }
}
