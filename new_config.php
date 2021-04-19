<?php 
	/** 
	* Database Constants - these constants refer to 
	* the database configuration settings. 
	*/
	 define('DB_HOST', 'localhost'); 
	 define('DB_USER', 'root'); 
	 define('DB_PASS', ''); 
	 define('DB_NAME', 'ft_account');
	 define('DB_DRIVER', 'mysql');
	 
	 define('MAIL_TRANSPORT', 'mail.futuretecsol.com');
	 define('HD_NAME', 'FTSPL Helpdesk');
	 define('HD_MAIL_ID', 'helpdesk@futuretecsol.com');
	 define('HD_MAIL_PWD', 'fT@HedsK#2021');

	 define('FXD_EMAIL_IDS', ['deepaksingh@futuretecsol.com']);
	 
	 
	 define('STATUS', array(1 => 'Sent to FTSPL', 'In Process', 'Customer Action', 'Close', 'Dim Close'));
	 define('PRIORITY', array(1 => 'Low', 2 => 'Medium', 3 => 'High', 4 => 'Very High'));
	 define('INSTANCE', array(1 => 'DEV', 2 => 'QAS', 3 => 'PRD'));
	 
	 
	 define('HOST',  "http://localhost:8888");
	 
	 
	 
?>