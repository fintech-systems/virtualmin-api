<?php

namespace FintechSystems\VirtualminApi;

/**
 * An API that provides calls to Virtualmin.
 */
class VirtualminApi
{
    private $host;

    /**
     * Mode can be debug, write_cache or read_cache.
     */
    private $mode;

    /**
     * Wget won't produce output if this flag is set. For debugging, we clear it.
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

    /**
     * Format the raw output from the Virtualmin list-domains program into a more user-friendly format.
     */
    public function getDomains()
    {
        $output = json_decode($this->listDomains());

        foreach ($output->data as $domain) {
            $domains[] = [
                'name' => $domain->name,
                'plan' => $domain->values->plan[0],
                'disk_space_used' => $domain->values->server_byte_quota_used[0] ?? 0,
                'server' => $this->host['host'],
                'status' => (isset($domain->values->disabled) ? 'suspended' : 'active'),
            ];
        }

        return $domains;
    }

    /**
     * Run the Virtualmin list-domains command and return the output.
     */
    public function listDomains()
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
            $file = file_get_contents('storage/'.$program.'.json');

            return $file;
        }

        $result = shell_exec(
            $command
        );

        if ($this->mode == 'write_cache' && $result) {
            file_put_contents('storage/'.$program.'.json', $result);
        }

        return $result;
    }
}
