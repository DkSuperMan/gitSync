<?php

	// First, include Requests
include('Requests-1.6.0/library/Requests.php');
include('Requests-1.6.0/library/Requests/Cookie.php');
// // Next, make sure Requests can load internal classes
Requests::register_autoloader();

$ucCookie = array('22f12b27c09b41dab5e43e9ca41ba969','e3b69e42fa28430f862255ffb2165063','cb51ab0792bb4588aa9df5164bcc4f5a','86699fa9a8e14c6199a28ff02754669c','d40dd476a8964d4ab493d9512e031a69','ad18bf9838ba455c94de22b2cb0e3d73','8c38b7d3bcec41e9886f0596df348911','e2fc08b1bc104539b7079e0204325943','a38b9f721cd145f5a67eb3e92b3a5f7d','1ebd65fc97254ce2a7a9332a60586dee','28c4471a9f944c3093c5d9bd3b1f3550','13fe04096ae043108c3914f7b451b531','26107ebfc4af4bc4acbdcd985f62787c','285e49a55daf4867b11bbebd3ca8d35e','27a4867fb0f244d8bec5d05c7b85ff9f','def6bc5fbd1d462f81589e7849f08a7f','2d6ad918f651461c8b53c1256dd8684b','2e68e16485344a37ac4cf5bd0053e2eb','cf36ed774564412690f7700129e17cc9','f750d7bafccc430da50f07382673d036','52b5186a2df4482189b3a47bb74469df','8c9e37799a8740a496afa3f5d8b96492','7a54690f5b6445e38644428f32f53204','3ba83cede9304703a31a8c0804e1eec4','d56bf018774f46c493407c01ed019a58','ebd6e6fe991e4fd8ac35b67b678c5c27','3f0d308607a24e2ca1ebc8cdcd432df2');


$sessionStringValue1 =  getLoginSession('18051972163','111111');

// ignore_user_abort();//关闭浏览器后，继续执行php代码
set_time_limit(0);//程序执行时间无限制
$sleep_time = 10;//多长时间执行一次
do{
	// $hasTask = getValidTaskAndPost($sessionStringValue1,true);
	if(!$hasTask){

		doTask();

	}else{
		echo "没有任务<br>";
	}

	sleep($sleep_time);

}while(true);


return ;


function doTask()
{
	print_r($ucCookie);
	return;
	static $sessionStringValue2 =  '';
	if($sessionStringValue2 == ''){
		$sessionStringValue2 = getLoginSession('13814057793','111111');
		echo "获取session2 $sessionStringValue2<br>";
	}else{
		echo "存在session2 $sessionStringValue2<br>";
	}
	
	static $sessionStringValue3 =  '';
	if($sessionStringValue3 == ''){
		$sessionStringValue3 =  getLoginSession('15295793819','111111');
		echo "获取session3 $sessionStringValue3<br>";
	}else{
		echo "存在session3 $sessionStringValue3<br>";
	}
	
	static $sessionStringValue4 =  '';
	if($sessionStringValue4 == ''){
		$sessionStringValue4 =  getLoginSession('18751968273','111111');
		echo "获取session4 $sessionStringValue4<br>";
	}else{
		echo "存在session4 $sessionStringValue4<br>";
	}

	getValidTaskAndPost($sessionStringValue2);

	getValidTaskAndPost($sessionStringValue3);

	getValidTaskAndPost($sessionStringValue4);
}

function getLoginSession($userName,$password)
{
	$headers = array('Accept' => 'application/json','User-Agent' => 'Mozilla/5.0 (iPhone; iOS 8.3; Scale/2.00)');
	$requestUrlString = sprintf("http://api.fengchuan100.com/oauth/token?grant_type=password&password=%s&scope=read&username=%s",$password,$userName);

	echo($requestUrlString);
	echo"<br>";

	$request = Requests::get($requestUrlString,$headers);

	$content = json_decode($request->body);


	$sessionString = $content->value;

	return $sessionString;
		// print_r($content);
}


function getValidTaskAndPost($tokenString,$isPost = false)
{
// uc=e4f9101528de4aab8f016f93351cb8eb


	$c = new Requests_Cookie('login_uid', 'something');
	$request = Requests::get('http://httpbin.org/get', array('Cookie' => $c->formatForHeader()));

	$headers = array('Accept' => 'application/json','User-Agent' => 'Mozilla/5.0 (iPhone; iOS 8.3; Scale/2.00)');
	$parameter = sprintf("http://api.fengchuan100.com/api/app/lastMonthTaskList?access_token=%s&pageIndex=%d&pageSize=%d&searchTimes=%d",$tokenString,1,20,0);

	echo($parameter);
	echo"<br>";

	$request = Requests::get($parameter,$headers);

	$content = json_decode($request->body);

	$arr = $content->data->list;

	foreach ($arr as $value) {
	  	
		if($value->remain_times > 0 && $value->max_times > 0)
		{
			echo $value->ad_name;
		  	echo "<br>";
		  	echo($value->task_url);
		  	echo "<br>";

		  	if($isPost){
		  		echo "return true <br>";
		  		return true;
		  	}else{

			  	for ($i=0; $i < $value->max_times; $i++)
			  	{
				 //  	$clickUrl = sprintf("%s?from=singlemessage&isappinstalled=0",$value->task_url);
					// $clickRequest = Requests::get($clickUrl,$headers);

					// sleep(1.5);
					// var_dump($clickRequest->status_code);
			  		// print_r($_COOKIE);
			  	}

		  	}
		}
	}
	return false;
}
?>