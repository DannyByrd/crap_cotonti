<?php

defined('COT_CODE') or die('Wrong URL');

function cot_show_weather($city = false){

	global $db, $db_x, $cfg;

	if(!$city)
		$chosen_city = $cfg['plugin']['weather']['chosen_city'];
	else{
		$chosen_city = $city;
	}

	$db_pages = $db_x.'cities';
	$query = $db->query("SELECT city_curid  FROM $db_pages AS cities WHERE city_name = '$chosen_city' ");
	$res = $query->fetch();
	$city_id= $res['city_curid'];
	

	$data_file="http://export.yandex.ru/weather-ng/forecasts/$city_id.xml"; // адрес xml файла 

	$xml = @simplexml_load_file($data_file); // раскладываем xml на массив
	
	if(!$xml){

		$t = new XTemplate(cot_tplfile('weather.error', 'plug'));
		$t->assign(array('WEATHER_ERROR'	=>true));
		$t->parse('MAIN');

		return $t->text();
		

	}

	
	$res_pic = xml2array($xml->fact);
			
	$img_temp_src = "http://yandex.st/weather/1.1.78/i/icons/48x48/".$res_pic['image-v3'].".png";
	
	$temp = xml2array($xml->fact->temperature);
	$cour_temp= setSign($temp[0]);
	

	$temp = xml2array($xml->fact->weather_type);
	$cour_type= $temp[0];
	
	$temp = xml2array($xml->day[0]->hour[22]);
	$night_temp = setSign($temp['temperature']); 
	
		
	$temp = xml2array($xml->day[1]->day_part[1]->weather_type);
	$tommorow_type= $temp[0];

	$temp =  xml2array($xml->day[1]->day_part[1]);
	$tommorow_temp = $temp['temperature-data']['avg']; 
	
	$temp =  xml2array($xml->day[1]->day_part[3]);
	$tommorow_night_temp = $temp['temperature-data']['avg']; 

	$res_img_tm = xml2array($xml->day[1]->day_part[1]);
	
	$img_tommorow_temp_src = "http://yandex.st/weather/1.1.78/i/icons/48x48/".$res_img_tm['image-v3'].".png";
  
	
	$t = new XTemplate(cot_tplfile('weather', 'plug'));

	$t->assign(array(
		'WEATHER_CITY'		    =>$chosen_city,
		'WEATHER_NOW_IMG_SRC'	=>$img_temp_src,
		'WEATHER_NOW_TEMP'	    =>$cour_temp,
		'WEATHER_NOW_TYPE'	    =>$cour_type,
		'WEATHER_NOW_NIGHT'      =>$night_temp,

		));

	$t->assign(array(
		
		'WEATHER_TOMR_IMG_SRC'	=>$img_tommorow_temp_src,
		'WEATHER_TOMR_TEMP'	    =>$tommorow_temp,
		'WEATHER_TOMR_TYPE'	    =>$tommorow_type,
		'WEATHER_TOMR_NIGHT'    =>$tommorow_night_temp,

		));


	
	$t->parse('MAIN.WEATHER_ROW');

	$t->parse('MAIN');

	return $t->text();
}

function cot_show_full_weather(){

	global $db, $db_x, $cfg;
	$chosen_city = $cfg['plugin']['weather']['chosen_city'];

	$db_pages = $db_x.'cities';
	$query = $db->query("SELECT city_curid  FROM $db_pages AS cities WHERE city_name = '$chosen_city' ");
	$res = $query->fetch();
	$city_id= $res['city_curid'];

	$data_file="http://export.yandex.ru/weather-ng/forecasts/$city_id.xml"; // адрес xml файла 
	$xml = @simplexml_load_file($data_file); // раскладываем xml на массив

	if(!$xml){

		$t = new XTemplate(cot_tplfile('weather.error', 'plug'));
		$t->assign(array('WEATHER_ERROR'	=>true));
		$t->parse('MAIN');
		
		return $t->text();
		

	}

	$t = new XTemplate(cot_tplfile('weather.full', 'plug'));
	$t->assign(array('FULL_WEATHER_CITY'=>$chosen_city));
	for($i=0; $i<10; $i++){

		$res = xml2array($xml->day[$i]);
		$date = $res['@attributes']['date'];

			$t->assign(array('FULL_WEATHER_DATA'=>$date));

		for($j=0; $j<4; $j++){

			$day_part =  xml2array($res['day_part'][$j]);
			$dayp_temperature_from = $day_part['temperature_from'];
			$dayp_temperature_to = $day_part['temperature_to'];
			$dayp_weather_type = $day_part['weather_type'];
			$dayp_pressure = $day_part['pressure'];
			$dayp_humidity = $day_part['humidity'];
			$dayp_wind_speed = $day_part['wind_speed'];
			$dayp_wind_direction = $day_part['wind_direction'];
			//$dayp_image = 'https://yastatic.net/weather/i/icons/svg/'.$day_part['image-v3'].'.svg';
			$dayp_image = "http://yandex.st/weather/1.1.78/i/icons/48x48/".$day_part['image-v3'].".png";
			

			switch ($j) {
				case 0:  $day_part = 'Утром'; $new_day = 'true'; break;
				case 1:  $day_part = 'Днем'; $new_day = 'false';break;
				case 2:  $day_part = 'Вечером';$new_day = 'false'; break;
				case 3:  $day_part = 'Ночью'; $new_day = 'end';break;
				
			}
		

			$t->assign(array(
				'FULL_WEATHER_DAYPART_NEWDAY'       =>$new_day,
				'FULL_WEATHER_DAYPART_KIND'			=>$day_part,
				'FULL_WEATHER_DAYPART_IMAGE'		=>$dayp_image,
				'FULL_WEATHER_DAYPART_TEMPFROM'		=>$dayp_temperature_from,
				'FULL_WEATHER_DAYPART_TEMPTO'	    =>$dayp_temperature_to,
				'FULL_WEATHER_DAYPART_TYPE'	  	 	=>$dayp_weather_type,
				'FULL_WEATHER_DAYPART_PRESSURE'      =>$dayp_pressure,
				'FULL_WEATHER_DAYPART_HUMIDITY'      =>$dayp_humidity,
				'FULL_WEATHER_DAYPART_WINDSPEED'     =>$dayp_wind_speed,
				'FULL_WEATHER_DAYPART_WINDDIR'       =>getWINDDIR($dayp_wind_direction),

		));
			
		
			


			
			$t->parse('MAIN.FULL_WEATHER_ROW');

			


		}
			
	}

	

	$t->parse('MAIN');

	return $t->text();
	
	
}

function xml2array ( $xmlObject, $out = array () )
{
    foreach ( (array) $xmlObject as $index => $node )
        $out[$index] = ( is_object ( $node ) ) ? xml2array ( $node ) : $node;

    return $out;
}
function setSign($temp){

	$res = '';
	if ($temp>0) {
		$res='+'.$temp;
	}else if($temp<0){
		$res='-'.$temp;
	}else{
		$res = $temp;
	}
	return $res;

}
function getWINDDIR($dir){

	$first = substr($dir,0,1);
	$second = substr($dir,-1);
	
	
	$direction = array('n'=>'С','e'=>'В','w'=>'З','s'=>'Ю');
	return $direction[$first].$direction[$second];
	

}
