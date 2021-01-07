<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class JobReportDaily extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'jobreport:daily';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This command is report table post-job(work-in,work-out) everyday.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        error_log("test cronjob is successfully.");
    }
}
