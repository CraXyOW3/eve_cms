<?php
if(isset($_GET['s'])){
	if($_GET['s'] == 'group'){
		$group_name = $_POST['grp_name'];
		mysql_query("INSERT INTO comp_grp (comp_grp_name) VALUES ('$group_name')");
		$_SESSION['text'] = 'Competence Group Added!';
		$_SESSION['type'] = 'success';
		if ($logFile) {logToFile('Competence','Group Added',$group_name);} // Logger
		redirect('./?module=admin&part=competence&do=grp'); exit();
	}elseif($_GET['s'] == 'groupupd'){
		$group_name = mysql_escape_string($_POST['grp_name']);
		$group_id = mysql_escape_string($_POST['grp_id']);
		mysql_query("UPDATE comp_grp SET comp_grp_name='$group_name' WHERE comp_grp_id='$group_id'");
		//echo 'name='.$group_name.' groupid='.$group_id;
		//echo './?module=admin&part=competence&do=grp&a=edit&id='.$group_id;
		$_SESSION['text'] = 'Competence Group Edited!';
		$_SESSION['type'] = 'success';
		if ($logFile) {logToFile('Competence','Group Edited',$group_name);} // Logger
		redirect('./?module=admin&part=competence&do=grp&a=edit&id='.$group_id); exit();
	}elseif($_GET['s'] == 'skill'){
		$c_grp = mysql_escape_string($_POST['id']);
		$c_gid = mysql_escape_string($_POST['gid']);
		$c_skill = mysql_escape_string($_POST['c_skill']);
		$c_lvl = mysql_escape_string($_POST['c_lvl']);
		
		$check = good_query_assoc("SELECT * FROM comp_table WHERE comp_id=$c_grp AND skill_id=$c_skill");
		echo $check['skill_id'] .'-'.$check['skill_lvl'];
			if($check){
				//if already exists check if duplicate or update.
				if($check['skill_lvl']==$c_lvl){
					//duplicate so go back.
					//echo'we do nothing!';
					$_SESSION['text'] = 'Skill Prereq Already Set!';
					$_SESSION['type'] = 'warning';
					if ($logFile) {logToFile('Competence','Group Duplicate',$group_name);} // Logger
				}else{
					//new level so update.
					//echo'now we update lvl';
					mysql_query("UPDATE comp_table SET skill_lvl='$c_lvl' WHERE skill_id='$c_skill' AND comp_id='$c_grp'");
					$_SESSION['text'] = 'Skill Prereq Level Updated!';
					$_SESSION['type'] = 'success';
					if ($logFile) {logToFile('Competence','Group Updated LVL',$group_name);} // Logger
				}
			}else{
				//doesnt exists so insert!
				mysql_query("INSERT INTO comp_table (comp_id,skill_id,skill_lvl) VALUES ('$c_grp','$c_skill','$c_lvl')");
				$_SESSION['text'] = 'Skill Prereq Added!';
				$_SESSION['type'] = 'success';
				if ($logFile) {logToFile('Competence','Group Added',$group_name);} // Logger
			}
		//echo'<hr>';
		redirect('./?module=admin&part=competence&do=pre&a=edit&id='.$c_grp.'&gid='.$c_gid.''); exit();
		//echo 'id='.$c_grp.' skillid='.$c_skill.' skilllvl='.$c_lvl;
	}elseif($_GET['s'] == 'delsubskill'){
		$skill_id_del = mysql_escape_string($_GET['skill_id']);
		$c_grp = mysql_escape_string($_GET['id']);
			if(isset($_GET['gid'])){$c_gid = mysql_escape_string($_GET['gid']);$redlnk= '&id='.$c_grp.'&gid='.$c_gid;}else{$redlnk= '&id='.$c_grp;}
		mysql_query("DELETE FROM comp_table WHERE id='".$skill_id_del."'");
		$_SESSION['text'] = 'Skill Prereq Removed!';
		$_SESSION['type'] = 'success';
		if ($logFile) {logToFile('Competence','Skill Prereq Removed');} // Logger
		redirect('./?module=admin&part=competence&do=pre&a=edit'.$redlnk.''); exit();
	}
}





?>