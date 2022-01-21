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
|	https://codeigniter.com/user_guide/general/routing.html
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
$route['default_controller'] = 'welcome';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;


//Route for API

//files
$route['v1/files/put'] = 'v1/ControllerFile/put';
$route['v1/files/get'] = 'v1/ControllerFile/get';
$route['v1/files/delete'] = 'v1/ControllerFile/delete';
$route['v1/files/move'] = 'v1/ControllerFile/move';

//elements
$route['v1/elements/rename'] = 'v1/ControllerElement/rename';
$route['v1/files/rename'] = 'v1/ControllerFile/rename';
$route['v1/dirs/rename'] = 'v1/ControllerDirectory/rename';

//directory
$route['v1/dirs/mkdir'] = 'v1/ControllerDirectory/mkdir';
$route['v1/dirs/rmdir'] = 'v1/ControllerDirectory/rmdir';
$route['v1/dirs/ls'] = 'v1/ControllerDirectory/ls';
$route['v1/dirs/lsl'] = 'v1/ControllerDirectory/lsl';
$route['v1/dirs/pwd'] = 'v1/ControllerDirectory/pwd';

