<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

ERROR - 2016-03-24 23:50:05 --> Query error: Table 'dev_jconf.sign_type' doesn't exist - Invalid query: SELECT *
FROM `signup_price`
JOIN `sign_type` ON `signup_price`.`type_id` = `sign_type`.`type_id`
WHERE `signup_price`.`conf_id` = 'test2015'
AND `signup_price`.`early_bird` = 1
