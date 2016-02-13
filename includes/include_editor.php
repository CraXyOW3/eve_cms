<?php
echo	'
<script type="text/javascript" src="./js/ckeditor/ckeditor.js"></script>
<link rel="stylesheet" type="text/css" href="./js/cleditor/jquery.cleditor.css" />
<script type="text/javascript" src="./js/cleditor/jquery.cleditor.min.js"></script>
<script type="text/javascript" src="./js/cleditor/jquery.cleditor.advancedtable.min.js"></script>
<script type="text/javascript">
	$(document).ready(function() {
		$("#editor").cleditor({
			width:	550,
			height:	200,
			controls:     // controls to add to the toolbar
				"bold italic underline strikethrough subscript superscript | font size " +
				"| style bullets numbering | outdent " +
				"indent | alignleft center justify table | " +
				"rule image link unlink | source",
			docCSSFile:   // CSS file used to style the document contained within the editor
				"css/stylesheet.css"
		});
	});
</script>
';
?>