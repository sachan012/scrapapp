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
$route['default_controller'] = 'Authentication/login';   // login page
$route['dashboard'] = 'Dashboard';   // dashboard page after success login
$route['logout'] = 'Authentication/logout';  // logout link

$route['profile'] = 'Authentication/profile';  //change password
$route['change-password'] = 'Authentication/change_password';  //change password

$route['admin-setting'] = 'Setting/admin_setting';  //change password

$route['forget-password'] = 'Authentication/forgetPassword';  // forget password link

$route['forgot-password-link/(:any)/(:any)'] = 'Authentication/forgetPasswordlink/$1/$2';  // forget password reset


/*-----------------Auction Routes------------------*/
$route['create-auction'] = 'auction/create';
$route['edit-auction/(:any)'] = 'auction/edit/$1';
$route['view-auction/(:any)'] = 'auction/view/$1';
$route['view-bids/(:any)'] = 'auction/bids/$1';


//$route['sendemail'] = 'sendmail/sendBackgroundEmail';


$route['view-approval/(:any)'] = 'auction/approval/$1';

/*-----------------Staff Routes------------------*/
$route['view-staff/(:any)'] = 'staff/view/$1';
$route['edit-staff/(:any)'] = 'staff/edit/$1';
$route['add-staff'] = 'staff/add';


//customers
/*------------------users Routes ---------------------*/
$route['user-approve/(:any)/(:any)'] = 'users/approve/$1/$2'; 
$route['user-active/(:any)/(:any)'] = 'users/active/$1/$2';
$route['view-user/(:any)'] = 'users/view/$1';




$route['add-entery'] = 'Staffentery/add';
$route['edit-entry/(:any)'] = 'Staffentery/edit/$1'; 


$route['leads'] = 'leads';  
$route['suppliers'] = 'suppliers';  
$route['invoices'] = 'invoice';  

//excel upload

$route['customers-excel-upload'] = 'Customers/upload_customer_excel';  
$route['customers-list/(:any)'] = 'Customers/$1'; 

/*quote type work*/
$route['quotes'] = 'quotes';  
$route['quote-add'] = 'quotes/add';
$route['quote-edit/(:any)'] = 'quotes/edit/$1'; 
$route['quote-delete/(:any)'] = 'quotes/delete/$1'; 


/*supplier users*/
$route['supplier-list/(:any)'] = 'Suppliers/$1';  
$route['supplier-add'] = 'Suppliers/add';  
$route['supplier-edit/(:any)'] = 'Suppliers/edit/$1';   
$route['supplier-view/(:any)'] = 'Suppliers/view/$1';
$route['supplier-delete/(:any)'] = 'Suppliers/delete/$1'; 


/*supplier category*/
$route['supplier-category/(:any)'] = 'Supplierscategory/category/$1';  
$route['supplier-category-add'] = 'Supplierscategory/add';  
$route['supplier-category-edit/(:any)'] = 'Supplierscategory/edit/$1';   
$route['supplier-category-view/(:any)'] = 'Supplierscategory/view/$1';
$route['supplier-category-delete/(:any)'] = 'Supplierscategory/delete/$1'; 


 
/*leads*/
$route['leads-list/(:any)'] = 'Leads/$1';  
$route['leads-add'] = 'Leads/add';  
$route['leads-edit/(:any)'] = 'Leads/edit/$1';   
$route['leads-view/(:any)'] = 'Leads/view/$1';
$route['leads-delete/(:any)'] = 'Leads/delete/$1'; 
 

/*quote work*/
$route['quote'] = 'quote';  
$route['quote-view/(:any)'] = 'Quote/view/$1'; 
$route['quote-reply/(:any)'] = 'Quote/reply/$1'; 

/*Prroject work*/
$route['project-view/(:any)'] = 'projects/view/$1'; 

/*Diary work*/
$route['diary-view/(:any)'] = 'diary/view/$1'; 

/*Orders work*/
$route['orders/(:any)'] = 'Orders/$1'; 
$route['orders-view/(:any)'] = 'Orders/view/$1'; 
$route['orders-delete/(:any)'] = 'Orders/delete/$1';



/*Measurement units*/
$route['unit-list/(:any)'] = 'Measurementunit/$1';  
$route['unit-add'] = 'Measurementunit/add';  
$route['unit-edit/(:any)'] = 'Measurementunit/edit/$1';   
$route['unit-view/(:any)'] = 'Measurementunit/view/$1';
$route['unit-delete/(:any)'] = 'Measurementunit/delete/$1';   

$route['404_override'] = 'Error_404';
$route['translate_uri_dashes'] = FALSE;


//Events--------------------------------------

$route['event-view/(:any)'] = 'Events/view/$1'; 
$route['add-event'] = 'Events/add'; 
$route['event-add'] = 'Events/add'; 

$route['add-artist/(:any)'] = 'Events/addartist/$1';   

$route['artist-delete/(:any)/(:any)'] = 'Events/artistdelete/$1/$2';  
$route['add-ticket-price/(:any)'] = 'Events/eventtickets/$1';  

$route['ticket-delete/(:any)/(:any)'] = 'Events/ticketdelete/$1/$2'; 











