<?php

use phpseclib\Crypt\RSA;
use Ramsey\Uuid\Uuid;

if (!function_exists('generate_ssh_keys')) {
    /**
     * Generate an SSH key pair.
     *
     * @param string $comment
     * @param int $publicKeyFormat
     * @param int $privateKeyFormat
     * @param bool $password
     * @return array
     */
    function generate_ssh_keys($comment = 'user@localhost', $publicKeyFormat = RSA::PUBLIC_FORMAT_OPENSSH, $privateKeyFormat = RSA::PRIVATE_FORMAT_OPENSSH, $password = false)
    {
        $rsa = new RSA();
        $rsa->setComment($comment);
        $rsa->setPassword($password);
        $rsa->setPublicKeyFormat($publicKeyFormat);
        $rsa->setPrivateKeyFormat($privateKeyFormat);
        $keys = $rsa->createKey();
        return [
            'private' => $keys['privatekey'],
            'public' => $keys['privatekey']
        ];
    }
}

if (!function_exists('microtime_float')) {
    /**
     * Get the current microtime as float.
     *
     * @return float
     */
    function microtime_float()
    {
        list($usec, $sec) = explode(" ", microtime());
        return ((float)$usec + (float)$sec);
    }
}

if (!function_exists('generate_uuid')) {
    /**
     * Generates a version 4 UUID string.
     *
     * @return string
     * @throws Exception
     */
    function generate_uuid()
    {
        try {
            return (Uuid::uuid4())->toString();
        } catch (UnsatisfiedDependencyException $e) {
            return null;
        }
    }
}
