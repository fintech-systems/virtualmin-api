<?php

namespace FintechSystems\VirtualminApi;

class VirtualminApi
{
    private $host;
    private $debug;

    /**
     * By default Wget won't produce output because of this flag. For debugging, we clear it.
     */
    private $quiet = '--quiet';

    public function __construct($host = null, $debug = false)
    {
        $this->debug = $debug;

        if ($this->debug == true) {
            $this->quiet = '';
        }

        if ($host != null) {
            $this->host = $host;
        }
    }

    public function getDomains()
    {
        return $this->listDomains();
    }

    private function listDomains()
    {
        $program = 'list-domains';

        return $this->runProgram($program);
    }

    private function runProgram($program)
    {
        $host = $this->host['host'];
        $username = $this->host['username'] ?? 'root';
        $password = $this->host['password'];
        $port = $this->host['port'] ?? '10000';

        $command = "wget -O - $this->quiet --http-user='$username' --http-passwd='$password' --no-check-certificate 'https://$host:$port/virtual-server/remote.cgi?json=1&multiline&program=$program'";

        $result = shell_exec(
            $command
        );

        return json_decode($result);
    }
    
}
