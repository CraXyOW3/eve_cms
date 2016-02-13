<?php
/*
#module_name,Admin
#module_description,Administrative Core
#module_req,1
#module_id,2
*/
$self=$_GET['module'];
$module_public='./?module=admin';
$module_admin='./?module=admin';
$module_data='./?module=data&part=admin';

$array= array('Admin'=>
array(),
'Public'=>
array()
);
?>