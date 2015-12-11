<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<div class="ui segment">
	<p>
		<a href="<?php echo get_url("dashboard",$conf_id,"news","add")?>" class="ui button blue">新增公告</a>
	</p>
	<table class="table table-striped table-bordered table-hover">
		<thead>
			<tr>
				<th style="width: 80%">公告</th>
				<th style="width: 20%">操作</th>
			</tr>
		</thead>
		<?php if(!empty($news)){?>
		<?php foreach ($news as $key => $new) {?>
		<tr>
			<td>
				<div class="panel-group" id="accordion<?php echo $new->news_id?>" role="tablist" aria-multiselectable="true">
					<div class="panel panel-default">
						<div class="panel-heading" role="tab" id="heading<?php echo $new->news_id?>zhtw">
							<h4 class="panel-title">
								<a role="button" data-toggle="collapse" data-parent="#accordion<?php echo $new->news_id?>" href="#collapse<?php echo $new->news_id?>zhtw" aria-expanded="true" aria-controls="collapse<?php echo $new->news_id?>zhtw">
									<?php echo $new->news_title?>
								</a>
							</h4>
    					</div>
						<div id="collapse<?php echo $new->news_id?>zhtw" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading<?php echo $new->news_id?>zhtw">
							<div class="panel-body"><?php echo $new->news_content?></div>
						</div>
					</div>

					<div class="panel panel-default">
						<div class="panel-heading" role="tab" id="heading<?php echo $new->news_id?>eng">
							<h4 class="panel-title">
								<a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse<?php echo $new->news_id?>eng" aria-expanded="false" aria-controls="collapse<?php echo $new->news_id?>eng">
									<?php echo $new->news_title_eng?>
								</a>
							</h4>
						</div>
						<div id="collapse<?php echo $new->news_id?>eng" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading<?php echo $new->news_id?>zhtw">
							<div class="panel-body"><?php echo $new->news_content_eng?></div>
						</div>
					</div>
				</div>
			</td>
			<td>
				<a href="<?php echo get_url("dashboard",$conf_id,"news","edit")?>?id=<?php echo $new->news_id?>" class="ui button blue">編輯</a>
				<a onClick="return confirm('確定是否刪除?');" href="<?php echo get_url("dashboard",$conf_id,"news","del")?>?id=<?php echo $new->news_id?>" class="ui button red">刪除</a>
			</td>
		</tr>
		<?php }?>
		<?php }?>
	</table>
</div>