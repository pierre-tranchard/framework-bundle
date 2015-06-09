<?php
/**
 * \file OTPGenerator.php
 * \project 2spark-Library
 * \author Pierre TRANCHARD
 * \version 1.0
 * \date 06/05/15
 * \brief One Time Password Generator class
 * \details RFC 6238 compliant
 */

namespace Spark\FrameworkBundle\Component;

use Spark\FrameworkBundle\Traits\HexadecimalValidator;

/**
 * Class OTPGenerator
 *
 * @package Spark\FrameworkBundle\Component
 */
class OTPGenerator implements OTPGeneratorInterface
{
    use HexadecimalValidator;

    /**
     * @var string
     */
    protected $secretSeed;

    /**
     * @var int
     */
    protected $timeWindow;

    /**
     * @var string
     */
    protected $algorithm;

    /**
     * Constructor
     *
     * @param string $secretSeed
     * @param int    $timeWindow
     * @param string $algorithm
     */
    public function __construct($secretSeed, $timeWindow = 60, $algorithm = "sha512")
    {
        $this->secretSeed = $this->validateKey($secretSeed);
        $this->timeWindow = $timeWindow;
        $this->algorithm  = $algorithm;
    }

    /**
     * Generate OTP
     *
     * @return string
     */
    public function generateOTP()
    {
        $currentTime = microtime(true);
        $roundedTime = floor($currentTime / $this->timeWindow);
        $packedTime  = pack("N", $roundedTime);

        $paddedPackedTime = str_pad($packedTime, 8, chr(0), STR_PAD_LEFT);
        $packedSecretSeed = pack("H*", $this->secretSeed);

        $hash = hash_hmac($this->algorithm, $paddedPackedTime, $packedSecretSeed, true);

        $offset = ord($hash[19]) & 0xf;
        $otp    = (
                ((ord($hash[$offset + 0]) & 0x7f) << 24) |
                ((ord($hash[$offset + 1]) & 0xff) << 16) |
                ((ord($hash[$offset + 2]) & 0xff) << 8) |
                (ord($hash[$offset + 3]) & 0xff)
            ) % pow(10, 6);
        $otp    = str_pad($otp, 6, "0", STR_PAD_LEFT);

        return $otp;
    }
}
