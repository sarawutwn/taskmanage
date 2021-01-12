<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\PostJob;
use App\Models\PostJobReport;
use DB;

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
        $table = PostJob::orderBy('user_id', 'desc')->first();
        for($i=0; $i<=$table->user_id; $i++){
            $firsts = DB::table('post_jobs')->where('user_id', $i)->where('update_to_report', false)->orderBy('date', 'asc')->take(1)->get();
            $lasts = DB::table('post_jobs')->where('user_id', $i)->where('update_to_report', false)->orderBy('date', 'desc')->take(1)->get();

            foreach($firsts as $first){
                foreach($lasts as $last){
                $work_in = $first->date;
                $work_out = $last->date;
                PostJobReport::create([
                    'user_id' => $i,
                    'work_in' => $work_in,
                    'work_out' => $work_out
                ]);
                DB::table('post_jobs')->where('user_id', $i)->where('update_to_report', false)->update(['update_to_report' => true]);
                }
            }
        }
    }
}
