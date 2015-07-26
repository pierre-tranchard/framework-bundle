<?php
/**
 * \file IpToolsTest.php
 * \author Pierre TRANCHARD <pierre@tranchard.net>
 * \version 1.0
 * \date 12/05/15
 * \brief
 * \details
 */

namespace Spark\FrameworkBundle\Tests\Component;

use Spark\FrameworkBundle\Component\IpTools;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;

/**
 * Class IpToolsTest
 *
 * @package Spark\FrameworkBundle\Tests\Component
 */
class IpToolsTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var array
     */
    private $ports = array();

    /**
     * Set Up tests
     */
    public function setUp()
    {
        $this->ports = array(
            80,
            88,
            443,
            553,
            554,
            808,
            1080,
            3124,
            3127,
            3128,
            3246,
            6588,
            8000,
            8080,
            8085,
            8088,
            8118,
            9188,
            36673
        );
    }

    /**
     * Test detect real ip
     */
    public function testDetectRealIp()
    {
        $realIp = "127.0.0.1";

        $requestStack = new RequestStack();
        $ipTools = new IpTools($requestStack, $this->ports);
        $this->assertNull($ipTools->detectRealIP());

        $request = new Request();
        $request->server->add(array('REMOTE_ADDR' => $realIp));
        $requestStack->push($request);
        $this->assertEquals($realIp, $ipTools->detectRealIP());

        $requestStack->pop();
        $request = new Request();
        $request->server->add(array('HTTP_CLIENT_IP' => $realIp));
        $requestStack->push($request);
        $this->assertEquals($realIp, $ipTools->detectRealIP());

        $requestStack->pop();
        $request = new Request();
        $request->server->add(array('HTTP_X_FORWARDED_FOR' => $realIp));
        $requestStack->push($request);
        $this->assertEquals($realIp, $ipTools->detectRealIP());
    }

    /**
     * Tear Down tests
     */
    public function tearDown()
    {
        $this->ports = array();
    }
}
