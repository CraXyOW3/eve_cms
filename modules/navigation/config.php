<?php
/*
#module_name,Menu
#module_description,Core Navigation!
#module_req,4
#module_id,2
*/
$self=$_GET['module'];
$module_public='./?module=';
$module_admin='./?module=admin&part=navigation';
$module_data='./?module=data&part=navigation';

$array= array('Admin'=>
array(array('link'=>'admin&part=navigation','name'=>'Navigation Admin'))
);
?>