<?php
defined('BASEPATH') OR exit('No direct script access allowed');
// Store your secret key here
// Make sure you use better, long, more random key than this
$config['jwt_key'] = 'MY_SECRET_KEY';
/*
|-----------------------
| Token Request Header Name
|--------------------------------------------------------------------------
*/
$config['token_header'] = 'authorization';


/*
|-----------------------
| Token Expire Time
| https://www.tools4noobs.com/online_tools/hh_mm_ss_to_seconds/
|--------------------------------------------------------------------------
| ( 1 Day ) : 60 * 60 * 24 = 86400
| ( 1 Hour ) : 60 * 60     = 3600
| ( 1 Minute ) : 60        = 60
*/
$config['token_expire_time'] = 60;