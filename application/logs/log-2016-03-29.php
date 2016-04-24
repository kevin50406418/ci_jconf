<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

ERROR - 2016-03-29 00:23:24 --> Severity: Notice --> Undefined variable: signup_id /home/jingxun/public_html/app/models/Signup_model.php 279
ERROR - 2016-03-29 00:39:42 --> Severity: Notice --> Undefined variable: signup_info /home/jingxun/public_html/app/controllers/Dashboard.php 201
ERROR - 2016-03-29 00:40:29 --> Severity: Notice --> Undefined variable: signup_info /home/jingxun/public_html/app/controllers/Dashboard.php 202
ERROR - 2016-03-29 00:40:42 --> Severity: Notice --> Undefined variable: signup_info /home/jingxun/public_html/app/controllers/Dashboard.php 202
ERROR - 2016-03-29 00:43:37 --> Severity: error --> Exception: syntax error, unexpected ')' /home/jingxun/public_html/app/models/Conf_model.php 1634
ERROR - 2016-03-29 11:49:12 --> Severity: Notice --> Undefined index: test2015_cnws/t /home/jingxun/public_html/app/views/conf/report/index.php 28
ERROR - 2016-03-29 11:49:12 --> Severity: Warning --> array_sum() expects parameter 1 to be array, null given /home/jingxun/public_html/app/views/conf/report/index.php 28
ERROR - 2016-03-29 11:53:22 --> Severity: Notice --> Undefined index: test2015_cnws/t /home/jingxun/public_html/app/views/conf/report/index.php 31
ERROR - 2016-03-29 11:53:22 --> Severity: error --> Exception: Argument 2 passed to element() must be of the type array, null given, called in /home/jingxun/public_html/app/views/conf/report/index.php on line 31 /home/jingxun/public_html/sys/helpers/array_helper.php 65
ERROR - 2016-03-29 11:54:15 --> Severity: error --> Exception: syntax error, unexpected ';' /home/jingxun/public_html/app/views/conf/report/index.php 46
ERROR - 2016-03-29 22:23:13 --> Query error: Unknown column 'user_login' in 'where clause' - Invalid query: SELECT COUNT(*) AS `numrows`
FROM `paper`
WHERE `user_login` = 'jingxun'
AND `sub_id` = '100'
AND `sub_status` IN(-1, 0)
