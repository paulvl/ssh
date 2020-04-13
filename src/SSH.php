<?php


namespace SSH;


use Exception;
use phpseclib\Crypt\RSA;
use phpseclib\Net\SSH2;
use SSH\Exceptions\InvalidConnectionAttemptException;
use ErrorException;

class SSH
{

    private $connected = false;
    private $ssh;
    private $rsa;
    private $host;
    private $username;

    /**
     * SSH constructor.
     * @param string $host
     * @param string $username
     * @param string $privateKey
     * @param int $port
     * @param string|null $password
     * @param int $timeout
     */
    public function __construct($host, $username, $privateKey, $port = 22, $password = null, $timeout = 10)
    {
        $this->host = $host;
        $this->username = $username;
        $this->rsa = new RSA();
        $this->rsa->setPassword($password);
        $this->rsa->loadKey($privateKey);
        $this->ssh = new SSH2($host, $port, $timeout);
    }

    /**
     * Get the hostname.
     *
     * @return string
     */
    public function getHost()
    {
        return $this->host;
    }

    /**
     * Get the username.
     *
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * Evaluates if the host can be connected with the given parameters.
     *
     * @return bool
     */
    public function canConnect()
    {
        try {
            $this->connect();
            $this->disconnect();
            return true;
        } catch (InvalidConnectionAttemptException $e) {
            return false;
        }
    }

    /**
     * Get te connection status
     *
     * @return bool
     */
    public function isConnected()
    {
        return $this->connected;
    }

    /**
     * Open connection to the host.
     *
     * @throws InvalidConnectionAttemptException
     */
    public function connect()
    {
        try {
            if ($this->ssh->login($this->username, $this->rsa)) {
                $this->connected = true;
            }
        } catch (ErrorException $e) {
            throw new InvalidConnectionAttemptException($this->host, $this->username);
        }
    }

    /**
     * Close the opened host connection.
     */
    public function disconnect()
    {
        if (!$this->connected) {
            $this->ssh->disconnect();
            $this->connected = false;
        }
    }

    /**
     * Executes commands on current connection and return a results collection
     * as array indicating and execution id, execution status, the console
     * output as result and the duration in milliseconds.
     *
     * @param array $commands
     * @return array
     * @throws \Exception
     */
    public function run(array $commands)
    {
        $results = [];
        if ($this->isConnected()) {
            foreach ($commands as $command) {
                $executionId = generate_uuid();
                $start = microtime_float();
                $result = $this->ssh->exec($command);
                $end = microtime_float();
                $status = $this->ssh->getExitStatus();
                array_push($results, [
                    'id' => $executionId,
                    'status' => $status == 0,
                    'result' => $result,
                    'duration' => number_format($end - $start, 3),
                ]);
            }
        }
        return $results;
    }
}
