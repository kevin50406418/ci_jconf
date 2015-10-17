<script>
tinymce.init({
    selector: ".tinymce",
    theme: "modern",
    language : 'zh_TW',
    plugins: [
        "advlist autolink link image lists charmap preview hr anchor code",
        "searchreplace wordcount visualblocks visualchars insertdatetime media nonbreaking",
        "table contextmenu directionality emoticons paste textcolor"// responsivefilemanager
    ],
    toolbar1: "undo redo | bold italic underline | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | styleselect",
    toolbar2: "| link unlink anchor | image media | forecolor backcolor  | preview code ",//| responsivefilemanager
    image_advtab: true,
    //external_filemanager_path:"<?php echo base_url()?>filemanager/",
    //filebrowserBrowseUrl : '<?php echo base_url()?>filemanager/dialog.php?type=2&fldr=',
    //filemanager_title:"Responsive Filemanager" ,
    //external_plugins: { "filemanager" : "<?php echo base_url()?>filemanager/plugin.min.js"}
});
</script>
