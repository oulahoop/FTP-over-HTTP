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


//V2
//Files
$route['v2/files'] = 'v2/ControllerFileV2/index';
$route['v2/files/put'] = 'v2/ControllerFileV2/put';
$route['v2/files/get'] = 'v2/ControllerFileV2/get';
$route['v2/files/delete'] = 'v2/ControllerFileV2/delete';
$route['v2/files/move'] = 'v2/ControllerFileV2/move';

//elements
$route['v2/elements/rename'] = 'v2/ControllerElementV2/rename';
$route['v2/files/rename'] = 'v2/ControllerFileV2/rename';
$route['v2/dirs/rename'] = 'v2/ControllerDirectoryV2/rename';

//directory
$route['v2/dirs'] = 'v2/ControllerDirectoryV2/index';
$route['v2/dirs/mkdir'] = 'v2/ControllerDirectoryV2/mkdir';
$route['v2/dirs/rmdir'] = 'v2/ControllerDirectoryV2/rmdir';
$route['v2/dirs/ls'] = 'v2/ControllerDirectoryV2/ls';
$route['v2/dirs/lsl'] = 'v2/ControllerDirectoryV2/lsl';
$route['v2/dirs/pwd'] = 'v2/ControllerDirectoryV2/pwd';

