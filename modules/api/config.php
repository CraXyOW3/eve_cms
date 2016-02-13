<?php
/*
#module_name,API
#module_description,API handler for site!
#module_req,2
#module_id,8
*/
$self=$_GET['module'];
//$module_public='./?module=api';
$module_admin='./?module=admin&part=api';
$module_data='./?module=data&part=api';

$array= array('Admin'=>
array(array('link'=>'admin&part=api','name'=>'API Admin')),
'Public'=>
array()
);
?>