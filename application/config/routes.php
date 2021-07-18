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

//search
$route['recherche'] = 'search/search';
$route['rechercheAvancee'] = 'search/searchAvancee';

$route['podcasts/create/(:num)'] = 'podcasts/createWaitingValidation/$1';
$route['episodes/create/(:num)'] = 'episodes/create/$1';
$route['episodes/edit/(:num)'] = 'episodes/edit/$1';
$route['episodes/validate/(:num)'] = 'episodes/validate/$1';
$route['episodes/stats/listen/(:num)'] = 'episodes/statsListen/$1';

//hosted medias
$route['badgeek/uploads/podcasts/(:num)/(:any)'] = 'podcasts/mp3/$1/$2';

//user
$route['preferences'] = 'user/index';

//Admin articles
$route['admin/articles'] = 'admin_articles/index';
$route['admin/articles/(:any)'] = 'admin_articles/$1';
$route['admin/articles/(:any)/(:any)'] = 'admin_articles/$1/$2';

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
$route['admin/users/unvalidate/(:num)'] = 'admin_users/unvalidate/$1';

//Admin aides
$route['admin/aides'] = 'admin_aide/index';
$route['admin/aides/add'] = 'admin_aide/add';
$route['admin/aides/edit/(:num)'] = 'admin_aide/edit/$1';
$route['admin/aides/delete/(:num)'] = 'admin_aide/delete/$1';

//aides
$route['aide'] = 'Aide/index';

//Migrations
$route['devtools'] = 'DevTools/index';
$route['devtools/check'] = 'DevTools/check';
$route['devtools/dump'] = 'DevTools/dump';
$route['devtools/raz'] = 'DevTools/raz';
$route['devtools/importdump/(:any)'] = 'DevTools/importdump/$1';
$route['devtools/forcedownload/(:any)'] = 'DevTools/forcedownload/$1';
$route['devtools/deletedump/(:any)'] = 'DevTools/deletedump/$1';
$route['devtools/migration/(:any)/(:any)'] = 'DevTools/migration/$1/$2';
$route['devtools/greatreset'] = 'DevTools/greatreset';

//User uploads
$route['myuploads'] = 'UserUploads/index';
$route['myuploads/file_upload'] = 'UserUploads/upload';
$route['myuploads/file_upload_no_flashdata'] = 'UserUploads/upload_no_flashdata';
$route['myuploads/delete'] = 'UserUploads/delete';
