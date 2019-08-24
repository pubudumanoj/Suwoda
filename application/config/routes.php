<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
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
| There area two reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router what URI segments to use if those provided
| in the URL cannot be matched to a valid route.
|
*/

$route['default_controller'] = "site"; // when run the index.php, it is automatically call this site.php file in the controllers folder
//$route['(:any)'] = 'site/index/$1';
$route['site/(:any)'] = 'site/index/$1';
$route['login'] = 'registration/login_control/index';
$route['register'] = 'registration/register_control/index';

/*
 * Diseases
 */
$route['disease/add_disease_control/validate_information'] = 'disease/add_disease_control/validate_information';
$route['disease/disease_edit_control/validate_information'] = 'disease/disease_edit_control/validate_information';
$route['disease'] = 'disease/disease_control/index';
$route['disease/(:any)/(:any)/(:any)/(:any)/(:any)'] = 'disease/disease_control/select_view_next/$1/$2/$3/$4/$5';
$route['disease/(:any)'] = 'disease/disease_page_control/index/$1';
$route['disease_page/(:any)/del'] = 'disease/disease_page_control/delete/$1';
$route['disease_edit/(:any)'] = 'disease/disease_edit_control/index/$1';
$route['disease/select_view'] = 'disease/disease_control/select_view'; // when user click on the search button this method will call
$route['disease/new_comment'] = 'disease/disease_page_control/add_new_comment';
$route['add_disease'] = 'disease/add_disease_control/index';


$route['diagnosis'] = 'diagnosis/diagnosis_control/index';
$route['settings'] = 'registration/register_control/index';
$route['edit'] = 'registration/edit_control/index';
$route['email'] = 'registration/email_control/index';
$route['backup'] = 'backups/backup_control/index';
$route['registration/email_control/validate_information'] = 'registration/email_control/validate_information';


/*
 * Medical Information
 */
$route['information'] = 'information/information_control/index';
$route['information/information_control/validate_Information'] = 'information/information_control/validate_information2';
$route['information/information_edit_control/validate_information'] = 'information/information_edit_control/validate_information';
$route['information/select_view'] = 'information/information_control/select_view'; // when user click on the search button this method will call
$route['information/(:any)/(:any)/(:any)/(:any)/(:any)'] = 'information/information_control/select_view_next/$1/$2/$3/$4/$5'; // next of the information table will change the offset and current offset and pass them in to the select_view_next method
$route['information/rev/(:any)'] = 'information/information_control/index/rev/$1';
$route['information/unr/(:any)'] = 'information/information_control/index/unr/$1';
//$route['information/(:any)/(:any)'] = 'information/information_page_control/index/$1/$1';
$route['information_page/(:any)/(:any)'] = 'information/information_page_control/index/$1/$2';
$route['information_edit/(:any)'] = 'information/information_edit_control/index/$1/'; // after edit complete redirect to the edited information page
$route['information/(:any)'] = 'information/information_page_control/index/$1';

/*
 * Herbal Plants
 */
$route['add_plant'] = 'herbal/add_plant_control/index';
$route['plant'] = 'herbal/plant_control/index';
$route['plant/(:any)'] = 'herbal/plant_page_control/index/$1';
$route['plant_page/(:any)/del'] = 'herbal/plant_page_control/delete/$1';
$route['plant/select_view'] = 'herbal/plant_control/select_view';
$route['plant/(:any)/(:any)/(:any)/(:any)/(:any)'] = 'plant/plant_control/select_view_next/$1/$2/$3/$4/$5';
$route['plant_edit/(:any)'] = 'herbal/plant_edit_control/index/$1';


/*
 * Reports
 */
$route['reports/disease'] = 'reports/disease_report_control/index';
$route['reports/plant'] = 'reports/plant_report_control/index';
$route['reports/user'] = 'reports/user_report_control/index';

/*
 * Medical Center
 */
$route['medical'] = 'medical/medical_center_control/index';
$route['medical/select_view'] = 'medical/medical_center_control/select_view';
$route['add_center'] = 'medical/add_medical_center_control/index';
$route['allocate_me'] = 'medical/allocate_center_control/index';
$route['medical/(:any)/(:any)/(:any)/(:any)'] = 'medical/medical_control/select_view_next/$1/$2/$3/$4';
$route['medical/(:any)'] = 'medical/medical_page_control/index/$1';
$route['center_page/(:any)/del'] = 'medical/medical_page_control/delete/$1';
$route['medical/medical_center_edit_control/validate_Information'] = 'medical/medical_center_edit_control/validate_Information';
$route['center_edit/(:any)'] = 'medical/medical_center_edit_control/index/$1';


$route['physician'] = 'medical/physician_control/index';
$route['medical/physician_control/select_view'] = 'medical/physician_control/select_view';


$route['booking_setup'] = 'booking/booking_setup_control/index';
$route['booking/(:any)'] = 'booking/booking_control/index/$1';
$route['print_voucher/(:any)/(:any)'] = 'booking/voucher_control/index/$1/$2';
$route['booking/print_voucher_control/validate_information'] = 'booking/print_voucher_control/validate_information';


$route['404_override'] = '';


/* End of file routes.php */
/* Location: ./application/config/routes.php */