<script>
$(function(){
	CKEDITOR.editorConfig = function( config ){
		config.filebrowserBrowseUrl = '<?php echo site_url()?>filemanager/dialog.php?type=2&editor=ckeditor&fldr=<?php echo $this->conf_id?>',
		config.filebrowserUploadUrl = '<?php echo site_url()?>filemanager/dialog.php?type=2&editor=ckeditor&fldr=<?php echo $this->conf_id?>',
		config.filebrowserImageBrowseUrl = '<?php echo site_url()?>filemanager/dialog.php?type=1&editor=ckeditor&fldr=<?php echo $this->conf_id?>'
	}
});
</script>
<!-- #http://docs.ckeditor.com/#!/guide/dev_file_browser_api -->