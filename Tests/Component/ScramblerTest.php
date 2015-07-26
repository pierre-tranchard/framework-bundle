<?php
/**
 * \file ScramblerTest.php
 * \author Pierre TRANCHARD <pierre@tranchard.net>
 * \version 1.0
 * \date 16/04/15
 * \brief
 * \details
 */

namespace Spark\FrameworkBundle\Tests\Component;

use Spark\FrameworkBundle\Component\Scrambler;

/**
 * Class ScramblerTest
 *
 * @package Spark\FrameworkBundle\Tests\Component
 */
class ScramblerTest extends \PHPUnit_Framework_TestCase
{
    const MESSAGE = "Hello World";
    const RANDOM_KEY = "F6104FC49DA58D67176FE314794B035C1D3C63242AD8A02F7887B06DFBC46BF9";
    const INVALID_KEY = "F6104";

    /**
     * Test message encryption
     */
    public function testEncrypt()
    {
        $scrambler        = new Scrambler(static::RANDOM_KEY);
        $encryptedContent = $scrambler->encrypt(static::MESSAGE);

        $this->assertNotEmpty($encryptedContent);
        $this->assertNotEquals(static::MESSAGE, $encryptedContent);
    }

    /**
     * Test message decryption
     */
    public function testDecrypt()
    {
        $scrambler        = new Scrambler(static::RANDOM_KEY);
        $encryptedContent = "1PH32nS7WsXEBkc/YoJqMKgLVymnSrbIbR/AV6ibNL/gEtYpsuxtxI9dKDL+2UJh3TA61DlkXAj+XYOFSE9sU+txumP8faKenw6caoQXqnZxLSXgjpsi45/2GObvyHR0|NnYtzGF8M1kCvhR2Jmo3mMdqprGw2trJRQN3AP5dIEU=";
        $decryptedContent = $scrambler->decrypt($encryptedContent);

        $this->assertNotEmpty($decryptedContent);
        $this->assertEquals(static::MESSAGE, $decryptedContent);
    }

    /**
     * Test message decryption with failure
     */
    public function testDecryptWithFailure()
    {
        $scrambler        = new Scrambler(static::RANDOM_KEY);
        $encryptedContent = "1PH32nS7WsXEBkc/YoJqMKgLVymnSrbIbR/AV6ibNL/gEtYpsuxtxI9dKDL+2UJh3TA61DlkXAj+XYOFSE9sU+txumP8faKenw6caoQXqnZxLSXgjpsi45/2GObvyHR0|NnYtzGF8M1kCvhR2Jmo3mMdqprGw2trJRQN3AP5dIEU=";

        $reflection = new \ReflectionClass($scrambler);
        $keyProperty = $reflection->getProperty('key');
        $keyProperty->setAccessible(true);
        $keyProperty->setValue($scrambler, static::INVALID_KEY);

        $this->assertFalse($scrambler->decrypt($encryptedContent));
        $scrambler = null;

        $scrambler        = new Scrambler(static::RANDOM_KEY);
        $encryptedContent = "1PH32nS7WsXHR0|NnYtzGF8M1kCvhR2QN3AP5dIEU=";
        $this->assertFalse($scrambler->decrypt($encryptedContent));
    }

    /**
     * Test scrambler construction with an invalid key
     */
    public function testConstructionWithInvalidKey()
    {
        try {
            new Scrambler(static::INVALID_KEY);
        } catch (\Exception $exception) {
            $this->throwException($exception);
        }
    }
}
