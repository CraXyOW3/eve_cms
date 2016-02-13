<?php
/*
#module_name,Killboard
#module_description,Mini Killboard. Autofetch from API (requires CRON/Fitting Module & EVEDB pack)!
#module_req,2
#module_id,20
*/
$self=$_GET['module'];
$module_public='./?module=logreader';
$module_admin='./?module=admin&part=logreader';
$module_data='./?module=data&part=logreader';

$array= array('Admin'=>
array(array('link'=>'logreader','name'=>'Logreader')),
'Public'=>
array()
);
?>