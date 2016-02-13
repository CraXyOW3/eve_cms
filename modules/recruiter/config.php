<?php
/*
#module_name,Recruiter
#module_description,Check Skills for recruitment.
#module_req,4
#module_id,30
*/
$self=$_GET['module'];
//$module_public='./?module=recruiter';
$module_admin='./?module=admin&part=recruiter';
$module_data='./?module=data&part=recruiter';

$array= array('Admin'=>
array(array('link'=>'admin&part=recruiter','name'=>'Recruiter'))
);
?>