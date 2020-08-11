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
$route['auth'] = 'auth';
$route['default_controller'] = 'badgeek/index';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;
$route['podcasts/create/(:num)'] = 'podcasts/createWaitingValidation/$1';
$route['episodes/create/(:num)'] = 'episodes/create/$1';
$route['episodes/edit/(:num)'] = 'episodes/edit/$1';
$route['episodes/validate/(:num)'] = 'episodes/validate/$1';
$route['medias/podcast/(:num)'] = 'medias/podcast/$1';
$route['medias/episode/(:num)'] = 'medias/episode/$1';
$route['medias/search/(:any)'] = 'medias/search/$1';

//hosted medias
$route['badgeek/uploads/podcasts/(:num)/(:any)'] = 'medias/mp3/$1/$2';

//Admin articles
$route['admin/articles'] = 'admin_articles/index';
$route['admin/articles/(:any)'] = 'admin_articles/$1';
$route['admin/articles/add/(:num)'] = 'admin_articles/add/$1';
$route['admin/articles/edit/(:num)'] = 'admin_articles/edit/$1';
$route['admin/articles/delete/(:num)'] = 'admin_articles/delete/$1';

//Admin podcasts
$route['admin/podcasts'] = 'admin_podcasts';
$route['admin/podcasts/validate/(:num)'] = 'admin_podcasts/validate/$1';
$route['admin/podcasts/delete/(:num)'] = 'admin_podcasts/delete/$1';
$route['admin/podcasts/view/(:num)'] = 'admin_podcasts/view/$1';
$route['admin/podcasts/refuse/(:num)'] = 'admin_podcasts/refuse/$1';
$route['admin/podcasts/waiting/(:num)'] = 'admin_podcasts/rewaiting/$1';

//Admin users
$route['admin/users'] = 'admin_users/index';
$route['admin/users/edit/(:num)'] = 'admin_users/edit/$1';
$route['admin/users/activate/(:num)'] = 'admin_users/activate/$1';
$route['admin/users/deactivate/(:num)'] = 'admin_users/deactivate/$1';

//Admin lives
$route['admin/lives'] = 'admin_lives/index';
$route['admin/lives/view/(:num)'] = 'admin_lives/view/$1';
$route['admin/lives/refuse/(:num)'] = 'admin_lives/refuse/$1';
$route['admin/lives/accept/(:num)'] = 'admin_lives/accept/$1';
