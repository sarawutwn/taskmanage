<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\PostJob;
use App\Models\PostJobReport;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

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
        $users = User::get();
        foreach($users as $user){
            $querys = PostJob::where('user_id', $user->id)->where('update_to_report', false)->get();
            $dateTime = $querys->pluck('date');
            $work_in_time = strtotime($dateTime->first());
            $work_out_time = strtotime($dateTime->last());
            if(empty($work_in_time) || empty($work_out_time)){
                $date = Carbon::now();
                $work_in = null;
                $work_out = null;
            }else {
                $date = date('Y-m-d', $work_in_time);
                $work_in = date('Y-m-d H:i:s',$work_in_time);
                $work_out = date('Y-m-d H:i:s',$work_out_time);
            }
            PostJobReport::create([
                "user_id" => $user->id,
                "date" => $date,
                "work_in" => $work_in,
                "work_out" => $work_out,
            ]);
            DB::table('post_jobs')->where('user_id', $user->id)->where('update_to_report', false)->update(['update_to_report' => true]);
        }
    }
}
