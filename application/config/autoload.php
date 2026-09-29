<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------
| AUTO-LOADER
| -------------------------------------------------------------------
*/

$autoload['packages'] = array();

$autoload['libraries'] = array('database', 'session', 'form_validation', 'pagination');

$autoload['drivers'] = array();

$autoload['helper'] = array('url', 'file', 'form', 'html', 'security', 'text');

$autoload['config'] = array();

$autoload['language'] = array();

$autoload['model'] = array('Product_model', 'Category_model', 'Admin_model', 'Inquiry_model');
