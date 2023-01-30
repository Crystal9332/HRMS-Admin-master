<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Contracts\Encryption\DecryptException;

use Mail;
use Carbon\Carbon;

use App\Models\Schedule;
use App\Mail\SendMail;

class SendEmail extends Command
{
	/**
	 * The name and signature of the console command.
	 *
	 * @var string
	 */
	protected $signature = 'auto:sendmail';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Send email by schedule';

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
		foreach(Schedule::all() as $schedule) {
			$interval = 5;
			$now = Carbon::now()->second(0);
			$start_time = $now->toTimeString();
			$end_time = $now->addMinutes($interval)->toTimeString();
			
			if ($schedule->start_time >= $start_time && $schedule->start_time < $end_time) {
				$this->sendCodeViaEmail($schedule);
			}
		}

		$this->info('auto:sendmail Cummand Run successfully!');
	}
	
  function sendCodeViaEmail($schedule)
  {
    $data = [
        'title' => 'QrCode for the attend - schedule',
        'body' => 'This is for testing',
				'code' => $this->getCode($schedule),
				'sent_time' => Carbon::now()
        ];
    Mail::to($schedule->site->email)->send(new SendMail($data));
  }

  function getCode($schedule){
		$arr = array(
			'type' => 'schedules',
			'id' => Crypt::encryptString($schedule['id']),
			'site_id' => $schedule->site->name.'_'.$schedule->site_id,
			'site' => $schedule->site->name,
			'date' => date('Y-m-d'),
			'start' => date('Y-m-d').' '.$schedule->start_time
		);
		
		if(isset($schedule->end_time)) {
			$arr['end'] = $schedule->end_time;
		}
		
		\Log::info('schedule::'.json_encode($arr));
    $code = \QrCode::format('png')->size(250)->margin(3)->generate(json_encode($arr));
    return  'data:image/png;base64,' . base64_encode($code);
  }
}
