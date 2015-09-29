<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<?php echo form_open('home/ckeditor'); ?>
    <textarea class="mceEditor" name="ckeditor1"></textarea>
    <button type="submit">送出</button>
<?php echo form_close()?>
<script>
	tinymce.init({
    selector: ".mceEditor",theme: "modern",
    plugins: [
         "advlist autolink link image lists charmap print preview hr anchor",
         "searchreplace wordcount visualblocks visualchars insertdatetime media nonbreaking",
         "table contextmenu directionality emoticons paste textcolor responsivefilemanager"
   ],
   toolbar1: "undo redo | bold italic underline | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | styleselect",
   toolbar2: "| responsivefilemanager | link unlink anchor | image media | forecolor backcolor  | preview code ",
   image_advtab: true ,
   external_filemanager_path:"<?php echo base_url("/filemanager")?>/",
   filebrowserBrowseUrl : '<?php echo base_url("/filemanager")?>/dialog.php?type=2&fldr=test2015',
   filemanager_title:"Responsive Filemanager" ,
   external_plugins: { "filemanager" : "<?php echo base_url("filemanager/plugin.min.js")?>"}
 });
</script>