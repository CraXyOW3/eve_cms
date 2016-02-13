<?php
/*
#module_name,Settings
#module_description,Core Settings!
#module_req,3
#module_id,3
*/
$self=$_GET['module'];
$module_public='./?module=';
$module_admin='./?module=admin&part=settings';
$module_data='./?module=data&part=settings';

$array= array('Admin'=>
array(array('link'=>'admin&part=settings','name'=>'Settings'))
);
?>