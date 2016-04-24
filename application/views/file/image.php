<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<div class="container-fluid">
<div class="row">
	<?php foreach ($files as $key => $file) {?>
	<?php $file['name'] = get_basename(rtrim($file['server_path'], '/'));?>
	<div class="col-xs-6 col-md-3">
	<a class="file thumbnail" href="#" data-name="<?php echo $file['name']?>">
		<img src="<?php echo site_url()?>upload/files/<?php echo $this->conf_id?>/<?php echo $file['name'];?>">
		<div class="caption">
        	<?php echo $file['name'];?>
        </div>
	</a>
	</div>
	<?php }?>
</div>
</div>
<script>
$(function(){
	$(".thumbnail").click(function(){
		var funcNum = getUrlParam( 'CKEditorFuncNum' );
		var fileUrl = '<?php echo site_url()?>upload/files/<?php echo $this->conf_id?>/'+$(this).data("name");
		window.opener.CKEDITOR.tools.callFunction( funcNum, fileUrl );
		window.close();
	});
	// Helper function to get parameters from the query string.
	function getUrlParam( paramName ) {
		var reParam = new RegExp( '(?:[\?&]|&)' + paramName + '=([^&]+)', 'i' );
		var match = window.location.search.match( reParam );
		return ( match && match.length > 1 ) ? match[1] : null;
	}
});
</script>
</body>
</html>
