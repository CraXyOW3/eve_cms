<?php
if(isset($_POST['keyid'])) {
    $keyid = $_POST['keyid'];
    $vcode = $_POST['vcode'];
        
    ?>
	keyid: <?php echo $keyid; ?><br />
	vcode: <?php echo $vcode; ?><br />
    <?php
    die();
}
?>asdasd