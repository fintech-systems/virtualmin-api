<?php

namespace FintechSystems\VirtualminApi;

/**
 * An API that provides calls to Virtualmin.
 */
class VirtualminApi
{
    private $server;

    /**
     * Mode can be debug, write_cache or read_cache.
     */
    private $mode;

    /**
     * Wget won't produce output if this flag is set so for debugging, we clear it.
     */
    private string $quiet = '--quiet';

    private bool $debug;

    public function __construct($server = null, $mode = '')
    {
        $this->mode = $mode;

        if ($this->mode == 'debug') {
            $this->debug = true;
            $this->quiet = '';
        }

        if ($server != null) {
            $this->server = $server;
        }
    }

    /**
     * Format the raw output from the Virtualmin list-domains program into a more user-friendly format.
     */
    public function getDomains(): array
    {
        $domains = [];

        $output = json_decode($this->listDomains());

        foreach ($output->data as $domain) {
            $domains[] = [
                'server'           => $this->server['hostname'],
                'name'             => $domain->name,
                'type'             => $this->getHostingType($domain),                                
                'username'         => $domain->values->username[0] ?? '',
                'password'         => $domain->values->password[0] ?? '',
                'plan'             => $domain->values->plan[0],
                'disk_space_used'  => $domain->values->server_byte_quota_used[0] ?? 0,
                'disk_space_limit' => $this->getDiskSpaceLimit($domain),
                'bandwidth_used'   => $domain->values->bandwidth_byte_usage[0] ?? 0,
                'bandwidth_limit'   => $this->getBandwidthLimit($domain),
                'status'           => (isset($domain->values->disabled) ? 'suspended' : 'active'),
            ];
        }

        return $domains;
    }

    /**
     * Format the raw output from the Virtualmin list-plans program into a more user-friendly format.
     */
    public function getPlans(): array
    {
        $plans = [];

        $output = json_decode($this->listPlans());

        foreach ($output->data as $plan) {
            $plans[] = [
                'server'            => $this->server['hostname'],
                'remote_id'         => $plan->name,
                'name'              => $plan->values->name[0],
                'disk_space_limit'  => $plan->values->server_block_quota[0],
                'bandwidth_limited' => $plan->values->maximum_bw[0],
            ];
        }

        return $plans;
    }

    /**
     * Run the Virtualmin list-domains command and return the output.
     */
    public function listDomains()
    {
        $program = 'list-domains';

        return $this->runProgram($program);
    }

    /**
     * Run the Virtualmin list-domains command and return the output.
     */
    public function listPlans()
    {
        $program = 'list-plans';

        return $this->runProgram($program);
    }

    private function getBandwidthLimit($domain)
    {
        if (isset($domain->values->bandwidth_byte_limit)) {

            if ($domain->values->bandwidth_byte_limit[0] == 'Unlimited') {
                return -1;
            }

            return $domain->values->bandwidth_byte_limit[0];
        }
        return null;
    }

    private function getDiskSpaceLimit($domain)
    {
        if (isset($domain->values->server_block_quota)) {

            if ($domain->values->server_block_quota[0] == 'Unlimited') {
                return -1;
            }

            return $domain->values->server_block_quota[0];
        }
        return null;
    }

    /*
    * Hosting can be either top level hosting or a subdomain of a top level server
    */
    private function getHostingType($domain): ?string
    {
        if (isset($domain->values->type)) { // TODO PHP 8.0 provides shortcut for this
            if ($domain->values->type[0] == "Top-level server") {
                return "Web Hosting";
            }
            if ($domain->values->type[0] == "Sub-server") {
                return "Subdomain";
            }
        }
        return null;
    }

    private function runProgram($program)
    {
        $hostname = $this->server['hostname'];
        $username = $this->server['username'] ?? 'root';
        $password = $this->server['password'];
        $port     = $this->server['port'] ?? '10000';

        ray('runProgram server', $this->server);

        // `-O -` means documents will be printed to standard output. See man wget /-O
        $command = "wget --timeout=1800 -O - $this->quiet --http-user='$username' --http-passwd='$password' --no-check-certificate 'https://$hostname:$port/virtual-server/remote.cgi?json=1&multiline&program=$program'";

        if ($this->mode == 'read_cache') {
            return file_get_contents('storage/' . $program . '.json');
        }

        ray()->measure();
        $result = shell_exec(
            $command
        );
        ray()->measure();

        if ($this->mode == 'write_cache' && $result) {
            file_put_contents('storage/' . $program . '.json', $result);
        }

        return $result;
    }
}
