<?php
if (isset($_SERVER['HTTP_EVE_TRUSTED'])) {if ($_SERVER['HTTP_EVE_TRUSTED'] == 'No') {echo "no can do!";} else {$CHAR_CORPID = $_SERVER['HTTP_EVE_CORPID'];if ($CHAR_CORPID == $G_corpID) {

			if (isset($_GET['a'])) {
				if ($_GET['a']=='add')
					{
						$title=mysql_real_escape_string($_POST['title']);
						$content=mysql_real_escape_string($_POST['content']);
						$author=mysql_real_escape_string($_POST['author']);
						mysql_query("insert into bulletin (title,content,author) VALUES ('$title','$content','$author')");
		$_SESSION['text'] = 'Bulletin added!';
		$_SESSION['type'] = 'success';
						if ($logFile) {logToFile('Bulleting','Added',$title);} // Logger
						header("Location: ./?module=admin&part=bulletin");
				} elseif ($_GET['a']=='update') {
						$title=mysql_real_escape_string($_POST['title']);
						$content=mysql_real_escape_string($_POST['content']);
						$author=mysql_real_escape_string($_POST['author']);
						$id=$_POST['id'];
						mysql_query("UPDATE bulletin SET title='$title', content='$content', author='$author' WHERE id = '$id'");
		$_SESSION['text'] = 'Bulletin "'.$title.'" edited!';
		$_SESSION['type'] = 'success';
						if ($logFile) {logToFile('Bulleting','Edit',$title);} // Logger
						header("Location: ./?module=admin&part=bulletin");
				} elseif ($_GET['a']=='delete') {
						mysql_query("DELETE FROM bulletin WHERE id='".$_GET['id']."'");
		$_SESSION['text'] = 'Bulletin successfully removed!';
		$_SESSION['type'] = 'success';
						if ($logFile) {logToFile('Bulleting','Deletion',$title);} // Logger
						header("Location: ./?module=admin&part=bulletin");
				}
			}
}}}
?>