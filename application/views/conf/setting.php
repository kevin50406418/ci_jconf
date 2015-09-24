<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<script>
$(function() { 
	$('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
		localStorage.setItem('<?php echo $conf_config['conf_id'];?>_confsetting', $(this).attr('href'));
	});
	var lastTab = localStorage.getItem('<?php echo $conf_config['conf_id'];?>_confsetting');
	if (lastTab) {
		$('[href="'+lastTab+'"]').tab('show');
	};
	$('.input-daterange').datepicker({
		format: "yyyy-mm-dd",
		todayBtn: "linked",
		todayHighlight: true,
	});
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
					<?php echo form_hidden('do', 'config');?>
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
				<?php echo form_close()?>
			</div>
			<div class="tab-pane container-fluid" id="tab_style">
				<h2><i class="fa fa-magic fa-lg"></i> 研討會樣式</h2>
			</div>
			<div class="tab-pane container-fluid" id="tab_function">
				<h2><i class="fa fa-cog fa-lg"></i> 功能設定</h2>
				<?php echo form_open(get_url("dashboard",$conf_id,"setting"),array("class"=>"form-horizontal"))?>
				<?php echo form_hidden('do', 'func');?>
				<div class="form-group">
					<label for="conf_address" class="col-sm-2 control-label">首頁排版</label>
					<div class="col-sm-1 text-center">
						<img src="<?php echo asset_url()?>img/col/col-1c.png" class="img-thumbnail">
						<input name="conf_col" type="radio" id="conf_col" value="1c"<?php if($conf_config['conf_col'] == "1c" ){?> checked<?php }?>>
					</div>
					<div class="col-sm-1 text-center">
						<img src="<?php echo asset_url()?>img/col/col-2cl.png" class="img-thumbnail">
						<input name="conf_col" type="radio" id="conf_col" value="2cl"<?php if($conf_config['conf_col'] == "2cl" ){?> checked<?php }?>>
					</div>
					<div class="col-sm-1 text-center">
						<img src="<?php echo asset_url()?>img/col/col-2cr.png" class="img-thumbnail">
						<input name="conf_col" type="radio" id="conf_col" value="2cr"<?php if($conf_config['conf_col'] == "2cr" ){?> checked<?php }?>>
					</div>
					<div class="col-sm-1 text-center">
						<img src="<?php echo asset_url()?>img/col/col-3cl.png" class="img-thumbnail">
						<input name="conf_col" type="radio" id="conf_col" value="3cl"<?php if($conf_config['conf_col'] == "3cl" ){?> checked<?php }?>>
					</div>
					<div class="col-sm-1 text-center">
						<img src="<?php echo asset_url()?>img/col/col-3cm.png" class="img-thumbnail">
						<input name="conf_col" type="radio" id="conf_col" value="3cm"<?php if($conf_config['conf_col'] == "3cm" ){?> checked<?php }?>>
					</div>
					<div class="col-sm-1 text-center">
						<img src="<?php echo asset_url()?>img/col/col-3cr.png" class="img-thumbnail">
						<input name="conf_col" type="radio" id="conf_col" value="3cr"<?php if($conf_config['conf_col'] == "3cr" ){?> checked<?php }?>>
					</div>
				</div>
				<div class="form-group">
					<div class="col-sm-offset-2 col-sm-10">
						<input type="submit" name="submit_1" value="修改" class="ui button blue">
					</div>
				</div>
				<?php echo form_close()?>
			</div>
			<div class="tab-pane container-fluid" id="tab_schedule">
				<h2><i class="fa fa-calendar fa-lg"></i> 時間安排</h2>
				<?php echo form_open(get_url("dashboard",$conf_id,"setting"),array("class"=>"form-horizontal"))?>
				<?php echo form_hidden('do', 'schedule');?>
				<div class="form-group">
					<label class="col-sm-2 control-label">會議舉行日期</label>
					<div class="col-sm-10">
						<div class="col-sm-offset-2 col-sm-10">
							<div class="input-daterange input-group" id="datepicker">
								<input type="text" class="input-sm form-control" name="hold[start]" value="<?php echo $schedule['hold']['start']?>">
								<span class="input-group-addon">~</span>
								<input type="text" class="input-sm form-control" name="hold[end]" value="<?php echo $schedule['hold']['end']?>">
							</div>
						</div>
					</div>
				</div>

				<div class="form-group">
					<label class="col-sm-2 control-label">論文徵稿</label>
					<div class="col-sm-10">
						<div class="col-sm-offset-2 col-sm-10">
							<div class="input-daterange input-group" id="datepicker">
								<input type="text" class="input-sm form-control" name="submit[start]" value="<?php echo $schedule['submit']['start']?>">
								<span class="input-group-addon">~</span>
								<input type="text" class="input-sm form-control" name="submit[end]" value="<?php echo $schedule['submit']['end']?>">
							</div>
						</div>
					</div>
				</div>
				
				<div class="form-group">
					<label class="col-sm-2 control-label">早鳥繳費</label>
					<div class="col-sm-10">
						<div class="col-sm-offset-2 col-sm-10">
							<div class="input-daterange input-group" id="datepicker">
								<input type="text" class="input-sm form-control" name="early_bird[start]" value="<?php echo $schedule['early_bird']['start']?>">
								<span class="input-group-addon">~</span>
								<input type="text" class="input-sm form-control" name="early_bird[end]" value="<?php echo $schedule['early_bird']['end']?>">
							</div>
						</div>
					</div>
				</div>

				<div class="form-group">
					<label class="col-sm-2 control-label">線上註冊</label>
					<div class="col-sm-10">
						<div class="col-sm-offset-2 col-sm-10">
							<div class="input-daterange input-group" id="datepicker">
								<input type="text" class="input-sm form-control" name="register[start]" value="<?php echo $schedule['register']['start']?>">
								<span class="input-group-addon">~</span>
								<input type="text" class="input-sm form-control" name="register[end]" value="<?php echo $schedule['register']['end']?>">
							</div>
						</div>
					</div>
				</div>

				<div class="form-group">
					<label class="col-sm-2 control-label">上傳完稿截止</label>
					<div class="col-sm-10">
						<div class="col-sm-offset-2 col-sm-10">
							<div class="input-daterange input-group" id="datepicker">
								<input type="text" class="input-sm form-control" name="finish[end]" value="<?php echo $schedule['finish']['end']?>">
							</div>
						</div>
					</div>
				</div>
				<div class="form-group">
					<input type="submit" name="submit_1" value="修改" class="ui button blue">
				</div>
				<?php echo form_close()?>
			</div>
			<div class="tab-pane container-fluid" id="tab_org">
				<h2><i class="fa fa-users fa-lg"></i> 大會組織</h2>
			</div>
		</div>
	</div>
</div>
</div>