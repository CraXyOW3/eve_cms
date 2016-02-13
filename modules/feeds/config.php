<?php
/*
#module_name,News Feeds
#module_description,Feed catcher for EVE Online.
#module_req,2
#module_id,8
*/
$self=$_GET['module'];
$module_public='./?module=feeds';
$module_admin='./?module=admin&part=feeds';
$module_data='./?module=data&part=feeds';

$array= array('Admin'=>
array(array('link'=>'admin&part=feeds','name'=>'Feeds Admin')),
'Public'=>
array(array('link'=>'feeds','name'=>'Feeds'))
);
?>