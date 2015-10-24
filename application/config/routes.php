<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	http://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/
$route['default_controller'] = 'home';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;
$route['clang/(:any)'] = 'home/change_lang/$1';
$route['(:any)/index'] = function ($conf_id){
	if( in_array($conf_id,array("user","sysop")) ){
		return $conf_id."/index/";
	}else{
		return 'home/index/'.$conf_id;
	}
};
$route['(:any)/news'] = 'home/news/$1';
$route['(:any)/main'] = 'home/main/$1';
$route['debug'] = 'home/debug';
$route['(:any)/dashboard'] = 'dashboard/index/$1';
$route['(:any)/dashboard/(:any)'] = 'dashboard/$2/$1';
$route['(:any)/dashboard/(:any)/(:any)'] = 'dashboard/$2/$1/$3';
$route['(:any)/dashboard/(:any)/(:any)/(:any)'] = 'dashboard/$2/$1/$3/$4';

$route['(:any)/submit'] = 'submit/index/$1';
$route['(:any)/submit/(:any)'] = 'submit/$2/$1';
$route['(:any)/submit/(:any)/(:any)'] = 'submit/$2/$1/$3';

$route['(:any)/topic/(:any)'] = 'topic/$2/$1';
$route['(:any)/topic/(:any)/(:any)'] = 'topic/$2/$1/$3';

$route['(:any)/reviewer/(:any)'] = 'reviewer/$2/$1';
$route['(:any)/reviewer/(:any)/(:any)'] = 'reviewer/$2/$1/$3';

$route['(:any)/about/(:any)'] = 'home/about/$1/$2';