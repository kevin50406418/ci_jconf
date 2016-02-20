<script>
tinymce.init({
    selector: ".tinymce",
    theme: "modern",
    language : 'zh_TW',
    plugins: [
        "advlist autolink link image lists charmap preview hr anchor code",
        "searchreplace wordcount visualblocks visualchars insertdatetime media nonbreaking",
        "table contextmenu directionality emoticons paste textcolor fullscreen responsivefilemanager"// 
    ],
    toolbar1: "cut copy paste | undo redo | searchreplace | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent ",
    toolbar2: "styleselect formatselect fontselect fontsizeselect | forecolor backcolor | bold italic underline blockquote removeformat",
    toolbar3: "table hr | link unlink anchor | image media  | subscript superscript | preview code fullscreen | responsivefilemanager",//
    image_advtab: true,
    menubar: false,
    table_class_list: [
        {title: 'None', value: ''},
        {title: 'Basic', value: 'table'},
        {title: 'Striped rows', value: 'table table-striped'},
        {title: 'Bordered table', value: 'table table-bordered'},
        {title: 'Hover rows', value: 'table table-hover'},
        {title: 'HoverBorder table', value: 'table table-bordered table-hover'},
        {title: 'Condensed table', value: 'table table-condensed'},
    ],
    image_class_list: [
        {title: 'None', value: ''},
        {title: 'Round', value: 'img-rounded'},
        {title: 'Circle', value: 'img-circle'},
        {title: 'Thumbnail', value: 'img-thumbnail'}
    ],
    link_class_list: [
        {title: 'None', value: ''},
        {title: 'Button default', value: 'btn btn-default'},
        {title: 'Button primary', value: 'btn btn-primary'},
        {title: 'Button success', value: 'btn btn-success'},
        {title: 'Button info', value: 'btn btn-info'},
        {title: 'Button warning', value: 'btn btn-warning'},
        {title: 'Button danger', value: 'btn btn-danger'},
    ],
    external_filemanager_path:"<?php echo site_url()?>filemanager/",
    filebrowserBrowseUrl : '<?php echo site_url()?>filemanager/dialog.php?type=2&fldr=<?php echo $this->conf_id?>',
    filemanager_title:"Responsive Filemanager" ,
    external_plugins: { "filemanager" : "<?php echo site_url()?>filemanager/plugin.min.js"}
});
</script>
