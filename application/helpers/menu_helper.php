<?php if(!defined('BASEPATH')) exit('No direct script access allowed');
if(!function_exists('active_link')) {
  function activate_menu($controller) {
    // Getting CI class instance.
    $CI = get_instance();
    // Getting router class to active.
    $class = $CI->router->fetch_class();
    return ($class == $controller) ? 'active' : '';
  }
  
  function menu_icon($module_id)
  {
	  $menu_icon = array('customers'=>'fa-users','employees'=>'fa-user','items'=>'fa-gift','receivings'=>'fa-truck','reports'=>'fa-bar-chart-o','sales'=>'fa-shopping-cart','config'=>'fa-gears','suppliers'=>'fa-cab');
	  //if(in_array($module_id,$menu_icon))
	  	return ($menu_icon[$module_id]);
  }
}?>