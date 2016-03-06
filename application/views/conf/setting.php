<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<div class="ui segment raised">
<div class="tabbable-panel">
	<div class="tabbable-line">
		<ul class="nav nav-tabs nav-tabs-center">
			<li class="active"> <a href="#tab_config" data-toggle="tab"> <i class="fa fa-info-circle fa-lg"></i> <?php echo lang('conf_info')?> </a> </li>
			<li> <a href="#tab_style" data-toggle="tab"> <i class="fa fa-magic fa-lg"></i> <?php echo lang('conf_style')?> </a> </li>
			<li> <a href="#tab_function" data-toggle="tab"> <i class="fa fa-cog fa-lg"></i> <?php echo lang('conf_function')?> </a> </li>
			<li> <a href="#tab_schedule" data-toggle="tab"> <i class="fa fa-calendar fa-lg"></i> <?php echo lang('schedule')?> </a> </li>
			<?php echo form_open(get_url("dashboard",$conf_id,"setting"),array("class"=>"pull-right"))?>
			<?php echo form_hidden('do', 'status');?>
			<?php if( $conf_config['conf_staus']==0 ){?>
				<button type="submit" name="conf_staus" value="1" class="ui button red"><?php echo lang('conf_close')?></button>
			<?php }else{?>
				<button type="submit" name="conf_staus" value="0" class="ui button green"><?php echo lang('conf_open')?></button>
			<?php }?>
			<?php echo form_close()?>
		</ul>
		<div class="tab-content">
			<div class="tab-pane active container-fluid" id="tab_config">
				<h2><i class="fa fa-info-circle fa-lg"></i> <?php echo lang('conf_info')?></h2>
				<?php echo validation_errors('<div class="ui negative message">', '</div>');?>
				<?php echo form_open(get_url("dashboard",$conf_id,"setting"),array("class"=>"form-horizontal"))?>
					<?php echo form_hidden('do', 'config');?>
					<div class="form-group">
						<label class="col-sm-2 control-label"><?php echo lang('conf_id')?></label>
						<div class="col-sm-10">
							<p class="form-control-static" title="由系統管理員分配預更改請洽系統管理員"><?php echo $conf_config['conf_id'];?></p>
						</div>
					</div>
					<div class="form-group">
						<label for="conf_name" class="col-sm-2 control-label"><?php echo lang('conf_name')?> <span class="text-danger">*</span></label>
						<div class="col-sm-10">
							<input name="conf_name" type="text" class="form-control" id="conf_name" value="<?php echo $conf_config['conf_name'];?>">
						</div>
					</div>
					<div class="form-group">
						<label for="conf_master" class="col-sm-2 control-label"><?php echo lang('conf_master')?> <span class="text-danger">*</span></label>
						<div class="col-sm-10">
							<input name="conf_master" type="text" class="form-control" id="conf_master" value="<?php echo $conf_config['conf_master'];?>">
						</div>
					</div>
					<div class="form-group">
						<label for="conf_email" class="col-sm-2 control-label"><?php echo lang('conf_email')?> <span class="text-danger">*</span></label>
						<div class="col-sm-10">
							<input name="conf_email" type="email" class="form-control" id="conf_email" value="<?php echo $conf_config['conf_email'];?>">
						</div>
					</div>
					<div class="form-group">
						<label for="conf_phone" class="col-sm-2 control-label"><?php echo lang('conf_phone')?> <span class="text-danger">*</span></label>
						<div class="col-sm-10">
							<input name="conf_phone" type="text" class="form-control" id="conf_phone" value="<?php echo $conf_config['conf_phone'];?>">
						</div>
					</div>
					<div class="form-group">
						<label for="conf_address" class="col-sm-2 control-label"><?php echo lang('conf_address')?> <span class="text-danger">*</span></label>
						<div class="col-sm-10">
							<input name="conf_address" type="text" class="form-control" id="conf_address" value="<?php echo $conf_config['conf_address'];?>">
						</div>
					</div>
					<div class="form-group">
						<label for="conf_host" class="col-sm-2 control-label"><?php echo lang('conf_host')?> <span class="text-danger">*</span></label>
						<div class="col-sm-10">
							<input name="conf_host" type="text" class="form-control" id="conf_host" value="<?php echo $conf_config['conf_host'];?>">
						</div>
					</div>
					<div class="form-group">
						<label for="conf_place" class="col-sm-2 control-label"><?php echo lang('conf_place')?> <span class="text-danger">*</span></label>
						<div class="col-sm-10">
							<input name="conf_place" type="text" class="form-control" id="conf_place" value="<?php echo $conf_config['conf_place'];?>">
						</div>
					</div>
					<div class="form-group">
						<label for="conf_fax" class="col-sm-2 control-label"><?php echo lang('conf_fax')?></label>
						<div class="col-sm-10">
							<input name="conf_fax" type="text" class="form-control" id="conf_fax" value="<?php echo $conf_config['conf_fax'];?>">
						</div>
					</div>
					<div class="form-group">
						<label for="conf_keywords" class="col-sm-2 control-label"><?php echo lang('conf_keywords')?> <span class="text-danger">*</span></label>
						<div class="col-sm-10">
							<input name="conf_keywords" type="text" class="form-control" id="conf_keywords" value="<?php echo $conf_config['conf_keywords'];?>">
						</div>
					</div>
					<div class="form-group">
						<label for="conf_desc" class="col-sm-2 control-label"><?php echo lang('conf_desc')?> <span class="text-danger">*</span></label>
						<div class="col-sm-10">
							<textarea name="conf_desc" class="form-control" id="conf_desc" rows="10"><?php echo $conf_config['conf_desc'];?></textarea>
						</div>
					</div>
					<div class="form-group">
						<div class="col-sm-offset-2 col-sm-10">
							<input type="submit" name="submit_1" value="<?php echo lang('conf_edit')?>" class="ui button blue">
						</div>
					</div>
				<?php echo form_close()?>
			</div>
			<div class="tab-pane container-fluid" id="tab_style">
				<h2><i class="fa fa-magic fa-lg"></i> <?php echo lang('conf_style')?></h2>
				<?php echo validation_errors('<div class="ui negative message">', '</div>');?>
				<?php echo form_open(get_url("dashboard",$conf_id,"setting"),array("class"=>"form-horizontal"))?>
				<?php echo form_hidden('do', 'style');?>
				<table class="table table-bordered">
					<thead>
						<tr>
							<th> </th>
							<th><?php echo lang('conf_style_name')?></th>
						</tr>
					</thead>
					<tbody>
						<?php foreach($styles as $key => $style){?>
						<tr>
							<td>
								<input type="radio" value="<?php echo $style->style_template?>" name="style"<?php if( $conf_config['conf_template']==$style->style_template ){?> checked<?php }?>>
							</td>
							<td><?php echo $style->style_title?></td>
						</tr>
						<?php }?>
					</tbody>
				</table>
				<input type="submit" name="submit_1" value="<?php echo lang('conf_edit')?>" class="ui button blue">
				<?php echo form_close()?>
			</div>
			<div class="tab-pane container-fluid" id="tab_function">
				<h2><i class="fa fa-cog fa-lg"></i> <?php echo lang('conf_function')?></h2>
				<?php echo validation_errors('<div class="ui negative message">', '</div>');?>
				<?php echo form_open(get_url("dashboard",$conf_id,"setting"),array("class"=>"form-horizontal"))?>
				<?php echo form_hidden('do', 'func');?>
				<div class="form-group">
					<label for="conf_address" class="col-sm-2 control-label"><?php echo lang('home_layout')?></label>
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
					<div class="col-sm-2 control-label"><?php echo lang('conf_function')?></div>
					<div class="col-sm-10">
						<table class="table table-bordered">
							<thead>
								<tr>
									<th></th>
									<th class="text-center"><?php echo lang('most_on')?></th>
									<th class="text-center"><?php echo lang('most_off')?></th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<th>
										<label for="conf_most" class="control-label">科技部成果發表</label>
									</th>
									<td class="text-center<?php if($conf_config['conf_most'] == 1 ){?> success<?php }?>">
										<input type="radio" name="conf_most" id="conf_most1" autocomplete="off" value="1"<?php if($conf_config['conf_most'] == 1 ){?> checked<?php }?>> 
									</td>
									<td class="text-center<?php if($conf_config['conf_most'] == 0 ){?> danger<?php }?>">
										<input type="radio" name="conf_most" id="conf_most2" autocomplete="off" value="0"<?php if($conf_config['conf_most'] == 0 ){?> checked<?php }?>>
									</td>
								</tr>
								<tr>
									<th>
										<label for="topic_assign" class="control-label"><?php echo lang('conf_topic_assign')?></label>
									</th>
									<td class="text-center<?php if($conf_config['topic_assign'] == 1 ){?> success<?php }?>">
										<input type="radio" name="topic_assign" id="topic_assign1" autocomplete="off" value="1"<?php if($conf_config['topic_assign'] == 1 ){?> checked<?php }?>> 
									</td>
									<td class="text-center<?php if($conf_config['topic_assign'] == 0 ){?> danger<?php }?>">
										<input type="radio" name="topic_assign" id="topic_assign2" autocomplete="off" value="0"<?php if($conf_config['topic_assign'] == 0 ){?> checked<?php }?>>
									</td>
								</tr>
							</tbody>
						</table>
					</div>
				</div>
				<div class="form-group">
					<div class="col-sm-offset-2 col-sm-10">
						<input type="submit" name="submit_1" value="<?php echo lang('conf_edit')?>" class="ui button blue">
					</div>
				</div>
				<?php echo form_close()?>
			</div>
			<div class="tab-pane container-fluid" id="tab_schedule">
				<h2><i class="fa fa-calendar fa-lg"></i> <?php echo lang('schedule')?></h2>
				<?php echo validation_errors('<div class="ui negative message">', '</div>');?>
				<?php echo form_open(get_url("dashboard",$conf_id,"setting"),array("class"=>"form-horizontal"))?>
				<?php echo form_hidden('do', 'schedule');?>
				<div class="table-responsive repeat">
				<table class="table table-bordered table-hover" id="dates">
					<thead>
						<tr>
							<th class="text-center" style="width: 5%">移動</th>
							<th class="text-center" style="width: 15%">項目</th>
							<th class="text-center" style="width: 25%">中文名稱</th>
							<th class="text-center" style="width: 25%">英文名稱</th>
							<th class="text-center" style="width: 20%">日期</th>
							<th class="text-center" style="width: 10%">顯示方式</th>
						</tr>
					</thead>
					<tbody>
						<?php foreach ($schedules as $key => $schedule) {?>
						<tr>
							<td class="text-center">
								<span class="move ui black button tiny"><i class="fa fa-arrows-alt fa-lg"></i></span>
							</td>
							<td class="text-center">
								<?php echo lang('schedule_'.$key)?>
							</td>
							<td class="text-center">
								<input type="text" name="sc[<?php echo $key?>][date_title_zhtw]" value="<?php echo set_value('sc['.$key.'][date_title_zhtw]', $schedule['date_title_zhtw']); ?>">
							</td>
							<td class="text-center">
								<input type="text" name="sc[<?php echo $key?>][date_title_en]" value="<?php echo set_value('sc['.$key.'][date_title_en]', $schedule['date_title_en']); ?>">
							</td>
							<td class="text-center">
								<div class="input-daterange input-group" id="datepicker">
									<input type="date" class="input-sm form-control" name="sc[<?php echo $key?>][start]" value="<?php echo set_value('sc['.$key.'][start]', $schedule['start']); ?>">
									<span class="input-group-addon">~</span>
									<input type="date" class="input-sm form-control" name="sc[<?php echo $key?>][end]" value="<?php echo set_value('sc['.$key.'][end]', $schedule['end']); ?>">
								</div>
							</td>
							<td class="text-center">
								<select name="sc[<?php echo $key?>][showmethod]">
									<option value="0"<?php if( $schedule['date_showmethod'] == 0){?> selected<?php }?>>不顯示</option>
									<option value="1"<?php if( $schedule['date_showmethod'] == 1){?> selected<?php }?>>顯示開始日期</option>
									<option value="2"<?php if( $schedule['date_showmethod'] == 2){?> selected<?php }?>>顯示結束日期</option>
									<option value="3"<?php if( $schedule['date_showmethod'] == 3){?> selected<?php }?>>顯示所有日期</option>
								</select>
							</td>
						</tr>
						<?php }?>
					</tbody>
				</table>
				</div>
				
				<div class="form-group">
					<input type="submit" name="submit_1" value="<?php echo lang('conf_edit')?>" class="ui button blue">
				</div>
				<?php echo form_close()?>
			</div>
		</div>
	</div>
</div>
</div>
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
		<?php if($this->_lang == "zhtw"){?>language: "zh-TW",<?php }?>
		todayHighlight: true,
	});
	$(".repeat").each(function() {
		$(this).repeatable_fields({
			wrapper: '#dates',
			container: 'tbody',
			row: 'tr',
			cell: 'td',
		});
	});
});
</script>