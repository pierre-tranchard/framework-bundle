<?php
/**
 * \file HexadecimalValidator.php
 * \author Pierre TRANCHARD <pierre@tranchard.net>
 * \version 1.0
 * \date 06/05/15
 * \brief
 * \details
 */

namespace Spark\FrameworkBundle\Traits;

/**
 * Class HexadecimalValidator
 *
 * @package Spark\FrameworkBundle\Traits
 */
trait HexadecimalValidator
{
    /**
     * Validate the encryption key.
     *
     * @param $key
     *
     * @return int
     * @throws \Exception
     */
    protected function validateKey($key)
    {
        if (ctype_xdigit($key) === false || strlen($key) !== 64) {
            throw new \Exception('Invalid key. Key must be a 32-byte (64 character) hexadecimal string.');
        }

        return $key;
    }
}