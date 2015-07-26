<?php
/**
 * \file OTPGeneratorInterface.php
 * \author Pierre TRANCHARD <pierre@tranchard.net>
 * \version 1.0
 * \date 06/05/15
 * \brief Interface for One Time Password Generator classes
 * \details
 */

namespace Spark\FrameworkBundle\Component;

/**
 * Interface OTPGeneratorInterface
 *
 * @package Spark\FrameworkBundle\Component
 */
interface OTPGeneratorInterface
{
    /**
     * Generate OTP
     *
     * @return string
     */
    public function generateOTP();
}
