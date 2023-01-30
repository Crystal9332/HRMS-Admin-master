<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Contracts\Encryption\DecryptException;

use Carbon\Carbon;

use App\Models\User;
use App\Models\Qr;
use App\Models\Schedule;
use App\Models\AttendQr;
use App\Models\AttendSchedule;

class ReportController extends BaseController
{
	public function orders()
	{
		return view('pages.report.orders');
	}

	public function getOrders(Request $request)
	{
		$start = Carbon::create($request->start)->hour(0)->minute(0)->second(0)->toDateTimeString();
		$end = Carbon::create($request->end)->hour(23)->minute(59)->second(59)->toDateTimeString();
		
		$qrs = Qr::where('start_time', '>=', $start)
						->where('start_time', '<=', $end)
						->get();

		$cnt = 0;
		$res = array();
		foreach($qrs as $qr) {
			$attends = $qr->attends;

			$attend_cnt = 0; $late_cnt = 0; $out_cnt = 0;
			if (isset($attends)) {
				$attend_cnt = $attends->where('status', 1)->count();
				$late_cnt = $attends->where('status', 2)->count();
				$out_cnt = count($qr->site->users) - $attend_cnt - $late_cnt;
			}

			$arr = array();
			$arr['no'] = ++$cnt;
			$arr['city'] = $qr->site->city->name;
			$arr['site'] = $qr->site->name;
			$arr['start'] = $qr->start_time;
			$arr['end'] = $qr->end_time;
			$arr['attend'] = $attend_cnt;
			$arr['late'] = $late_cnt;
			$arr['timeout'] = $out_cnt;
			$arr['id'] = Crypt::encryptString($qr->id);

			$res[] = $arr;
		}

    return json_encode(array('data' => $res));
	}

	public function viewOrder($id) 
	{
		$qr = Qr::find(Crypt::decryptString($id));
		$users = array(); $cnt=0;
		foreach($qr->site->users as $user) {
			$arr = array();
			$arr['no'] = ++$cnt;
			$arr['name'] = $user->name;
			$arr['email'] = $user->email;
			$arr['userId'] = $user->userId;
      $arr['job'] = $user->job->name;
			$arr['role'] = $user->role->name;
			
			$attend = AttendQr::where('user_id', $user->id)
											->where('qr_id', Crypt::decryptString($id))
											->first();

			$status = 'Not Attend';
			if(isset($attend)) {
				if($attend->status == 1) {
					$status = 'Attend';
				} else if($attend->status == 2) {
					$status = 'Late';
				}
			}
			$total = 'N/A';
			if(isset($attend->time_in) && isset($attend->time_out)) {
				$start = new \DateTime($attend->time_in);
				$end = new \DateTime($attend->time_out);
				$total = $start->diff($end)->format('%H:%I:%S');
			}
			
			$arr['time_in'] = $attend->time_in??'N/A';
			$arr['time_out'] = $attend->time_out??'N/A';
			$arr['total'] = $total;
			$arr['status'] = $status;
			$users[] = $arr;
		}

		return view('pages.report.order-view')->with([
			'title' => $qr->title? $qr->title: '---',
			'city' => $qr->site->city->name,
			'site' => $qr->site->name,
			'start' => $qr->start_time,
			'end' => $qr->start_end? $qr->start_end: '---',
			'users' => $users
		]);
	}
	
	public function schedules()
	{
		return view('pages.report.schedules');
	}

	public function getSchedules(Request $request)
	{
		$start = Carbon::create($request->start);
		$end = Carbon::create($request->end);
		$data_cnt = $start->diffInDays($end) + 1;
		
		$cnt = 0;
		$res = array();
		foreach(Schedule::all() as $schedule) {
			$attends = $schedule->attends;

			$attend_cnt = 0; $late_cnt = 0; $out_cnt = 0;
			if (isset($attends)) {
				$attend_cnt = AttendSchedule::where('schedule_id', $schedule->id)->where('status', '1')->whereDate('date', '>=', $start)->whereDate('date', '<=', $end)->count();
				$late_cnt = AttendSchedule::where('schedule_id', $schedule->id)->where('status', '2')->whereDate('date', '>=', $start)->whereDate('date', '<=', $end)->count();
				$out_cnt = count($schedule->site->users) * $data_cnt - $attend_cnt - $late_cnt;
			}

			$arr = array();
			$arr['no'] = ++$cnt;
			$arr['city'] = $schedule->site->city->name;
			$arr['site'] = $schedule->site->name;
			$arr['start'] = $schedule->start_time;
			$arr['end'] = $schedule->end_time;
			$arr['attend'] = $attend_cnt;
			$arr['late'] = $late_cnt;
			$arr['timeout'] = $out_cnt;
			$arr['id'] = Crypt::encryptString($schedule->id);

			$res[] = $arr;
		}

    return json_encode(array('data' => $res));
	}
	
	public function periodSchedules($id, $start, $end)
	{
	    $id = Crypt::decryptString($id);
	    $schedule = Schedule::find($id);
	    
		$cnt = 0;
		$start = Carbon::create($start);
		$end = Carbon::create($end);
		$diff = $start->diffInDays($end);
		
		$res = array();
		while($cnt <= $diff) {

            $date = date('Y-m-d', strtotime($start. ' + '.$cnt.' days'));
			$attend_cnt = AttendSchedule::where('schedule_id', $id)->where('status', '1')->whereDate('date', $date)->count();
			$late_cnt = AttendSchedule::where('schedule_id', $id)->where('status', '2')->whereDate('date', $date)->count();
			$out_cnt = count($schedule->site->users) - $attend_cnt - $late_cnt;
			
			$arr = array();
			$arr['date'] = $date;
			$arr['no'] = ++$cnt;
			$arr['attend'] = $attend_cnt;
			$arr['late'] = $late_cnt;
			$arr['timeout'] = $out_cnt;
			$arr['id'] = Crypt::encryptString($id);

			$res[] = $arr;
		}
		
		return view('pages.report.schedule-period-view')->with([
			'city' => $schedule->site->city->name,
			'site' => $schedule->site->name,
			'start' => $schedule->start_time,
			'end' => $schedule->start_end,
			'schedules' => $res
		]);
	}
	
	public function viewSchedule($id, $date) 
	{
		$schedule = Schedule::find(Crypt::decryptString($id));
		$users = array(); $cnt=0;
		foreach($schedule->site->users as $user) {
			$arr = array();
			$arr['no'] = ++$cnt;
			$arr['name'] = $user->name;
			$arr['email'] = $user->email;
			$arr['userId'] = $user->userId;
      $arr['job'] = $user->job->name;
			$arr['role'] = $user->role->name;
			
			$attend = AttendSchedule::where('user_id', $user->id)
											->where('schedule_id', Crypt::decryptString($id))
											->whereDate('date', $date)
											->first();

			$status = 'Not Attend';
			if(isset($attend)) {
				if($attend->status == 1) {
					$status = 'Attend';
				} else if($attend->status == 2) {
					$status = 'Late';
				}
			}
			$total = 'N/A';
			if(isset($attend->time_in) && isset($attend->time_out)) {
				$start = new \DateTime($attend->time_in);
				$end = new \DateTime($attend->time_out);
				$total = $start->diff($end)->format('%H:%I:%S');
			}
			
			$arr['time_in'] = $attend->time_in??'N/A';
			$arr['time_out'] = $attend->time_out??'N/A';
			$arr['total'] = $total;
			$arr['status'] = $status;
			$users[] = $arr;
		}

		return view('pages.report.schedule-view')->with([
			'city' => $schedule->site->city->name,
			'site' => $schedule->site->name,
			'start' => $schedule->start_time,
			'end' => $schedule->start_end,
			'users' => $users
		]);
	}
	
	public function getUserReport(Request $request)
	{
		$start = Carbon::create($request->start)->hour(0)->minute(0)->second(0)->toDateTimeString();
		$end = Carbon::create($request->end)->hour(23)->minute(59)->second(59)->toDateTimeString();

		$type = $request->type;
		$user_id = $request->id;

		$res = array(); $i=0;
		if ($type == 'qrs') {
			$qrs = User::find($user_id)->site->qrs->where('start_time', '>=', $start)
									->where('start_time', '<=', $end);

			foreach($qrs as $qr) {
				$arr = array(
					'no' => ++$i,
					'name' => $qr->title? $qr->title: '-',
					'start' => $qr->start_time,
					'end' => $qr->end_time,
				);
				$attend = AttendQr::where('qr_id', $qr->id)->where('user_id', $user_id)->first();
				if(isset($attend)) {
					$arr['in'] = isset($attend->time_in)? $attend->time_in: '-';
					$arr['out'] = isset($attend->time_out)? $attend->time_out: '-';
					$arr['result'] = $attend->status==0? 'Not Attend': ($attend->status==1? 'Attend': 'Late');
				} else {
					$arr['in'] = '-';
					$arr['out'] = '-';
					$arr['result'] = 'Not Attend';
				}

				$res[] = $arr;
			}
		} else {
			$attends = AttendSchedule::where('user_id', $user_id)
																->whereDate('date', '>=', Carbon::create($request->start))
																->whereDate('date', '<=', Carbon::create($request->end))
																->get();

			foreach($attends as $attend) {
				$arr = array(
					'no' => ++$i,
					'name' => $attend->date,
					'start' => $attend->schedule->start_time,
					'end' => $attend->schedule->end_time,
					'in' => isset($attend->time_in)? $attend->time_in: '-',
					'out' => isset($attend->time_out)? $attend->time_out: '-',
					'result' => $attend->status==0? 'Not Attend': ($attend->status==1? 'Attend': 'Late')
				);
				
				$res[] = $arr;
			}
		}

    return json_encode(array('data' => $res));
	}

	public function offer()
	{
		return view('pages.report.offer');
	}

}
