<?php
/**
 * PLEASE NOTE: This is a ludicrously insecure script - do not install it on 
 * any publicly-accessible hosting. It's great for trying out little bits of
 * PHP without having to save any files, but don't try to use it for anything
 * other than that!
 */

// allow Javascript to be included in the POSTed code - Chrome stops its execution 
// without this header due to risk of XSS - and rightly so!
header('X-XSS-Protection: 0');
?>
<html>
<head>
	<title>PHP Executer</title>
	<script src="//code.jquery.com/jquery-1.11.2.min.js"></script>
	<script type="text/javascript">
		$(document).ready(function() {
			$code_textarea = $('[name=code]');
			$code_textarea.keydown(function(e) {
				var keyCode = e.keyCode || e.which; 
				
				// check for 'tab'
				if (keyCode == 9) {
					e.preventDefault();
					
					var caretPos = $code_textarea[0].selectionStart;
					var textAreaTxt = $code_textarea.val();
					var txtToAdd = "	";
					$code_textarea.val(textAreaTxt.substring(0, caretPos) + txtToAdd + textAreaTxt.substring(caretPos) );
					$code_textarea[0].setSelectionRange(caretPos + 1, caretPos + 1);
				}
				
				// check for F5 - submit form
				if (keyCode == 116) {
					e.preventDefault();
					$('form').submit();
				}
			});
		});
	</script>
</head>

<body>
<form method="post" style="margin: 0px; float: left; width: <?php echo (!empty($_POST) ? '49%' : '100%'); ?>; height: 100%; position: fixed">
	<textarea name="code" style="width: 100%; height: 90%"><?php echo (isset($_POST['code']) ? stripslashes($_POST['code']) : ''); ?></textarea>
	<br /><input type="submit" />
</form>

<?php 
if (!empty($_POST)) {

	echo '<div style="width: 49%; float: right; border: solid gray 1px; padding: 5px;">';
	if (isset($_POST['code'])) {
		ob_start();
		$result = eval(stripslashes($_POST['code']));
		if ($result === false) {
			echo '<p style="color: red; font-size: 1.1em;">Error</p>';
		}
		//echo nl2br(str_replace(' ', '&nbsp;', htmlentities(ob_get_clean())));
		echo ob_get_clean();
	}
	echo '</div>';
}
?>
</body>
</html>