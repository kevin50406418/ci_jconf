<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="ui segment blue">
	<div class="row">
        <div class="col-md-3">
            <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                <div class="panel panel-default">
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
                                        <input type="checkbox" name="menu-item[]" value="<?php echo $page->page_id?>"> <?php echo $page->page_title?>
                                    </label>
                                </li>
                                <?php }?>
                            </ul>
                            <div class="text-right">
                                <button type="submit" class="ui button" value="page">新增至選單</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="panel panel-default">
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
                                <input type="text" class="form-control" id="custom-menu-item-url" value="http://">
                            </div>
                            <div class="form-group">
                                <label for="custom-menu-item-name">鏈結文字</label>
                                <input type="password" class="form-control" id="custom-menu-item-name" placeholder="選單項目">
                            </div>
                            <div class="text-right">
                                <button type="submit" class="ui button" value="link">新增至選單</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-9">
            <div class="dd" id="nestable4">
                <ol class='dd-list dd3-list'>
                    <li class="dd-item" data-id="index" data-type="page">
                        <div class="dd-handle">Index</div>
                    </li>
                    <div id="dd-empty-placeholder"></div>
                </ol>
            </div>
        </div>
    </div>
</div>