<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
*/
$route['default_controller'] = 'Home';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;

// Frontend Routes
$route['products'] = 'Products/index';
$route['products/filter'] = 'Products/filter_ajax';
$route['products/category/(:any)'] = 'Products/category/$1';
$route['products/(:num)'] = 'Products/detail/$1';
$route['inquire'] = 'Products/inquire';

// Admin Auth Routes
$route['admin'] = 'Admin/Dashboard/index';
$route['admin/login'] = 'Admin/Auth/login';
$route['admin/logout'] = 'Admin/Auth/logout';

// Admin Dashboard & Management Routes
$route['admin/dashboard'] = 'Admin/Dashboard/index';
$route['admin/products'] = 'Admin/Products/index';
$route['admin/products/add'] = 'Admin/Products/add';
$route['admin/products/edit/(:num)'] = 'Admin/Products/edit/$1';
$route['admin/products/delete/(:num)'] = 'Admin/Products/delete/$1';
$route['admin/products/toggle_status/(:num)'] = 'Admin/Products/toggle_status/$1';
$route['admin/categories'] = 'Admin/Categories/index';
$route['admin/inquiries'] = 'Admin/Inquiries/index';
$route['admin/inquiries/update_status/(:num)'] = 'Admin/Inquiries/update_status/$1';
