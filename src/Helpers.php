<?php

namespace Maksuco\Helpers;

class Helpers
{
  //GetAvatar
  
	function period($period,$period2) {
	    if($period == 'month') {
	        $startDate = Carbon::now()->subMonth($period2)->startOfMonth();
	        $endDate = Carbon::now()->subMonth($period2)->endOfMonth();
	        if($period2 == 0) {
	        	$startDate = Carbon::now()->startOfMonth();
	        	$endDate = Carbon::now();
	        }
	    } elseif($period == 'year') {
	        $startDate = Carbon::now()->subYear($period2)->startOfYear();
	        $endDate = Carbon::now()->subYear($period2)->endOfYear();
	        if($period2 == 0) {
	        	$startDate = Carbon::now()->startOfYear();
	        	$endDate = Carbon::now();
	        }
	    } elseif($period == 'day') {
	        $startDate = Carbon::now()->subDay($period2);
	        $endDate = Carbon::now();
		} elseif($period == 'all') {
	        $startDate = Carbon::now()->subYear($period2)->startOfYear();
	        $endDate = Carbon::now();
		} else {
	    	$startDate = Carbon::createFromFormat('Y-m-d', $period);
			$endDate = Carbon::createFromFormat('Y-m-d', $period2);
		}
	    return [$startDate,$endDate];
	}
	
	function counter($period,$period2,$path) {
		
	    	$periods = period($period,$period2);
		    $metrics = 'ga:visits,ga:pageviews';
		    
			if(!empty($path)) {
				$analytics = Analytics::performQuery(Spatie\Analytics\Period::create($periods[0], $periods[1]), $metrics, $others = ['filters' => 'ga:pagePath=~/'.$path, 'dimensions' => 'ga:pagePath']);
				//dd($analytics);
				//SUMAR las distintas rows
				$visitors = 0; $pageviews = 0;
				foreach($analytics->rows as $row) {
					$visitors = $visitors + $row[1];
					$pageviews = $pageviews + $row[2];
				}
			} else {
				$analytics = Analytics::fetchVisitorsAndPageViews(Spatie\Analytics\Period::create($periods[0], $periods[1]));
				$visitors = $analytics->sum('visitors');
				$pageviews = $analytics->sum('pageViews');
			}
			
	    return [$visitors,$pageviews];
	}
	
	//RETURNS DATA FILTERED BY USER
	function dashboard($data) {
		$month = $data->filter(function($user){ return $user->created_at->format('m-y') == date('m-y'); });
		$lastmonth = $data->filter(function($user){ return $user->created_at->format('m-y') == Carbon::now()->firstOfMonth()->subMonth()->format('m-y'); });
		$year = $data->filter(function($user){ return $user->created_at->format('y') == date('y'); });
		$lastyear = $data->filter(function($user){ return $user->created_at->format('y') == Carbon::now()->subYear()->format('y'); });
	
		$results = collect([
				'month' => $month->count(),
				'lastmonth' => $lastmonth->count(),
				'year' => $year->count(),
				'lastyear' => $lastyear->count(),
				'total' => $data->count(),
			]);
			if(isset($data[0]['amount'])) {
				$results = $results->union([
					'month_sum' => $month->sum('amount'),
					'lastmonth_sum' => $lastmonth->sum('amount'),
					'year_sum' => $year->sum('amount'),
					'lastyear_sum' => $lastyear->sum('amount'),
					'total_sum' => $data->sum('amount'),
				]);
			};
	    return $results;
	}
	
	
	function chart($period,$period2,$path) {
		
	    	$periods = period($period,$period2);
		    $metrics = 'ga:visits,ga:pageviews';
		    
			if(!empty($path)) {
				$analytics = Analytics::performQuery(Spatie\Analytics\Period::create($periods[0], $periods[1]), $metrics, $others = ['filters' => 'ga:pagePath=~/'.$path, 'dimensions' => 'ga:pagePath']);
				$visitors = 0; $pageviews = 0;
				foreach($analytics->rows as $row) {
					$visitors = $visitors + $row[1];
					$pageviews = $pageviews + $row[2];
				}
			} else {
				$analytics = Analytics::fetchVisitorsAndPageViews(Spatie\Analytics\Period::create($periods[0], $periods[1]));
				$visitors = $analytics->pluck('visitors');
				$pageviews = $analytics->pluck('pageViews');
				$dates = $analytics->pluck('date');
			}
			foreach($dates as $date) {
				$labels[] = $date->format('d-m-Y');
			}
			
	        $labels = collect($labels);
			
	    return [$visitors,$pageviews,$labels];
	}
	
	//RETURNS CHART DATA FOR CLIENTS data1 and data2
	function charts($data1) {
	    $startDate = Carbon::now()->subDay(365);
	    $endDate = Carbon::now();
	
		//THIS RETURNS THE 4 BOXES
		$month = $data->filter(function($data1){ return $data1->created_at->format('m-y') == date('m-y'); });
		$lastmonth = $data->filter(function($data1){ return $data1->created_at->format('m-y') == Carbon::now()->firstOfMonth()->subMonth()->format('m-y'); });
		$year = $data->filter(function($data1){ return $data1->created_at->format('y') == date('y'); });
		$lastyear = $data->filter(function($data1){ return $data1->created_at->format('y') == Carbon::now()->subYear()->format('y'); });
	
	}
	
	
	function reports($biz_id,$table,$date,$sum) {
	
		$results = [];
		$resultsDB = \DB::table($table)->where('biz_id', $biz_id);

		if(isset($_GET['client_id']) AND $_GET['client_id'] != 'all' AND $table != 'clients') {
			$resultsDB->where('client_id', $_GET['client_id']);
		}

		$month = clone $resultsDB;
		$lastmonth = clone $resultsDB;
		$lastyear = clone $resultsDB;
		$year = clone $resultsDB;
		$dates_filtered = clone $resultsDB;

		if(isset($_GET['date_from'])) {
			$dates_filtered->whereDate($date, '>', $_GET['date_from']);
		}
		if(isset($_GET['date_to'])) {
			$dates_filtered->whereDate($date, '<', $_GET['date_to']);
		}
		$results['results'] = $dates_filtered->count();
		$results['results_sum'] = $dates_filtered->sum($sum);

		$month = $month->whereMonth($date, \Carbon::now()->format('m'));
		$lastmonth = $lastmonth->whereMonth($date, \Carbon::now()->firstOfMonth()->subMonth()->format('m'));
		$year = $year->whereYear($date, \Carbon::now()->format('Y'));
		$lastyear = $lastyear->whereYear($date, \Carbon::now()->subYear()->format('Y'));

		$results['month'] = $month->count();
		$results['month_sum'] = $month->sum($sum);
		$results['lastmonth'] = $lastmonth->count();
		$results['lastmonth_sum'] = $lastmonth->sum($sum);
		$results['year'] = $year->count();
		$results['year_sum'] = $year->sum($sum);
		$results['lastyear'] = $lastyear->count();
		$results['lastyear_sum'] = $lastyear->sum($sum);
		$results['total'] = $resultsDB->count();
		$results['total_sum'] = $resultsDB->sum($sum);
		
    	return $results;
	}
	
	function agent($mobile,$tablet,$desktop) {
	    $agent = $_SERVER["HTTP_USER_AGENT"];
	    if(preg_match("/(ipad|tablet)/i", $agent)) {
			return $tablet;  
	    } elseif(preg_match("/(android|webos|avantgo|iphone|ipod|blackberry|iemobile|bolt|boost|cricket|docomo|fone|hiptop|mini|opera mini|kitkat|mobi|palm|phone|pie|up\.browser|up\.link|webos|wos)/i", $agent)) {
			return $mobile; 
		}
	    return $desktop;
	}
}
