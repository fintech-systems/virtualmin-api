<?php

namespace FintechSystems\VirtualminApi;

class VirtualminApi
{
    private $host;

    /**
     * Mode can be debug or cache
     */
    private $mode;

    /**
     * By default Wget won't produce output because of this flag. For debugging, we clear it.
     */
    private $quiet = '--quiet';

    public function __construct($host = null, $mode = '')
    {
        $this->mode = $mode;

        if ($this->mode == 'debug') {
            $this->debug = true;
            $this->quiet = '';
        }

        if ($host != null) {
            $this->host = $host;
        }
    }

    public function getDomains()
    {
        return json_decode($this->listDomains());
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

        if ($this->mode == 'read_cache') {
            $file = file_get_contents('storage/' . $program . '.json');
            return $file;
        }

        $result = shell_exec(
            $command
        );

        if ($this->mode == 'write_cache') {
            file_put_contents('storage/' . $program . '.json', $result);
        }

        return $result;
    }
}
