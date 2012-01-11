<html>
<head>
	<title>PHP Executer</title>
</head>

<body>
<form method="post" style="margin: 0px; float: left; width: <?php echo (!empty($_POST) ? '49%' : '100%'); ?>; height: 100%">
	<textarea name="code" style="width: 100%; height: 90%"><?php echo (isset($_POST['code']) ? $_POST['code'] : ''); ?></textarea>
	<br /><input type="submit" />
</form>

<?php 
if (!empty($_POST)) {

	echo '<div style="width: 49%; float: right; border: solid gray 1px; padding: 5px;">';
	if (isset($_POST['code'])) {
		ob_start();
		$result = eval($_POST['code']);
		if ($result === false) {
			echo '<p style="color: red; font-size: 1.1em;">Error</p>';
		}
		echo nl2br(str_replace(' ', '&nbsp;', htmlentities(ob_get_clean())));
	}
	echo '</div>';
}
?>
</body>
</html>