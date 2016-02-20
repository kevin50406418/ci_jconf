<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="ui segment blue">
    <?php sp( $this->input->post() )?>
    <menu id="nestable-menu">
        <button type="button" data-action="expand-all">Expand All</button>
        <button type="button" data-action="collapse-all">Collapse All</button>
    </menu>
    <div class="row">
        <div class="col-md-3">
            <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                <div class="panel panel-primary">
                    <div class="panel-heading" role="tab" id="headingPage">
                        <h4 class="panel-title">
                            <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapsePage" aria-expanded="true" aria-controls="collapsePage">
                                網頁內容
                            </a>
                        </h4>
                    </div>
                    <div id="collapsePage" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingPage">
                        <div class="panel-body">
                            <ul class="list-unstyled" id="menu_page_list">
                                <?php foreach ($pages as $key => $page) {?>
                                <li>
                                    <label>
                                        <input type="checkbox" name="menu-item[]" value="<?php echo $page->page_id?>" title="<?php echo $page->page_title?>"><span><?php echo $page->page_title?></span>
                                    </label>
                                </li>
                                <?php }?>
                            </ul>
                            <div class="text-right">
                                <button type="button" class="ui button" value="page">新增至選單</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="panel panel-primary">
                <div class="panel-heading" role="tab" id="headingLink">
                    <h4 class="panel-title">
                        <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseLink" aria-expanded="false" aria-controls="collapseLink">
                            自訂鏈結
                        </a>
                    </h4>
                </div>
                <div id="collapseLink" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingLink">
                    <div class="panel-body">
                        <form>
                            <div class="form-group">
                                <label for="custom-menu-item-url">鏈結網址</label>
                                <input required type="text" class="form-control" id="custom-menu-item-url" value="http://">
                            </div>
                            <div class="form-group">
                                <label for="custom-menu-item-name">鏈結文字</label>
                                <input required type="text" class="form-control" id="custom-menu-item-name" placeholder="選單項目">
                            </div>
                            <div class="text-right">
                                <button type="button" class="ui button" value="link">新增至選單</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <?php echo form_open(get_url("dashboard",$conf_id,"menu"),array("class"=>"form-horizontal"))?>
        <div class="col-md-9">
            <div class="dd" id="nestable4">
                <ol id="dd-empty-placeholder" class='dd-list'></ol>
            </div>
        </div>
        <div class="text-center">
                <input type="submit" value="送出" class="ui button blue">
            </div>
        <?php echo form_close()?>
    </div>

<?php //$arr = json_decode('[{"id":"index","children":[{"id":"main","children":[{"id":"news"}]},{"id":"program","children":[{"id":"submission"}]},{"id":"org","children":[{"id":"supplier"}]}]}]')?>
<?php

// function test_print($item){
//     echo "$item \n";
// }

// sp(array_walk_recursive($arr, 'test_print'));
?>
</div>
<script>
$(function(){
    JSON.stringify($('.dd').nestable('serialize'));
});
$(function(){
    var json;
    var output="";
    $("#nestable4 .item_remove").on('click',function(e){
        alert("del?");
        //$(this).parent().parent().remove();
    });
    $('#nestable-menu').on('click', function(e) {
        var target = $(e.target),action = target.data('action');
        if(action === 'expand-all') {
            $('.dd').nestable('expandAll');
        }
        if(action === 'collapse-all') {
            $('.dd').nestable('collapseAll');
        }
    });
    $("#collapsePage button").on('click',function(e){
        json = JSON.stringify($('.dd').nestable('serialize'));
        $('input[name="menu-item[]"]:checked').each(function() {
            var new_item = '[{"type":"page","id":"page'+Math.random().toString(36).substring(12)+'","title":"'+this.title+'","value":"'+this.value+'"}]';
            addItem(new_item);
            $(this).attr('checked', false);
        });
    });
    $("#collapseLink button").on('click',function(e){
        json = JSON.stringify($('.dd').nestable('serialize'));
        var item_url = $("#custom-menu-item-url").val();
        var item_name = $("#custom-menu-item-name").val();
        var new_item = '[{"type":"link","id":"link'+Math.random().toString(36).substring(12)+'","title":"'+item_name+'","value":"'+item_url+'"}]';

        addItem(new_item);
    });
    
    $('#nestable4').nestable({group: 1}).on('change', function(){
        json = JSON.stringify($('.dd').nestable('serialize'));
    });
    function addItem(new_item) {
        $.each(JSON.parse(new_item), function (index, item) {
            output += buildItem(item);
        });
        $('#dd-empty-placeholder').html(output);
    }
    function buildItem(item) {
        var html = "<li class='dd-item dd3-item' data-id='"+item.id+"' data-type='"+item.type+"' data-title='"+item.title+"'>";
        html += "<div class='dd-handle dd3-handle'>Drag</div>";
        //html += "<div class='remove'>x</div>";
        html += "<div class='dd3-content'>" + item.title + "(" + item.value +")";
        html += '<input name="type['+item.id+']" type="hidden" value="' + item.type + '">';
        html += '<input name="title['+item.id+']" type="hidden" value="' + item.title + '">';
        html += '<input name="value['+item.id+']" type="hidden" value="' + item.value + '">';
        
        html += "</div>";
        if (item.children) {
            html += "<ol class='dd-list'>";
            $.each(item.children, function (index, sub) {
                html += buildItem(sub);
            });
            html += "</ol>";

        }
        html += "</li>";
        return html;
    }
});
$(document).ready(function() {


    // var updateOutput = function(e) {
    //     var list = e.length ? e : $(e.target),
    //             output = list.data('output');
    //     if(window.JSON) {
    //         output.val(window.JSON.stringify(list.nestable('serialize')));//, null, 2));
    //     }
    //     else {
    //         output.val('JSON browser support required for this demo.');
    //     }
    // };
    // var json = [
    //     {
    //         "id": 1,
    //         "content": "First item",
    //         "classes": ["dd-nochildren"]
    //     },
    //     {
    //         "id": 2,
    //         "content": "Second item",
    //         "children": [
    //             {
    //                 "id": 3,
    //                 "content": "Item 3"
    //             },
    //             {
    //                 "id": 4,
    //                 "content": "Item 4"
    //             },
    //             {
    //                 "id": 5,
    //                 "content": "Item 5",
    //                 "value": "Item 5 value",
    //                 "foo": "Bar",
    //                 "children": [
    //                     {
    //                         "id": 6,
    //                         "content": "Item 6"
    //                     },
    //                     {
    //                         "id": 7,
    //                         "content": "Item 7"
    //                     },
    //                     {
    //                         "id": 8,
    //                         "content": "Item 8"
    //                     }
    //                 ]
    //             }
    //         ]
    //     },
    //     {
    //         "id": 9,
    //         "content": "Item 9"
    //     },
    //     {
    //         "id": 10,
    //         "content": "Item 10",
    //         "children": [
    //             {
    //                 "id": 11,
    //                 "content": "Item 11",
    //                 "children": [
    //                     {
    //                         "id": 12,
    //                         "content": "Item 12"
    //                     }
    //                 ]
    //             }
    //         ]
    //     }
    // ];
    // // activate Nestable for list 1
    // $('#nestable').nestable({
    //     group: 1,
    //     json: json,
    //     contentCallback: function(item) {
    //         var content = item.content || '' ? item.content : item.id;
    //         content += ' <i>(id = ' + item.id + ')</i>';
    //         return content;
    //     }
    // }).on('change', updateOutput);
    // // activate Nestable for list 2
    // $('#nestable2').nestable({
    //     group: 1
    // }).on('change', updateOutput);
    // $('#nestable3').nestable().on('change', updateOutput);;

    // // output initial serialised data
    // updateOutput($('#nestable').data('output', $('#nestable-output')));
    // updateOutput($('#nestable2').data('output', $('#nestable2-output')));
    // updateOutput($('#nestable3').data('output', $('#nestable3-output')));
});
</script>
