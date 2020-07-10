<?php

namespace App\Console\Commands\Agent;

use Illuminate\Console\Command;
use Datasift\IfconfigParser\Parser\CentOS6;
use Datasift\IfconfigParser\Parser\Ubuntu;
use Datasift\IfconfigParser\Parser\Darwin;

class IpAddr extends Command
{

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'agent:ipaddr';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Upload local ip address, through yach im';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct() {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle() {
        $rows     = `ifconfig`;
        $u        = new Darwin;
        $data     = $u->parse($rows);
        $hostname = (string) gethostname();

        $msg = <<<MSG
       IP Info  [{$hostname}] 
---------------------------------------------

MSG;
        foreach ($data as $v) {
            $msg .= sprintf("%14s : %s \n", $v['interface'], $v['ip_address']);
        }
        yach_robot()->text($msg);
    }

}
