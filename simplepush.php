<?php

// Put your device token here (without spaces):
// 放置你的 device token:
    
$deviceToken = '';

    

// Put your private key's passphrase here:
// 放置你的私钥密码:
$passphrase = '';

// Put your alert message here:
// 放置你的提示信息:
$message = '';

// Put your category id here:
// 放置你的分类id:
$category = 'test';
////////////////////////////////////////////////////////////////////////////////

$ctx = stream_context_create();
stream_context_set_option($ctx, 'ssl', 'local_cert', 'SmcPushNotificationDev.pem');
//stream_context_set_option($ctx, 'ssl', 'local_cert', 'spendit_appstore_server.pem');
    
    
//stream_context_set_option($ctx, 'ssl', 'local_cert', 'spendit_dev_server.pem');
//stream_context_set_option($ctx, 'ssl', 'local_cert', 'smc_phone_dev.pem');

    
    
    
    
    
stream_context_set_option($ctx, 'ssl', 'passphrase', $passphrase);

// Open a connection to the APNS server
$fp = stream_socket_client(
	'ssl://gateway.sandbox.push.apple.com:2195', $err,
    //'ssl://gateway.push.apple.com:2195', $err,
	$errstr, 60, STREAM_CLIENT_CONNECT|STREAM_CLIENT_PERSISTENT, $ctx);

if (!$fp)
	exit("Failed to connect: $err $errstr" . PHP_EOL);

echo 'Connected to APNS' . PHP_EOL;

// Create the payload body
    
$body['aps'] = array(
	'alert' => $message,
	'badge' => 1,
	'category' => $category,
	'sound' => 'default'
	);
//$body['type'] = 'launchApp';
$body['url'] = 'http://www.baidu.com';
$body['msgId'] = 'abcdefg12345';

    
    
    
    
    
    
    
//$body['aps'] = array('content-available' => 0,'badge' => 3,'test' => 'test');
//$body['type'] = 'extBrowser';
$body['type'] = 'inAppBrowser';

// Encode the payload as JSON
$payload = json_encode($body);

// Build the binary notification
$msg = chr(0) . pack('n', 32) . pack('H*', $deviceToken) . pack('n', strlen($payload)) . $payload;

// Send it to the server
$result = fwrite($fp, $msg, strlen($msg));

if (!$result)
	echo 'Message not delivered' . PHP_EOL;
else
	echo 'Message successfully delivered' . PHP_EOL;

// Close the connection to the server
fclose($fp);
