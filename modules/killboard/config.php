<?php
/*
#module_name,Killboard
#module_description,Mini Killboard. Autofetch from API (requires CRON/Fitting Module & EVEDB pack)!
#module_req,2
#module_id,20
*/
$self=$_GET['module'];
$module_public='./?module=killboard';
$module_admin='./?module=admin&part=killboard';
$module_data='./?module=data&part=killboard';

$array= array('Admin'=>
array(),
'Public'=>
array(array('link'=>'killboard','name'=>'Killboard'))
);
?>