<?php
/**
 * \file ScramblerInterface.php
 * \author Pierre TRANCHARD <pierre@tranchard.net>
 * \version 1.0
 * \date 08/01/15
 * \brief Interface to be implemented for creating a scrambler
 * \details
 */

namespace Spark\FrameworkBundle\Component;

/**
 * Interface ScramblerInterface
 *
 * @package Spark\FrameworkBundle\Component
 */
interface ScramblerInterface
{
    /**
     * Encrypt message.
     *
     * @param $message
     *
     * @return string
     */
    public function encrypt($message);

    /**
     * Decrypt message.
     *
     * @param $encryptedMessage
     *
     * @return bool|string
     */
    public function decrypt($encryptedMessage);
}