<?php
set_time_limit(0);
$success = 0;
$error = 0;
$pre = $argv[1] ? $argv[1] : "0912";

$start = $argv[2] ? $argv[2] : 1000000;
$end = $argv[3] ? $argv[3] : 9999999;

for ($i = $start; $i < $end; $i++) {
	$mobile = $pre . $i;

	if (!spam($mobile)) {
		logtxt($mobile);
		$error++;
	} else {
		logtxt($mobile, 'successspam.txt');
		$success++;
	}
}
die('done ! success count : ' . $success . ' | error count : ' . $error);

function spam($mobile)
{
	@unlink(__DIR__ . '/spam_cookie.txt');
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, 'https://landings.serviice3.com/seq68/RHH14D');
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
	curl_setopt($ch, CURLOPT_COOKIEJAR, __DIR__ . '/spam_cookie.txt');
	curl_setopt($ch, CURLOPT_COOKIEFILE, __DIR__ . '/spam_cookie.txt');
	curl_setopt($ch, CURLOPT_ENCODING, 'gzip, deflate');
	curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
	$headers = array();
	$headers[] = 'Authority: landings.serviice3.com';
	$headers[] = 'Pragma: no-cache';
	$headers[] = 'Cache-Control: no-cache';
	$headers[] = 'Upgrade-Insecure-Requests: 1';
	$headers[] = 'User-Agent: Mozilla/5.0 (Macintosh; Intel Mac OS X 10_13_6) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/73.0.3683.103 Safari/537.36';
	$headers[] = 'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3';
	$headers[] = 'Accept-Encoding: gzip, deflate, br';
	$headers[] = 'Accept-Language: en-US,en;q=0.9,fa;q=0.8';
	curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
	$result = curl_exec($ch);
	if (curl_errno($ch)) {
		echo 'Error:' . curl_error($ch);
		return false;
	}
	curl_close($ch);
	$ch = curl_init();
	$data = [
		'ReferralCode' => '',
		'Msisdn' => $mobile
	];
	curl_setopt($ch, CURLOPT_URL, 'https://landings.serviice3.com/Home/Request');
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_ENCODING, 'gzip, deflate');
	curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
	curl_setopt($ch, CURLOPT_COOKIEJAR, __DIR__ . '/spam_cookie.txt');
	curl_setopt($ch, CURLOPT_COOKIEFILE, __DIR__ . '/spam_cookie.txt');
	$headers = array();
	$headers[] = 'Authority: landings.serviice3.com';
	$headers[] = 'Pragma: no-cache';
	$headers[] = 'Cache-Control: no-cache';
	$headers[] = 'Origin: https://landings.serviice3.com';
	$headers[] = 'Upgrade-Insecure-Requests: 1';
	$headers[] = 'Content-Type: application/x-www-form-urlencoded';
	$headers[] = 'User-Agent: Mozilla/5.0 (Macintosh; Intel Mac OS X 10_13_6) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/73.0.3683.103 Safari/537.36';
	$headers[] = 'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3';
	$headers[] = 'Referer: https://landings.serviice3.com/seq68/RHH14D';
	$headers[] = 'Accept-Encoding: gzip, deflate, br';
	$headers[] = 'Accept-Language: en-US,en;q=0.9,fa;q=0.8';
	curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
	$result = curl_exec($ch);
	if (curl_errno($ch)) {
		echo 'Error:' . curl_error($ch);
		return false;
	}
	curl_close($ch);
	return (strpos($result, 'numberEdit') !== false);
}

function logtxt($txt, $file = 'errorspam.txt')
{
	$h = fopen($file, 'a+');
	fwrite($h, $txt . PHP_EOL);
	fclose($h);
}
