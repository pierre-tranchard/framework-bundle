<?php
/**
 * \file IpTools.php
 * \author Pierre TRANCHARD <pierre@tranchard.net>
 * \version 1.0
 * \date 11/05/15
 * \brief Class designed to provide real IP address and detect whether the user is behind a onion router or a proxy
 * \details
 */

namespace Spark\FrameworkBundle\Component;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;

/**
 * Class IpTools
 *
 * @package Spark\FrameworkBundle\Component
 */
class IpTools
{
    /**
     * @var RequestStack
     */
    protected $requestStack;

    /**
     * @var array
     */
    protected $ports;

    /**
     * Constructor.
     *
     * @param RequestStack $requestStack
     * @param array        $ports
     */
    public function __construct(RequestStack $requestStack, $ports = array())
    {
        $this->requestStack = $requestStack;
        $this->ports        = $ports;
    }

    /**
     * Detect whether a client is behind a proxy or TOR
     *
     * @return bool
     *
     * @codeCoverageIgnore
     */
    public function isBehindProxyOrTor()
    {
        if ($this->isBehindProxy() || $this->isBehindTor()) {
            return true;
        }

        return false;
    }

    /**
     * Detect if the current request is behind a proxy
     *
     * @return bool
     *
     * @codeCoverageIgnore
     */
    public function isBehindProxy()
    {
        $currentRequest = $this->getCurrentRequest();
        if (is_null($currentRequest) === false) {
            $server        = $currentRequest->server;
            $parametersBag = $server->all();

            $hasHttpAcceptEncoding  = isset($parametersBag['HTTP_ACCEPT_ENCODING']);
            $hasHttpXForwardedFor   = isset($parametersBag['HTTP_X_FORWARDED_FOR']);
            $hasHttpXForwarded      = isset($parametersBag['HTTP_X_FORWARDED']);
            $hasHttpForwardedFor    = isset($parametersBag['HTTP_FORWARDED_FOR']);
            $hasHttpVia             = isset($parametersBag['HTTP_VIA']);
            $hasHttpForwarded       = isset($parametersBag['HTTP_FORWARDED']);
            $hasHttpClientIp        = isset($parametersBag['HTTP_CLIENT_IP']);
            $hasHttpForwardedForIp  = isset($parametersBag['HTTP_FORWARDED_FOR_IP']);
            $hasVia                 = isset($parametersBag['VIA']);
            $hasXForwardedFor       = isset($parametersBag['X_FORWARDED_FOR']);
            $hasForwardedFor        = isset($parametersBag['FORWARDED_FOR']);
            $hasXForwardedForwarded = isset($parametersBag['X_FORWARDED FORWARDED']);
            $hasClientIp            = isset($parametersBag['CLIENT_IP']);
            $hasForwardedForIp      = isset($parametersBag['FORWARDED_FOR_IP']);
            $hasHttpProxyConnection = isset($parametersBag['HTTP_PROXY_CONNECTION']);
            $isUsingSensitivePort   = in_array($parametersBag['REMOTE_PORT'], $this->ports);
            $hasHttpConnection      = isset($parametersBag['HTTP_CONNECTION']);

            if (
                gethostbyaddr($parametersBag['REMOTE_ADDR']) === false
                || gethostbyaddr($parametersBag['REMOTE_ADDR']) == "."
                || $hasHttpAcceptEncoding === false || $hasHttpXForwardedFor || $hasHttpXForwarded || $hasHttpForwardedFor
                || $hasHttpVia || $hasHttpForwarded || $hasHttpClientIp || $hasHttpForwardedForIp || $hasVia
                || $hasXForwardedFor || $hasForwardedFor || $hasXForwardedForwarded || $hasClientIp || $hasForwardedForIp
                || $hasHttpProxyConnection || $isUsingSensitivePort || !$hasHttpConnection
            ) {
                return true;
            }

            foreach ($this->ports as $port) {
                if (@fsockopen($currentRequest->getClientIp(), $port, $errNo, $errStr, 0)) {
                    return true;
                }
            }
        }

        return false;
    }

    /**
     * Detect whether a client is behind a TOR exit node
     *
     * @return bool
     *
     * @codeCoverageIgnore
     */
    public function isBehindTor()
    {
        $currentRequest = $this->getCurrentRequest();
        if (is_null($currentRequest) === false) {
            $server        = $currentRequest->server;
            $parametersBag = $server->all();

            if (gethostbyname(
                    $this->reverseIpBytes(
                        $parametersBag['REMOTE_ADDR']
                    ) . "." . $parametersBag['SERVER_PORT'] . "." . $this->reverseIpBytes(
                        $parametersBag['SERVER_ADDR']
                    ) . ".ip-port.exitlist.torproject.org"
                ) == "127.0.0.2"
            ) {
                return true;
            }
        }

        return false;
    }

    /**
     * Return the Client IP
     *
     * @return string|null
     */
    public function detectRealIP()
    {
        $currentRequest = $this->getCurrentRequest();
        if (is_null($currentRequest) === false) {
            $server        = $currentRequest->server;
            $parametersBag = $server->all();

            if (empty($parametersBag["HTTP_CLIENT_IP"]) === false) {
                $ip = $parametersBag["HTTP_CLIENT_IP"];
            } elseif (empty($parametersBag["HTTP_X_FORWARDED_FOR"]) === false) {
                $ip = $parametersBag["HTTP_X_FORWARDED_FOR"];
            } else {
                $ip = $parametersBag["REMOTE_ADDR"];
            }

            return $ip;
        }

        return null;
    }

    /**
     * Get the current request from the request stack
     *
     * @return null|Request
     */
    protected function getCurrentRequest()
    {
        return $this->requestStack->getCurrentRequest();
    }

    /**
     * Return the reverse IP bytes
     *
     * @param $ip
     *
     * @return String
     *
     * @codeCoverageIgnore
     */
    protected function reverseIpBytes($ip)
    {
        $bytes = explode(".", $ip);

        return $bytes[3] . "." . $bytes[2] . "." . $bytes[1] . "." . $bytes[0];
    }
}
