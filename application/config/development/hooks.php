<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
| -------------------------------------------------------------------------
| Hooks
| -------------------------------------------------------------------------
| This file lets you define "hooks" to extend CI without hacking the core
| files.  Please see the user guide for info:
|
|	http://codeigniter.com/user_guide/general/hooks.html
|
*/

/*
$hook['pre_controller'] = array(
                                  'class'    => 'HookClass',
                                  'function' => 'hookPreController',
                                  'filename' => 'HookClass.php',
                                  'filepath' => 'hooks',
                                  'params'   => array('beer', 'wine', 'snacks')
                               ); 
 */

$hook['post_controller_constructor'] = array(
                                  'class'    => 'HookClass',
                                  'function' => 'hookPostControllerConstructor',
                                  'filename' => 'HookClass.php',
                                  'filepath' => 'hooks'
                               ); 


/* End of file hooks.php */
/* Location: ./application/config/development/hooks.php */
