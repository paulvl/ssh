<?php


use PHPUnit\Framework\TestCase;

class SshTest extends TestCase
{
    public function testKeyGeneration()
    {
        $keys = generate_ssh_keys();
        $this->assertArrayHasKey('private', $keys);
        $this->assertArrayHasKey('public', $keys);
    }
}