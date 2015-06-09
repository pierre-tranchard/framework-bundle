<?php
/**
 * \file Scrambler.php
 * \project 2spark-Library
 * \author Pierre TRANCHARD
 * \version 1.0
 * \date 08/01/15
 * \brief Library used to encrypt or decrypt a message
 * \details
 */

namespace Spark\FrameworkBundle\Component;

use Spark\FrameworkBundle\Traits\HexadecimalValidator;

/**
 * Class Scrambler
 *
 * @package Spark\FrameworkBundle\Component
 */
class Scrambler implements ScramblerInterface
{
    use HexadecimalValidator;

    /**
     * @var int
     */
    protected $key;

    /**
     * Constructor.
     *
     * @param string $key
     */
    public function __construct($key)
    {
        $this->key = $this->validateKey($key);
    }

    /**
     * Encrypt message.
     *
     * @param string $message
     *
     * @return string
     */
    public function encrypt($message)
    {
        $encrypt   = serialize($message);
        $iv        = mcrypt_create_iv(mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_CBC), MCRYPT_DEV_URANDOM);
        $key       = pack('H*', $this->key);
        $mac       = hash_hmac('sha256', $encrypt, substr($this->key, -32));
        $passCrypt = mcrypt_encrypt(MCRYPT_RIJNDAEL_256, $key, $encrypt . $mac, MCRYPT_MODE_CBC, $iv);
        $encoded   = base64_encode($passCrypt) . '|' . base64_encode($iv);

        return $encoded;
    }

    /**
     * Decrypt message.
     *
     * @param string $encryptedMessage
     *
     * @return bool|string
     */
    public function decrypt($encryptedMessage)
    {
        $decrypt = explode('|', $encryptedMessage . '|');
        $decoded = base64_decode($decrypt[0]);
        $iv      = base64_decode($decrypt[1]);
        if (strlen($iv) !== mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_CBC)) {
            return false;
        }
        $key       = pack('H*', $this->key);
        $decrypted = trim(mcrypt_decrypt(MCRYPT_RIJNDAEL_256, $key, $decoded, MCRYPT_MODE_CBC, $iv));
        $mac       = substr($decrypted, -64);
        $decrypted = substr($decrypted, 0, -64);
        $calcMac   = hash_hmac('sha256', $decrypted, substr($this->key, -32));
        if ($calcMac !== $mac) {
            return false;
        }
        $decrypted = unserialize($decrypted);

        return $decrypted;
    }
}
