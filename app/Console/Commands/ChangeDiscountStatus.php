<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Offer;
use Illuminate\Support\Carbon;

class ChangeDiscountStatus extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'change-discount-status';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $offers = Offer::where('is_active' , true)->where('end_date', '<', Carbon::now())->get();

        foreach($offers as $offer)
        {
            $offer->is_active = false;
            $offer->save();
        }
    }
}
