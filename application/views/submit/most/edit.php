<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<div class="ui raised segment">
	<div class="modal-header">
		<a href="<?php echo get_url("submit",$conf_id,"most")?>" class="ui button teal pull-right">報名列表</a>
		<a href="<?php echo get_url("submit",$conf_id,"most","detail")?>?id=<?php echo $most->most_id?>" class="ui button blue pull-right">查看</a>
		<?php echo form_open(get_url("submit",$conf_id,"most","edit")."?do=submit&id=".$most->most_id);?>
			<button type="submit" class="ui brown huge button pull-right">送出報名資料</button>
		<?php echo form_close()?>
		<h3 class="modal-title">科技部成果發表</h3>
	</div>
	<div class="modal-body">
	<div class="ui message blue large">
		<div class="header">
			目前資料狀態為：編輯中。
		</div>
		<?php echo form_open(get_url("submit",$conf_id,"most","edit")."?do=submit&id=".$most->most_id);?>
			<button type="submit" class="ui brown huge button">送出報名資料</button>
		<?php echo form_close()?>
	</div>
	<?php echo validation_errors('<div class="ui message red">', '</div>');?>
	<?php echo form_open(get_url("submit",$conf_id,"most","edit")."?do=info&id=".$most->most_id,array("class"=>"form-horizontal"));?>
		<h2>計畫資料</h2>
		<table class="table table-bordered">
			<tr>
				<th class="col-sm-2 control-label">發表方式</th>
				<td class="col-sm-10">
					<label class="checkbox-inline"><input name="most_method" type="radio" value="P"<?php if( $most->most_method == "P" ){?> checked<?php }?>>海報發表</label>
					<label class="checkbox-inline"><input name="most_method" type="radio" value="O"<?php if( $most->most_method == "O" ){?> checked<?php }?>>口頭發表</label>
				</td>
			</tr>
			<tr>
				<th class="col-sm-2 control-label">計畫編號</th>
				<td class="col-sm-10">
					<input name="most_number" type="text" class="form-control" id="most_number" value="<?php echo $most->most_number; ?>">
				</td>
			</tr>
			<tr>
				<th class="col-sm-2 control-label">計畫中文名稱</th>
				<td class="col-sm-10">
					<input name="most_name" type="text" class="form-control" id="most_name" value="<?php echo $most->most_name; ?>">
				</td>
			</tr>
			<tr>
				<th class="col-sm-2 control-label">計畫英文名稱</th>
				<td class="col-sm-10">
					<input name="most_name_eng" type="text" class="form-control" id="most_name_eng" value="<?php echo $most->most_name_eng; ?>">
				</td>
			</tr>
			<tr>
				<th class="col-sm-2 control-label">計畫主持人</th>
				<td class="col-sm-10">
					<input name="most_host" type="text" class="form-control" id="most_host" value="<?php echo $most->most_host; ?>">
				</td>
			</tr>
			<tr>
				<th class="col-sm-2 control-label">單位(學校)</th>
				<td class="col-sm-10">
					<input name="most_uni" type="text" class="form-control" id="most_uni" value="<?php echo $most->most_uni; ?>">
				</td>
			</tr>
			<tr>
				<th class="col-sm-2 control-label">部門(系所)</th>
				<td class="col-sm-10">
					<input name="most_dept" type="text" class="form-control" id="most_dept" value="<?php echo $most->most_dept; ?>">
				</td>
			</tr>
		</table>
		<h2>發表者資料</h2>
		<table class="table table-bordered">
			<tr>
				<th class="col-sm-2 control-label">發表者姓名</th>
				<td class="col-sm-10">
					<input name="report_name" type="text" class="form-control" id="report_name" value="<?php echo $report->report_name; ?>">
				</td>
			</tr>
			<tr>
				<th class="col-sm-2 control-label">單位(學校)</th>
				<td class="col-sm-10">
					<input name="report_uni" type="text" class="form-control" id="report_uni" value="<?php echo $report->report_uni; ?>">
				</td>
			</tr>
			<tr>
				<th class="col-sm-2 control-label">部門(系所)</th>
				<td class="col-sm-10">
					<input name="report_dept" type="text" class="form-control" id="report_dept" value="<?php echo $report->report_dept; ?>">
				</td>
			</tr>
			<tr>
				<th class="col-sm-2 control-label">職稱</th>
				<td class="col-sm-10">
					<input name="report_title" type="text" class="form-control" id="report_title" value="<?php echo $report->report_title; ?>">
				</td>
			</tr>
			<tr>
				<th class="col-sm-2 control-label">Email</th>
				<td class="col-sm-10">
					<input name="report_email" type="email" class="form-control" id="report_email" value="<?php echo $report->report_email; ?>">
				</td>
			</tr>
			<tr>
				<th class="col-sm-2 control-label">電話</th>
				<td class="col-sm-10">
					<input name="report_phone" type="text" class="form-control" id="report_phone" value="<?php echo $report->report_phone; ?>">
				</td>
			</tr>
			<tr>
				<th class="col-sm-2 control-label">用餐習慣</th>
				<td class="col-sm-10">
					<label class="checkbox-inline"><input name="report_meal" type="radio" value="2"<?php if( $report->report_meal == 2 ){?> checked<?php }?>>素</label>
					<label class="checkbox-inline"><input name="report_meal" type="radio" value="1"<?php if( $report->report_meal == 1 ){?> checked<?php }?>>葷</label>
				</td>
			</tr>
			<tr>
				<th class="col-sm-2 control-label">餐券</th>
				<td class="col-sm-10">
					<label class="checkbox-inline"><input name="report_mealtype" type="radio" value="2"<?php if( $report->report_mealtype == 2 ){?> checked<?php }?>>自理</label>
					<label class="checkbox-inline"><input name="report_mealtype" type="radio" value="1"<?php if( $report->report_mealtype == 1 ){?> checked<?php }?>>成果發表當天(隨議程而定)</label>
				</td>
			</tr>
		</table>
		<div class="text-center">
			<button type="submit" class="ui teal button" name="update" value="info">更新</button>
		</div>
		<?php echo form_close()?>
		
		<h2>電子檔資料</h2>
		<table class="table table-bordered" id="file">
			<tr>
				<th class="col-sm-2 control-label">授權同意書</th>
				<td class="col-sm-10">
					<div class="col-sm-4">
					<?php if( !empty($most_file->most_auth_name) ){?>
						<a href="#"><?php echo $most_file->most_auth_name?></a>
					<?php }else{?>
						<strong class="text-danger">尚未上傳資料</strong>
					<?php }?>
					</div>
					<div class="col-sm-8">
						<?php echo form_open_multipart(get_url("submit",$conf_id,"most","edit")."?do=file&id=".$most->most_id,array("class"=>"form-horizontal"));?>
							<div class="row">
								<div class="col-sm-10">
									<input name="most_auth" type="file" class="form-control" id="most_auth">
								</div>
								<div class="col-sm-2">
									<button type="submit" class="ui brown button" name="file" value="auth">上傳</button>
								</div>
							</div>
							<div class="text-primary">
								依科技部工程司規定，進行成果發表的計畫主持人需填寫「授權同意書」，以示同意大會將此海報上傳至E-TOP平台及將相關資料繳回科技部工程司。
							</div>
							<div class="text-danger">上傳僅限pdf,doc,docx</div>
						<?php echo form_close()?>
					</div>
				</td>
			</tr>
			<tr>
				<th class="col-sm-2 control-label">成果資料表</th>
				<td class="col-sm-10">
					<div class="col-sm-4">
					<?php if( !empty($most_file->most_result_name) ){?>
						<a href="#"><?php echo $most_file->most_result_name?></a>
					<?php }else{?>
						<strong class="text-danger">尚未上傳資料</strong>
					<?php }?>
					</div>
					<div class="col-sm-8">
						<?php echo form_open_multipart(get_url("submit",$conf_id,"most","edit")."?do=file&id=".$most->most_id,array("class"=>"form-horizontal"));?>
							<div class="row">
								<div class="col-sm-10">
									<input name="most_result" type="file" class="form-control" id="most_result">
								</div>
								<div class="col-sm-2">
									<button type="submit" class="ui brown button" name="file" value="result">上傳</button>
								</div>
							</div>
							<div class="text-danger">上傳僅限pdf,doc,docx</div>
						<?php echo form_close()?>
					</div>
				</td>
			</tr>
			<tr id="row"></tr>
		</table>
	</div>
</div>
<table id="hidden_table" style="display: none">
<tr id="hidden_row"></tr>
<tr id="poster">
	<th class="col-sm-2 control-label">成果海報電子檔</th>
	<td class="col-sm-10">
		<div class="col-sm-4">
		<?php if( !empty($most_file->most_poster_name) ){?>
			<a href="#"><?php echo $most_file->most_poster_name?></a>
		<?php }else{?>
			<strong class="text-danger">尚未上傳資料</strong>
		<?php }?>
		</div>
		<div class="col-sm-8">
			<?php echo form_open_multipart(get_url("submit",$conf_id,"most","edit")."?do=file&id=".$most->most_id,array("class"=>"form-horizontal"));?>
				<div class="row">
					<div class="col-sm-10">
						<input name="most_poster" type="file" class="form-control" id="most_poster">
					</div>
					<div class="col-sm-2">
						<button type="submit" class="ui brown button" name="file" value="poster">上傳</button>
					</div>
				</div>
				<p class="text-danger">口頭報告者不須上傳</p>
				<div class="text-danger">上傳僅限pdf,doc,docx</div>
			<?php echo form_close()?>
		</div>
	</td>
</tr>
</table>
<script>
$(document).ready(function(){
	<?php if( $most->most_method == "P"){?>
	$("#row").after( $( "#poster" ));
	<?php }?>
	$('input[name=most_method]').change(function(){
		if( $(this).val() == "P" ){
			$("#row").after( $( "#poster" ));
		}else if( $(this).val() == "O" ){
			$("#hidden_row").after( $( "#poster" )).hide();
		}
	});
});
</script>
