<?php

	//устанавливам временную зону
	date_default_timezone_set ("+00:00");
	ini_set('date.timezone', 'UTC');

	$now = new DateTime();
	$mins = $now->getOffset() / 60;

	$sgn = ($mins < 0 ? -1 : 1);
	$mins = abs($mins);
	$hrs = floor($mins / 60);
	$mins -= $hrs * 60;

	$offset = sprintf('%+d:%02d', $hrs*$sgn, $mins);


	//Массив с настройками, далее возможно будет меняться из БД
	$CONFIG['Root'] = $_SERVER['DOCUMENT_ROOT'];
	$CONFIG['Template'] = 'default';
	$CONFIG['Adminfolder'] = 'zn7admin';
	$CONFIG['Adminpassword'] = 'RhodiumAdminPanel';
	$CONFIG['Adminpasswordhash'] = md5('RhodiumAdminPanel');
	$CONFIG['Language'] = 'english';
	$CONFIG['Domain'] = 'http://188.226.129.95/';
	$CONFIG['DomainProtocol'] = 'http://';
	$CONFIG['Activation_link'] = $CONFIG['Domain'] . "activation";
	$CONFIG['DomainAutoDetect'] = $CONFIG['DomainProtocol'] . $_SERVER['HTTP_HOST'] . '/';
	$CONFIG['Salt'] = 'caravan';
	$CONFIG['Supportemail'] = 'support@zinc7.cc';
	$CONFIG['ReferalMaxLevel'] = 3;
	$CONFIG['VipFirstrefpercent'] = 0.07;
	$CONFIG['Firstrefpercent'] = 0.05;
	$CONFIG['Secondrefpercent'] = 0.02;
	$CONFIG['Thirdrefpercent'] = 0.01;
	$CONFIG['Fourthrefpercent'] = 0.01;
	$CONFIG['Fifthrefpercent'] = 0.01;
	$CONFIG['Sixthrefpercent'] = 0.005;
	$CONFIG['Seventhrefpercent'] = 0.002;
	$CONFIG['SystemIp'] = '185.48.236.66';
	$CONFIG['TotalSlots'] = array(1, 2, 3, 4, 5, 6, 7);
	$CONFIG['PaginationPages'] = 10;
	$CONFIG['PaginationOnPage'] = 100;
	$CONFIG['ExternalPages'] = array('login', 'signup', 'signup2', 'investment_plans', 'security', 'about', 'support', 'statistic', 'faq', 'forgot_password', 'main', 'news', 'rules', 'representatives', 'feedback', 'banned');
	$CONFIG['CurrentDate'] = date("d.m.y");
	$CONFIG['CurrentTime'] = strtoupper(date("M-d-Y H:i:s"));
	$CONFIG['CurrentTimeFooter'] = date("H:i:s");
	$CONFIG['AllowedIp'] = array('198.50.152.89', '108.162.216.242');
	$CONFIG['VisitorsDbFile'] = 'visitors.db';
	$CONFIG['VisitorsOnlineTime'] = '1000';
	$CONFIG['OnlineVisitors'] = countvisitors() + 213;
	$CONFIG['OnlineMembers'] = intval($CONFIG['OnlineVisitors'] * 0.2);
	$CONFIG['BlockedUsers'] = '1';
	//$CONFIG['NotAutoWithdraw'] = '1';
	$CONFIG['SecurityTime'] = 60;
	$CONFIG['AutoWithdraw'] = '1';
	$CONFIG['DaysOnline'] = date_diff(new DateTime(), new DateTime('2016-09-10 00:00:00'))->days;
	$CONFIG['Circles'] = floor($CONFIG['DaysOnline'] / 21);
	$CONFIG['FirstPlanPercent'] = 0.07;
	$CONFIG['FirstPlanDays'] = 22;
	$CONFIG['SecondPlanPercent'] = 1.1;
	$CONFIG['SecondPlanDays'] = 7;
	$CONFIG['certificateIdPrefix'] = 'Z716';
	$CONFIG['MAX_WITHDRAW_LIMIT'] = 300;

	$currentdate = new DateTime(date("Y-m-d H:i:s"));
	$currenthours = date("H");
	if ($currenthours < 12) {
		$nextpayment = new DateTime(date("Y-m-d 12:00:00"));
	}else{
		$nextpayment = new DateTime(date("Y-m-d 23:59:59"));
	}
	$interval = $currentdate->diff($nextpayment);
	$CONFIG['NextPaymentTime'] = $interval->format('%H:%i');

/*
	if (!in_array($_SERVER['REMOTE_ADDR'], $CONFIG['AllowedIp'])) {
		unset ($_SESSION['uid']);
		unset ($_SESSION['loggedinstatus']);
		echo "<center><h2>Only private members!</h2></center>";
		die();
	}
*/
	
	$stat = getmainstatistic();

	// преобразовываем данные из POST и GET запросов в переменные
	foreach ($_REQUEST as $key => $value)
	{
		if (is_array($value)) {
			$tmp = array();
			foreach ($value as $k => $v) {
				$tmp[$k] = sanitize(htmlspecialchars(mysqli_real_escape_string($link, $v)));
			}
			$$key = $tmp;
		}else{
			$$key = sanitize(htmlspecialchars(mysqli_real_escape_string($link, $value)));
		}
	}

	//подключаем языковой файл
	if(isset($lang)){
		$language = $lang;
		$_SESSION['lang'] = $lang;
		setcookie('lang', $lang, time() + (3600 * 24 * 30));
		header("Location:" . $CONFIG['Domain'] . substr($_SERVER['REDIRECT_URL'], 1));
	}elseif(isset($_SESSION['lang'])){
		$language = $_SESSION['lang'];
	}elseif(isset($_COOKIE['lang'])){
		$language = $_COOKIE['lang'];
	}else{
		$language = $CONFIG['Language'];
	}

	//$language = $CONFIG['Language'];
	if (file_exists('lang/' . $language . '.php')) {
		require_once 'lang/' . $language . '.php';
	}else{
		require_once 'lang/english.php';
	}
	

	// вот тут будут наши "контроллеры"
	$controller = array();
 
	if (isset($_SERVER['REQUEST_URI'])) {
		// получили строку
		$query_string = trim($_SERVER['REQUEST_URI']);
		if (strpos($query_string, $CONFIG['Adminfolder'])) {
            $query_string = substr($query_string, strlen($CONFIG['Adminfolder']) + 2); 
        }
        if (strpos($query_string, '?')) {
        	$query_string = explode('?', $query_string);
        	$query_string = $query_string['0'];
        }
	}else $query_string = '';

	// на всякий случай декодируем
	$query_string = urldecode($query_string);
	 
	// разбиваем на массив
	$query_controller = explode("/", $query_string); 
	 
	// и проверяем 
	// а вдруг в конец слеш не дописали?
	// да и почистим сразу от SQL-инъекций
	foreach ($query_controller as $query_param)
	if ($query_param != ""){
		$controller[] = sanitize(htmlspecialchars(mysqli_real_escape_string($link, $query_param)));		
	}

	// проверяем все ли вызываемые контроллеры присутвуют в папке, если нет - перенаправляем на 404
	if (!empty($controller)) {
		if (nocontroller($controller)) {
			unset($controller);
			$controller[] = '404';
		}
	}

	// если не передан никакой контроллер, подключаем основной
	if (empty($controller)) {
		$controller[] = 'main';
	}

	$newslist = getlistnews(2);

?>
<?php

	//устанавливам временную зону
	date_default_timezone_set ("+00:00");
	ini_set('date.timezone', 'UTC');

	$now = new DateTime();
	$mins = $now->getOffset() / 60;

	$sgn = ($mins < 0 ? -1 : 1);
	$mins = abs($mins);
	$hrs = floor($mins / 60);
	$mins -= $hrs * 60;

	$offset = sprintf('%+d:%02d', $hrs*$sgn, $mins);

	//Массив с настройками, далее возможно будет меняться из БД
	$CONFIG['Root'] = $_SERVER['DOCUMENT_ROOT'];
	$CONFIG['Template'] = 'default';
	$CONFIG['Adminfolder'] = 'zn7admin';
	$CONFIG['Adminpassword'] = 'RhodiumAdminPanel';
	$CONFIG['Adminpasswordhash'] = md5('RhodiumAdminPanel');
	$CONFIG['Language'] = 'english';
	$CONFIG['Domain'] = 'http://192.168.56.10/';
	$CONFIG['DomainProtocol'] = 'http://';
	$CONFIG['Activation_link'] = $CONFIG['Domain'] . "activation";
	$CONFIG['DomainAutoDetect'] = $CONFIG['DomainProtocol'] . $_SERVER['HTTP_HOST'] . '/';
	$CONFIG['Salt'] = 'caravan';
	$CONFIG['Supportemail'] = 'support@zinc7.cc';
	$CONFIG['ReferalMaxLevel'] = 3;
	$CONFIG['VipFirstrefpercent'] = 0.07;
	$CONFIG['Firstrefpercent'] = 0.05;
	$CONFIG['Secondrefpercent'] = 0.02;
	$CONFIG['Thirdrefpercent'] = 0.01;
	$CONFIG['Fourthrefpercent'] = 0.01;
	$CONFIG['Fifthrefpercent'] = 0.01;
	$CONFIG['Sixthrefpercent'] = 0.005;
	$CONFIG['Seventhrefpercent'] = 0.002;
	$CONFIG['SystemIp'] = '185.48.236.66';
	$CONFIG['TotalSlots'] = array(1, 2, 3, 4, 5, 6, 7);
	$CONFIG['PaginationPages'] = 10;
	$CONFIG['PaginationOnPage'] = 100;
	$CONFIG['ExternalPages'] = array('login', 'signup', 'signup2', 'investment_plans', 'security', 'about', 'support', 'statistic', 'faq', 'forgot_password', 'main', 'news', 'rules', 'representatives', 'feedback', 'banned');
	$CONFIG['CurrentDate'] = date("d.m.y");
	$CONFIG['CurrentTime'] = strtoupper(date("M-d-Y H:i:s"));
	$CONFIG['CurrentTimeFooter'] = date("H:i:s");
	$CONFIG['AllowedIp'] = array('198.50.152.89', '108.162.216.242');
	$CONFIG['VisitorsDbFile'] = 'visitors.db';
	$CONFIG['VisitorsOnlineTime'] = '1000';
	$CONFIG['OnlineVisitors'] = countvisitors() + 213;
	$CONFIG['OnlineMembers'] = intval($CONFIG['OnlineVisitors'] * 0.2);
	$CONFIG['BlockedUsers'] = '1';
	//$CONFIG['NotAutoWithdraw'] = '1';
	$CONFIG['SecurityTime'] = 60;
	$CONFIG['AutoWithdraw'] = '1';
	$CONFIG['DaysOnline'] = date_diff(new DateTime(), new DateTime('2016-09-10 00:00:00'))->days;
	$CONFIG['Circles'] = floor($CONFIG['DaysOnline'] / 21);
	$CONFIG['FirstPlanPercent'] = 0.07;
	$CONFIG['FirstPlanDays'] = 22;
	$CONFIG['SecondPlanPercent'] = 1.1;
	$CONFIG['SecondPlanDays'] = 7;
	$CONFIG['certificateIdPrefix'] = 'Z716';
	$CONFIG['MAX_WITHDRAW_LIMIT'] = 300;

	$currentdate = new DateTime(date("Y-m-d H:i:s"));
	$currenthours = date("H");
	if ($currenthours < 12) {
		$nextpayment = new DateTime(date("Y-m-d 12:00:00"));
	}else{
		$nextpayment = new DateTime(date("Y-m-d 23:59:59"));
	}
	$interval = $currentdate->diff($nextpayment);
	$CONFIG['NextPaymentTime'] = $interval->format('%H:%i');

/*
	if (!in_array($_SERVER['REMOTE_ADDR'], $CONFIG['AllowedIp'])) {
		unset ($_SESSION['uid']);
		unset ($_SESSION['loggedinstatus']);
		echo "<center><h2>Only private members!</h2></center>";
		die();
	}
*/
	
	$CONFIG2 = getconfig();

	$CONFIG = array_merge($CONFIG, $CONFIG2);

	//инициализируем сессию
	session_start();

	

	

	
	// преобразовываем данные из POST и GET запросов в переменные
	foreach ($_REQUEST as $key => $value)
	{
		if (is_array($value)) {
			$tmp = array();
			foreach ($value as $k => $v) {
				$tmp[$k] = sanitize(htmlspecialchars(mysqli_real_escape_string($link, $v)));
			}
			$$key = $tmp;
		}else{
			$$key = sanitize(htmlspecialchars(mysqli_real_escape_string($link, $value)));
		}
	}

	//подключаем языковой файл
	if(isset($lang)){
		$language = $lang;
		$_SESSION['lang'] = $lang;
		setcookie('lang', $lang, time() + (3600 * 24 * 30));
		header("Location:" . $CONFIG['Domain'] . substr($_SERVER['REDIRECT_URL'], 1));
	}elseif(isset($_SESSION['lang'])){
		$language = $_SESSION['lang'];
	}elseif(isset($_COOKIE['lang'])){
		$language = $_COOKIE['lang'];
	}else{
		$language = $CONFIG['Language'];
	}

	//$language = $CONFIG['Language'];
	if (file_exists('lang/' . $language . '.php')) {
		require_once 'lang/' . $language . '.php';
	}else{
		require_once 'lang/english.php';
	}
	
	// вот тут будут наши "контроллеры"
	$controller = array();
 
	if (isset($_SERVER['REQUEST_URI'])) {
		// получили строку
		$query_string = trim($_SERVER['REQUEST_URI']);
		if (strpos($query_string, $CONFIG['Adminfolder'])) {
            $query_string = substr($query_string, strlen($CONFIG['Adminfolder']) + 2); 
        }
        if (strpos($query_string, '?')) {
        	$query_string = explode('?', $query_string);
        	$query_string = $query_string['0'];
        }
	}else $query_string = '';

	// на всякий случай декодируем
	$query_string = urldecode($query_string);
	 
	// разбиваем на массив
	$query_controller = explode("/", $query_string); 
	 
	// и проверяем 
	// а вдруг в конец слеш не дописали?
	// да и почистим сразу от SQL-инъекций
	foreach ($query_controller as $query_param)
	if ($query_param != ""){
		$controller[] = sanitize(htmlspecialchars(mysqli_real_escape_string($link, $query_param)));		
	}

	// проверяем все ли вызываемые контроллеры присутвуют в папке, если нет - перенаправляем на 404
	if (!empty($controller)) {
		if (nocontroller($controller)) {
			unset($controller);
			$controller[] = '404';
		}
	}

	// если не передан никакой контроллер, подключаем основной
	if (empty($controller)) {
		$controller[] = 'main';
	}

	$newslist = getlistnews(2);

?>
