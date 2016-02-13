<?php
/*
#module_name,Member Settings
#module_description,Settings for individual members!
#module_req,4
#module_id,11
*/
$self=$_GET['module'];
$module_public='./?module=member_settings';
$module_admin='./?module=admin&part=member_settings';
$module_data='./?module=data&part=member_settings';

$array= array('Admin'=>
array(),
'Public'=>
array()
);
?>