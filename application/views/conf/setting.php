<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<script>
$(function() { 
	$('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
		localStorage.setItem('<?php echo $conf_config['conf_id'];?>_confsetting', $(this).attr('href'));
	});
	var lastTab = localStorage.getItem('<?php echo $conf_config['conf_id'];?>_confsetting');
	if (lastTab) {
		$('[href="'+lastTab+'"]').tab('show');
	}
});
</script>
<div class="ui segment raised">
<div class="tabbable-panel">
	<div class="tabbable-line">
		<ul class="nav nav-tabs nav-tabs-center">
			<li class="active"> <a href="#tab_config" data-toggle="tab"> <i class="fa fa-info-circle fa-lg"></i> 研討會資訊 </a> </li>
			<!--<li> <a href="#tab_style" data-toggle="tab"> <i class="fa fa-magic fa-lg"></i> 研討會樣式 </a> </li>-->
			<li> <a href="#tab_function" data-toggle="tab"> <i class="fa fa-cog fa-lg"></i> 功能設定 </a> </li>
			<li> <a href="#tab_schedule" data-toggle="tab"> <i class="fa fa-calendar fa-lg"></i> 時間安排 </a> </li>
			<li> <a href="#tab_org" data-toggle="tab"> <i class="fa fa-users fa-lg"></i> 大會組織 </a> </li>
			<?php if( $conf_config['conf_staus']==0 ){?>
				<a href="#" class="ui button red pull-right">關閉研討會</a>
			<?php }else{?>
				<a href="#" class="ui button green pull-right">開啟研討會</a>
			<?php }?>
		</ul>
		<div class="tab-content">
			<div class="tab-pane active container-fluid" id="tab_config">
				<h2><i class="fa fa-info-circle fa-lg"></i> 研討會資訊</h2>
				<?php echo form_open(get_url("dashboard",$conf_id,"setting"),array("class"=>"form-horizontal"))?>
					<div class="form-group">
						<label class="col-sm-2 control-label">研討會編號</label>
						<div class="col-sm-10">
							<p class="form-control-static" title="由系統管理員分配預更改請洽系統管理員"><?php echo $conf_config['conf_id'];?></p>
						</div>
					</div>
					<div class="form-group">
						<label for="conf_name" class="col-sm-2 control-label">研討會名稱</label>
						<div class="col-sm-10">
							<input name="conf_name" type="text" class="form-control" id="conf_name" value="<?php echo $conf_config['conf_name'];?>">
						</div>
					</div>
					<div class="form-group">
						<label for="conf_master" class="col-sm-2 control-label">主要聯絡人</label>
						<div class="col-sm-10">
							<input name="conf_master" type="text" class="form-control" id="conf_master" value="<?php echo $conf_config['conf_master'];?>">
						</div>
					</div>
					<div class="form-group">
						<label for="conf_email" class="col-sm-2 control-label">聯絡信箱</label>
						<div class="col-sm-10">
							<input name="conf_email" type="email" class="form-control" id="conf_email" value="<?php echo $conf_config['conf_email'];?>">
						</div>
					</div>
					<div class="form-group">
						<label for="conf_phone" class="col-sm-2 control-label">聯絡電話</label>
						<div class="col-sm-10">
							<input name="conf_phone" type="text" class="form-control" id="conf_phone" value="<?php echo $conf_config['conf_phone'];?>">
						</div>
					</div>
					<div class="form-group">
						<label for="conf_address" class="col-sm-2 control-label">通訊地址</label>
						<div class="col-sm-10">
							<input name="conf_address" type="text" class="form-control" id="conf_address" value="<?php echo $conf_config['conf_address'];?>">
						</div>
					</div>
					<div class="form-group">
						<label for="conf_fax" class="col-sm-2 control-label">傳真</label>
						<div class="col-sm-10">
							<input name="conf_fax" type="text" class="form-control" id="conf_fax" value="<?php echo $conf_config['conf_fax'];?>">
						</div>
					</div>
					<div class="form-group">
						<label for="conf_desc" class="col-sm-2 control-label">簡介</label>
						<div class="col-sm-10">
							<textarea name="conf_desc" class="form-control" id="conf_desc" rows="5"><?php echo $conf_config['conf_desc'];?></textarea>
						</div>
					</div>
					<div class="form-group">
						<div class="col-sm-offset-2 col-sm-10">
							<input type="submit" name="submit_1" value="修改" class="ui button blue">
						</div>
					</div>
					<input type="hidden" value="config" name="do">
				<?php echo form_close()?>
			</div>
			<div class="tab-pane container-fluid" id="tab_style">
				<h2><i class="fa fa-magic fa-lg"></i> 研討會樣式</h2>
			</div>
			<div class="tab-pane container-fluid" id="tab_function">
				<h2><i class="fa fa-cog fa-lg"></i> 功能設定</h2>
			</div>
			<div class="tab-pane container-fluid" id="tab_schedule">
				<h2><i class="fa fa-calendar fa-lg"></i> 時間安排</h2>
			</div>
			<div class="tab-pane container-fluid" id="tab_org">
				<h2><i class="fa fa-users fa-lg"></i> 大會組織</h2>
			</div>
		</div>
	</div>
</div>
</div>