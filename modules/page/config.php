<?php
/*
#module_name,Custom Pages
#module_description,Custom Pages!
#module_req,4
#module_id,34
*/
//$self=$_GET['module'];
$module_public='./?module=';
$module_admin='./?module=admin&part=page';
$module_data='./?module=data&part=page';

$array= array('Admin'=>
array(array('link'=>'admin&part=page','name'=>'Page Admin')),
'Public'=>
array()
);
?>