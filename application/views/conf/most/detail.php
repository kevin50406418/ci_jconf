<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<div class="ui raised segment">
	<div class="modal-header">
		<a href="<?php echo get_url("dashboard",$conf_id,"most")?>" class="ui button teal pull-right">報名列表</a>
		<?php if( $most->most_status == 0 ){?><a href="<?php echo get_url("dashboard",$conf_id,"most","edit")?>?id=<?php echo $most->most_id?>" class="ui button blue pull-right">編輯</a><?php }?>
		<h3 class="modal-title">科技部成果發表</h3>
	</div>
	<div class="modal-body">
		<h2>計畫資料</h2>
		<table class="table table-bordered">
			<tr>
				<th class="col-sm-2 control-label">發表方式</th>
				<td class="col-sm-10">
					<?php echo $this->Submit->most_method($most->most_method);?>
				</td>
			</tr>
			<tr>
				<th class="col-sm-2 control-label">審核狀態</th>
				<td class="col-sm-10">
					<?php echo $this->Submit->most_status($most->most_status,true)?>
				</td>
			</tr>
			<tr>
				<th class="col-sm-2 control-label">計畫編號</th>
				<td class="col-sm-10">
					<?php echo $most->most_number?>
				</td>
			</tr>
			<tr>
				<th class="col-sm-2 control-label">計畫中文名稱</th>
				<td class="col-sm-10">
					<?php echo $most->most_name?>
				</td>
			</tr>
			<tr>
				<th class="col-sm-2 control-label">計畫英文名稱</th>
				<td class="col-sm-10">
					<?php echo $most->most_name_eng?>
				</td>
			</tr>
			<tr>
				<th class="col-sm-2 control-label">計畫主持人</th>
				<td class="col-sm-10">
					<?php echo $most->most_host?>
				</td>
			</tr>
			<tr>
				<th class="col-sm-2 control-label">單位(學校)</th>
				<td class="col-sm-10">
					<?php echo $most->most_uni?>
				</td>
			</tr>
			<tr>
				<th class="col-sm-2 control-label">部門(系所)</th>
				<td class="col-sm-10">
					<?php echo $most->most_dept?>
				</td>
			</tr>
		</table>
		<h2>發表者資料</h2>
		<table class="table table-bordered">
			<tr>
				<th class="col-sm-2 control-label">發表者姓名</th>
				<td class="col-sm-10">
					<?php echo $report->report_name?>
				</td>
			</tr>
			<tr>
				<th class="col-sm-2 control-label">單位(學校)</th>
				<td class="col-sm-10">
					<?php echo $report->report_uni?>
				</td>
			</tr>
			<tr>
				<th class="col-sm-2 control-label">部門(系所)</th>
				<td class="col-sm-10">
					<?php echo $report->report_dept?>
				</td>
			</tr>
			<tr>
				<th class="col-sm-2 control-label">職稱</th>
				<td class="col-sm-10">
					<?php echo $report->report_title?>
				</td>
			</tr>
			<tr>
				<th class="col-sm-2 control-label">Email</th>
				<td class="col-sm-10">
					<?php echo $report->report_email?>
				</td>
			</tr>
			<tr>
				<th class="col-sm-2 control-label">電話</th>
				<td class="col-sm-10">
					<?php echo $report->report_phone?>
				</td>
			</tr>
			<tr>
				<th class="col-sm-2 control-label">用餐習慣</th>
				<td class="col-sm-10">
					<?php if($report->report_meal == 0){?>素<?php }else{?>葷<?php }?>
				</td>
			</tr>
			<tr>
				<th class="col-sm-2 control-label">餐券</th>
				<td class="col-sm-10">
					<?php if( $report->report_mealtype == 0){?>
					自理
					<?php }else if($report->report_mealtype == 1 ){?>
					成果發表當天(隨議程而定)
					<?php }?>
				</td>
			</tr>
		</table>
		
		<h2>電子檔資料</h2>
		<table class="table table-bordered" id="file">
			<tr>
				<th class="col-sm-2 control-label">授權同意書</th>
				<td class="col-sm-10">
					<?php if( !empty($most_file->most_auth_name) ){?>
						<a href="#"><?php echo $most_file->most_auth_name?></a>
					<?php }else{?>
						<strong class="text-danger">尚未上傳資料</strong>
					<?php }?>
				</td>
			</tr>
			<tr>
				<th class="col-sm-2 control-label">成果資料表</th>
				<td class="col-sm-10">
					<?php if( !empty($most_file->most_result_name) ){?>
						<a href="#"><?php echo $most_file->most_result_name?></a>
					<?php }else{?>
						<strong class="text-danger">尚未上傳資料</strong>
					<?php }?>
				</td>
			</tr>
			<?php if( $most->most_method == "P"){?>
			<tr>
				<th class="col-sm-2 control-label">成果海報電子檔</th>
				<td class="col-sm-10">
					<?php if( !empty($most_file->most_poster_name) ){?>
						<a href="#"><?php echo $most_file->most_poster_name?></a>
					<?php }else{?>
						<strong class="text-danger">尚未上傳資料</strong>
					<?php }?>
				</td>
			</tr>
			<?php }?>
		</table>
	</div>
</div>

