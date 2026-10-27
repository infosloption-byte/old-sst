<?php

namespace App\Modules\ProfileManage\Logics;

use DB;
use Sentinel;
use Response;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Http\Controllers\Controller;

use App\Models\User;
use App\Models\BmiTitle;
use App\Models\BodyMeasurement;
use App\Models\Health;
use App\Models\MeasurementUnit;
use App\Models\UserBodyMeasurement;
use App\Models\UserHealth;
use System\Employee\Models\Employee;
use System\Department\Models\Department;

use App\Modules\UnitConversion\Convert;


class ProfileLogic{
        
    public function __construct()
    {
        
    }

    public function getUserLastBodyMeasurement($user_id)
    {

    	$res = DB::select(DB::raw(
    				'select
						bm.name as bm_name,
						bm.default_unit_id as default_unit,
						dd.measure_value,
						mu.unit,
						dd.created_at,
						mu.id as customer_unit
					from
					    (SELECT
					        body_measurement_id,
					        measure_value,
					        created_at,
					        measurement_unit_id
					    FROM 
					        `user_body_measurement` 
					            INNER JOIN 
					        (SELECT 
					            MAX(id) as id 
					         FROM 
					            `user_body_measurement` 
					         where user_id='.$user_id.'
					         GROUP BY 
					            `user_body_measurement`.`body_measurement_id`
					        ) last_updates ON last_updates.id = `user_body_measurement`.id) as dd
							left join
						body_measurements bm on dd.body_measurement_id = bm.id
							left join
						measurement_units mu on dd.measurement_unit_id = mu.id'
					));
    	foreach ($res as $key => $value) {
    		
    		$msr = $value->measure_value;

    		if($value->customer_unit==1){
    			//Weight
		    	$cnvrtd_value = (float)$msr;
	    		$value->measure_value = number_format($cnvrtd_value,1);
		    }elseif($value->customer_unit==2){

		    	$cnvrtd_value = (float)$msr/0.4535;
	    		$value->measure_value = number_format($cnvrtd_value,1);

		    }elseif($value->customer_unit==3){

	    		$cnvrtd_value = (float)$msr/0.01;
	    		$value->measure_value = number_format($cnvrtd_value,1);

	    	}elseif($value->customer_unit==4){

	    		$cnvrtd_value = (float)$msr/0.0254;
	    		$value->measure_value = number_format($cnvrtd_value,1);

	    	}elseif($value->customer_unit==5){

	    		// $cnvrtd_value = (float)$msr/0.3048;
	    		$value->measure_value = $this->metersToFeetInches($msr);

	    	}

    	}
    	return $res;
    }


    public function getUserLastBodyMeasurementProfile($user_id)
    {

		
    	$response = [];
    	$res = DB::select(DB::raw(
    				'select
						bm.name as bm_name,
						bm.default_unit_id as default_unit,
						dd.measure_value,
						mu.unit,
						bm.id as type,
						dd.created_at,
						mu.id as customer_unit
					from
					    (SELECT
					        body_measurement_id,
					        measure_value,
					        created_at,
					        measurement_unit_id
					    FROM 
					        `user_body_measurement` 
					            INNER JOIN 
					        (SELECT 
					            MAX(id) as id 
					         FROM 
					            `user_body_measurement` 
					         where user_id='.$user_id.'
					         GROUP BY 
					            `user_body_measurement`.`body_measurement_id`
					        ) last_updates ON last_updates.id = `user_body_measurement`.id) as dd
							left join
						body_measurements bm on dd.body_measurement_id = bm.id
							left join
						measurement_units mu on dd.measurement_unit_id = mu.id'
					));
    	foreach ($res as $key => $value) {
    		
    		$standard = $value->measure_value;

    		if($value->type==1){
    			//Weight
    			if(strtolower($value->unit)=="kg"){
    				//nothing to convert	
    				$response['weight'] = ['standard'=>$standard,'value'=>$standard." Kg",'unit'=>$value->unit];
    			}else{
    				//convert 
					$convereted = Convert::lbsToKg($standard);
    				$response['height'] = ['standard'=>$standard,'value'=>$convereted,'unit'=>$value->unit];
    			}
	    		
		    }elseif($value->type==2){
				//Height
	    		if(strtolower($value->unit)=="inch"){
    				//nothing to convert	
    				$response['height'] = ['standard'=>$standard,'value'=>$standard,'unit'=>$value->unit];
    			}else{
    				//convert 
					$convereted = Convert::cmToFtIn($standard);
    				$response['height'] = ['standard'=>$standard,'value'=>$convereted,'unit'=>$value->unit];
    			}

		    }elseif($value->type==3){
		    	//waist
				if(strtolower($value->unit)=="cm"){
    				//nothing to convert	
    				$response['waist'] = ['standard'=>$standard,'value'=>$standard." cm",'unit'=>$value->unit];
    			}else{
    				//convert 
    				$convereted = Convert::cmToIn($standard);
    				$response['waist'] = ['standard'=>$standard,'value'=>$convereted." inch",'unit'=>$value->unit];
    			}
	    	}elseif($value->type==4){
	    		//tummy
	    		if(strtolower($value->unit)=="cm"){
    				//nothing to convert	
    				$response['tummy'] = ['standard'=>$standard,'value'=>$standard." cm",'unit'=>$value->unit];
    			}else{
    				//convert 
    				$convereted = Convert::cmToIn($standard);
    				$response['tummy'] = ['standard'=>$standard,'value'=>$convereted." inch",'unit'=>$value->unit];
    			}
	    	}

    	}
    	return $response;
    }

    public function saveBodyMeasureDetails($data)
    {
    	$user_id = \Auth::user()->id;
		$day = Carbon::now('Asia/Colombo')->toDateString();

		$_tmp = BodyMeasurement::all();

		$i=0;

		foreach ($_tmp as $value) {

			if($data['option_'.$value->id]==1){

		    	$_measure_value = (float)$data['measure_'.$value->id];

		    }elseif($data['option_'.$value->id]==2){

		    	$_measure_value = (float)$data['measure_'.$value->id]*0.4535;

		    }elseif($data['option_'.$value->id]==3){

	    		$_measure_value = (float)$data['measure_'.$value->id]*0.01;
	    		
	    	}elseif($data['option_'.$value->id]==4){

	    		$_measure_value = (float)$data['measure_'.$value->id]*0.0254;
	    		
	    	}elseif($data['option_'.$value->id]==5){

	    		$_measure_value = (float)$data['measure_'.$value->id]*0.3048;
	    		
	    	}

			$res = UserBodyMeasurement::create([
				'date' => $day,
				'user_id' => $user_id,
				'body_measurement_id' => $value->id,
				'measure_value' => $_measure_value,
				'measurement_unit_id' => $data['option_'.$value->id]
			]);

			if(!$res){
				$i++;
			}
		}

		if($i==0){
			return 1;
		}else{
			return 0;
		}
    }

    public function calculateUserBmi($user_id)
    {
    	$res = DB::select(DB::raw(
    				'SELECT
				        body_measurement_id,
				        measure_value,
				        measurement_unit_id
				    FROM 
				        `user_body_measurement` 
				            INNER JOIN 
				        (SELECT 
				            MAX(id) as id 
				         FROM 
				            `user_body_measurement` 
				         where user_id='.$user_id.' 
				         GROUP BY 
				            `user_body_measurement`.`body_measurement_id`
				        ) last_updates ON last_updates.id = `user_body_measurement`.id
					where body_measurement_id in (1,2) order by body_measurement_id'
					));

		if(count($res)>1){

			$weight = (float)$res[0]->measure_value;
	    	$height = (float)$res[1]->measure_value;
	    	$m2 =  ($height/100)*($height/100);
	    	$bmi = (($weight) / $m2);
	    	$bmi = number_format($bmi,2);
	    	$bmi_status = '';

	    	if($bmi<=18.5){
				$bmi_status = 'Underweight';
	    	}elseif($bmi>18.5 && $bmi<=24.9){
				$bmi_status = 'Healthyweight';
	    	}elseif($bmi>24.9 && $bmi<=29.9){
				$bmi_status = 'Overweight';
	    	}elseif($bmi>=30){
				$bmi_status = 'Obese';
	    	}

	    	return ['bmi_value'=>$bmi,'status'=>$bmi_status];

		}else{
			return ['bmi_value'=>0,'status'=>"no data"];
		}    	
    }

    public function calculateUserHealthScore($user_id)
    {
    	$date = date('Y-m-d'); //today date
		
		$_sub_avg = [];

		for($i = 0; $i <= 6; $i++){
		    $day = date('Y-m-d', strtotime("-$i day", strtotime($date)));

		    $res = DB::select(DB::raw(
		    	'SELECT
					COUNT(`user_health`.`id`) as okay 
				FROM 
					`user_health` 
				WHERE 
					`user_health`.`user_id`='.$user_id.' 
				    	and 
				    `user_health`.`health_date`="'.$day.'" 
				    	and 
				   	`user_health`.`value`=1'
		    ));

		    $_sub_avg[] = ($res[0]->okay/6)*100;
		}

		return number_format(array_sum($_sub_avg)/count($_sub_avg),2);	
    }

    public function getAnalysChartData($user)
    {
    	 $response['chart'] =  [];;

    	for ($i=0; $i < 6; $i++) { 
            $weight = $this->getHealthFig(1,$i,$user);
            $height = $this->getHealthFig(2,$i,$user);
            $waist  = $this->getHealthFig(3,$i,$user);
            $tummy  = $this->getHealthFig(4,$i,$user);
            $month  = date_format(date_create(date('Y-m', strtotime("-$i month"))),"Y M");

            $w = $weight?floatval($weight->measure_value):0;
            $h = $height?floatval($height->measure_value):0;
            $m2 = $h>0&&$w>0?($h/100)*($h/100):0;
            $bmival = $h>0&&$w>0?($w / $m2):0;
            $bmi = number_format($bmival,2);

            array_push($response['chart'], [
                'bmi' => $bmi,
                'weight' => $weight?floatval($weight->measure_value):0,
                'waist' => $waist?floatval($waist->measure_value):0,
                'tummy' => $tummy?floatval($tummy->measure_value):0,
                'month' => $month
            ]);

        }

         $response['chart'] = array_reverse($response['chart']);

		return $response;
    }

    public function getHealthFig($type,$month,$user)
    {
        $_mnth = date('Y-m', strtotime("-$month month"));

        $_res = UserBodyMeasurement::selectRaw('*,(select name from body_measurements where id=user_body_measurement.body_measurement_id) as type')
                        ->where('date','like','%'.$_mnth.'%')
                        ->where('body_measurement_id',$type)
                        ->where('user_id',$user->id)
                        ->orderBy('created_at','DESC')
                        ->limit(1)
                        ->first();
        
        return $_res;

        
    }

    public function metersToFeetInches($meters)
	{
		$m = $meters;
		$valInFeet = $m*3.2808399;
		$valFeet = (int)$valInFeet;
		$valInches = round(($valInFeet-$valFeet)*12);
		$data = $valFeet." ft ".$valInches." inch";
		
		return $data;
	}
   
}
