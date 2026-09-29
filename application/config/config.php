<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| Base Site URL
|--------------------------------------------------------------------------
| Auto-detect the base URL dynamically so the app works seamlessly in any
| local server, subdirectory (e.g. XAMPP/WAMP/LAMP/Docker), or domain.
*/
$root = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http");
$root .= "://" . (isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : 'localhost');
$root .= str_replace(basename($_SERVER['SCRIPT_NAME']), "", $_SERVER['SCRIPT_NAME']);
$config['base_url'] = rtrim($root, '/') . '/';

/*
|--------------------------------------------------------------------------
| Index File
|--------------------------------------------------------------------------
| Blank because mod_rewrite / .htaccess handles cleaner URLs.
*/
$config['index_page'] = '';

$config['uri_protocol'] = 'REQUEST_URI';
$config['url_suffix'] = '';
$config['language']	= 'english';
$config['charset'] = 'UTF-8';
$config['enable_hooks'] = FALSE;
$config['subclass_prefix'] = 'MY_';
$config['composer_autoload'] = FALSE;
$config['permitted_uri_chars'] = 'a-z 0-9~%.:_\-';

$config['allow_get_array'] = TRUE;
$config['enable_query_strings'] = FALSE;
$config['controller_trigger'] = 'c';
$config['function_trigger'] = 'm';
$config['directory_trigger'] = 'd';

$config['log_threshold'] = 1;
$config['log_path'] = '';
$config['log_file_extension'] = '';
$config['log_file_permissions'] = 0644;
$config['log_date_format'] = 'Y-m-d H:i:s';

$config['error_views_path'] = '';
$config['cache_path'] = '';
$config['cache_query_string'] = FALSE;

$config['encryption_key'] = 'LogHardwareSaharaSecretKey2026!#99';

/*
|--------------------------------------------------------------------------
| Session Variables
|--------------------------------------------------------------------------
*/
$config['sess_driver'] = 'files';
$config['sess_cookie_name'] = 'loghw_session';
$config['sess_expiration'] = 7200;
$config['sess_save_path'] = sys_get_temp_dir();
$config['sess_match_ip'] = FALSE;
$config['sess_time_to_update'] = 300;
$config['sess_regenerate_destroy'] = FALSE;

$config['cookie_prefix']	= '';
$config['cookie_domain']	= '';
$config['cookie_path']		= '/';
$config['cookie_secure']	= FALSE;
$config['cookie_httponly'] 	= FALSE;

$config['standardize_newlines'] = FALSE;
$config['global_xss_filtering'] = FALSE;

/*
|--------------------------------------------------------------------------
| Cross Site Request Forgery (CSRF) Protection
|--------------------------------------------------------------------------
*/
$config['csrf_protection'] = TRUE;
$config['csrf_token_name'] = 'csrf_test_name';
$config['csrf_cookie_name'] = 'csrf_cookie_name';
$config['csrf_expire'] = 7200;
$config['csrf_regenerate'] = FALSE;
$config['csrf_exclude_uris'] = array('api/.*');

$config['compress_output'] = FALSE;
$config['time_reference'] = 'local';
$config['rewrite_short_tags'] = FALSE;
$config['proxy_ips'] = '';
