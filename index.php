<?php

include "config.php";

$fb = new Facebook\Facebook([
	'app_id' => FB_APP_ID,
	'app_secret' => FB_APP_SECRET,
	'default_graph_version' => 'v2.11',
]);

if (isset($_SESSION['fb_access_token']))
{
	// udah login
	try {
		// ambil data user
		// list lengkap fields ada di https://developers.facebook.com/docs/graph-api/reference/user
		// 
		$response = $fb->get('/me?fields=id,name,email,cover,gender,hometown', $_SESSION['fb_access_token']);
	} catch(Facebook\Exceptions\FacebookResponseException $e) {
		echo 'Graph returned an error: ' . $e->getMessage();
		exit;
	} catch(Facebook\Exceptions\FacebookSDKException $e) {
		echo 'Facebook SDK returned an error: ' . $e->getMessage();
		exit;
	}

	$user = $response->getGraphUser();

	echo '<p>Name using $user[\'name\'] : ' . $user['name'] . '</p>';
	echo '<p>Name using $user->getName() : ' . $user->getName() . '</p>';
	echo '<p>full data</p>';
	echo '<pre>';
	var_dump($user);
	echo '</pre>';
	echo '<br><br><a href="logout.php">Logout</a>';
	
} else {
	
	// belom login
	$helper = $fb->getRedirectLoginHelper();

	if (isset($_GET['state'])) {
	    $helper->getPersistentDataHandler()->set('state', $_GET['state']);
	}

	$permissions = ['email'];
	$loginUrl = $helper->getLoginUrl('http://localhost/fblogin/fb-callback.php', $permissions);

	echo '<a href="' . htmlspecialchars($loginUrl) . '">Log in with Facebook!</a>';
}