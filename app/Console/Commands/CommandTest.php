<?php

namespace App\Console\Commands;

use App\Jobs\MailReleaseOccupy;
use App\Jobs\MailReportSentBatch;
use App\Models\MailScheduleDetail;
use Illuminate\Console\Command;

class CommandTest extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:test';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command test';

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
        MailReleaseOccupy::dispatch('liux156', MailReleaseOccupy::setQueueData('liux156', ['fsdsfsdf@qq.com']));
        // MailReportSentBatch::dispatch(3713, MailReportSentBatch::setQueueData(3713, ['vision83498485@hotmail.com']));
        //
        // $lastId = 0;
        // for ($i = 0; ; $i++) {
        //     $list = MailScheduleDetail::query()->where('id', '>', $lastId)->where('schedule_status', 2)->whereBetween('created_at', [
        //         date('Y-m-d 00:00:00', strtotime('-1 day')),
        //         date('Y-m-d H:i:s'),
        //     ])->limit(1000)->get();
        //
        //     foreach ($list as $model) {
        //         /* @var MailScheduleDetail $model */
        //         $model->nextJob();
        //         $lastId = $model->id;
        //     }
        // }
        return 0;
    }
}
