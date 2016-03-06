<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<div class="row form-group">
    <div class="col-xs-12">
        <ul class="nav nav-pills nav-justified thumbnail setup-panel">
            <li class="<?php echo $step_class[1]?>">
            	<a href="?step=1">
                	<h4 class="list-group-item-heading">Step 1</h4>
                	<p class="list-group-item-text">投稿檢核清單</p>
            	</a>
            </li>
            <li class="<?php echo $step_class[2]?>">
            	<a href="?step=2">
	                <h4 class="list-group-item-heading">Step 2</h4>
	                <p class="list-group-item-text">投稿資料及作者資訊</p>
            	</a>
            </li>
            <li class="<?php echo $step_class[3]?>">
            	<a href="?step=3">
                	<h4 class="list-group-item-heading">Step 3</h4>
                	<p class="list-group-item-text">上傳投稿資料檔案</p>
            	</a>
            </li>
            <li class="<?php echo $step_class[4]?>">
            	<a href="?step=4">
                	<h4 class="list-group-item-heading">Step 4</h4>
                	<p class="list-group-item-text">上傳投稿補充資料</p>
            	</a>
            </li>
            <li class="<?php echo $step_class[5]?>">
            	<a href="?step=5">
                	<h4 class="list-group-item-heading">Step 5</h4>
                	<p class="list-group-item-text">稿件資料最後確認</p>
            	</a>
            </li>
            <li class="<?php echo $step_class[6]?>">
            	<a href="javascript:void(0)">
                	<h4 class="list-group-item-heading">Step 6</h4>
                	<p class="list-group-item-text">送出審查</p>
            	</a>
            </li>
        </ul>
    </div>
</div>