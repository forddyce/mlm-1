<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Member;
use App\Models\Bonus;
use Carbon\Carbon;

class RoiCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'roi';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Make ROI Daily';

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
     * @return mixed
     */
    public function handle()
    {
        $today = Carbon::now();
        Member::where('is_active', 1)->where('next_roi', '<=', $today)->chunk(100, function ($members) {
            foreach ($members as $member) {
                if ($member->current_roi < $member->max_profit) {
                    $amount = ($member->roi/100) * $member->package_amount;
                    $check = $member->current_roi + $amount;
                    if ($check > $member->max_profit) {
                        $amount = $check - $member->max_profit;
                        $member->is_active = 0;
                    }
                    $member->current_roi += $amount;
                    $member->roi_wallet += $amount;
                    $member->next_roi = Carbon::today()->addDays(7);
                    $member->save();

                    $bonus = new Bonus;
                    $bonus->member_id = $member->id;
                    $bonus->amount = $amount;
                    $bonus->type = 'roi';
                    $bonus->save();
                }
            }
        });
    }
}
