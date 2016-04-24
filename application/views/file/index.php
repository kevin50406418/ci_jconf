<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<div class="container-fluid">
<div class="row attachment">
<div class="attachment-list">
	<?php foreach ($files as $key => $file) {?>
	<?php $file['name'] = get_basename(rtrim($file['server_path'], '/'));?>
	<a class="file" href="#" data-name="<?php echo $file['name']?>">
		<div class="col-md-8 item-title">
			<i class="fa fa-lg fa-<?php echo get_fileicon(get_mime_by_extension($file['server_path']))?>"></i>
			<?php echo $file['name'];?>
		</div>
		<div class="col-md-2 item-time"><?php echo date("Y-m-d H:i:s",$file['date'])?></div>
		<div class="col-md-2 item-size"><?php echo byte_format($file['size'])?></div>
	</a>
	<?php }?>
</div>
</div>
</div>
<script>
$(function(){
	$(".file").click(function(){
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
