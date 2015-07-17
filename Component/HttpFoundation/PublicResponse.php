<?php
/**
 * \file PublicResponse.php
 * \project Spark
 * \author Pierre TRANCHARD
 * \version 1.0
 * \date 17/07/15
 * \brief
 * \details
 */

namespace Spark\FrameworkBundle\Component\HttpFoundation;

use Symfony\Component\HttpFoundation\Response;

/**
 * Class PublicResponse
 *
 * @package Spark\FrameworkBundle\Component\HttpFoundation
 */
class PublicResponse extends Response
{

    /**
     * Constructor
     *
     * @param string $content
     * @param int    $status
     * @param array  $headers
     * @param int    $maxAge
     * @param int    $sharedMaxAge
     */
    public function __construct($content = '', $status = 200, $headers = array(), $maxAge = 60, $sharedMaxAge = 60)
    {
        parent::__construct($content, $status, $headers);
        $this->setPublic();
        $this->setMaxAge($maxAge);
        $this->setSharedMaxAge($sharedMaxAge);
    }
}
