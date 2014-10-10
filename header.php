<!DOCTYPE html>
<html>
<?php
	session_cache_expire(10);
	session_start();
	include 'mdetect.php';
	
	$uagent_obj = new uagent_info();
	if ($uagent_obj->DetectMobileQuick() == $uagent_obj->true) {
		$_SESSION['mobile'] = "true";
		if ($uagent_obj->DetectIphone() == $uagent_obj->true) {
			$_SESSION['browsertype'] = "an Iphone";	
		}
		elseif ($uagent_obj->DetectIpod() == $uagent_obj->true) {
			$_SESSION['browsertype'] = "an Ipod";
		}
		elseif ($uagent_obj->DetectIpad() == $uagent_obj->true) {
			$_SESSION['browsertype'] = "an Ipad";
		}
		elseif ($uagent_obj->DetectAndroidPhone() == $uagent_obj->true) {
			$_SESSION['browsertype'] = " an Android phone";
		}
		elseif ($uagent_obj->DetectAndroidTablet() == $uagent_obj->true) {
			$_SESSION['browsertype'] = " an Android tablet";
		}
		elseif ($uagent_obj->DetectWindowsPhone() == $uagent_obj->true) {
			$_SESSION['browsertype'] = " a new Windows phone";
		}
		elseif ($uagent_obj->DetectBlackBerry10Phone() == $uagent_obj->true) {
			$_SESSION['browsertype'] = "a Blackberry 10 phone";
		}
		elseif ($uagent_obj->DetectBlackBerryTablet() == $uagent_obj->true) {
			$_SESSION['browsertype'] = "a Blackberry Tablet";
		}
		elseif ($uagent_obj->DetectBlackberryTouch() == $uagent_obj->true) {
			$_SESSION['browsertype'] = "a Blackberry Touch phone";
		}
		elseif ($uagent_obj->DetectBlackBerryHigh() == $uagent_obj->true) {
			$_SESSION['browsertype'] = "an old Blackberry phone";
		}
		elseif ($uagent_obj->DetectBlackBerryLow() == $uagent_obj->true) {
			$_SESSION['browsertype'] = "a really old Blackberry phone";
		}
	}
	else {
		$_SESSION['mobile'] = "false";
		$_SESSION['browsertype'] = "a PC";
	}
?>
    	<head>
        	<title>PA House System</title>
        	<!-- Bootstrap -->
        	<link href="bootstrapmin.css" rel="stylesheet" media="screen">
        	<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta name="viewport" content="width=device-width, minimum-scale=1.0, maximum-scale=1.0" />
        	<!-- <link href="assets/css/bootstrap-responsive.css" rel="stylesheet"> -->
		<!-- <link rel="stylesheet" type="text/css" href="stylesheets/iphonestyle.css"> -->
		<link red="stylesheet" type="text/css" href="scroll.css">

		<?php
			include 'database_connect.php';
		?>

    	</head>
    	<body>
    		<div class="container-fluid">
            		<div class="row-fluid">
                		<h1><a class="one" href="http://localhost/House/Home.php">PA House System</a></h1>
            		</div>
