<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<div class="ui segment blue">
	<ul class="nav nav-tabs nav-justified">
		<li class="disabled"><a href="#" role="tab" onclick="alert('研討會報名尚未開始或已截止')">研討會報名</a></li>
		<li class="active"><a href="#upload" role="tab" data-toggle="tab">查詢報名記錄</a></li>
	</ul>
	<div class="tab-content">
		<div role="tabpanel" class="tab-pane active" id="upload">
		<?php if( !empty($conf_config['signup_info']) ){?>
		<div class="ui message info">
			<h2 class="header">註冊資訊</h2>
			<?php echo $conf_config['signup_info']?>
		</div>
		<?php }?>
		<?php if( $this->signup->is_login($this->conf_id) ){?>
			<div class="page-header">
				<h1>查詢報名記錄</h1>
			</div>
			<table class="table table-bordered">
				<thead>
					<tr>
						<th class="col-md-1 text-center">序號</th>
						<th class="col-md-7 text-center">繳費記錄上傳</th>
						<th class="col-md-1 text-center">註冊費用</th>
						<th class="col-md-1 text-center">註冊狀態</th>
						<th class="col-md-1 text-center">填寫時間</th>
						<th class="col-md-1 text-center">操作</th>
					</tr>
				</thead>
				<tbody>
					<?php foreach ($lists as $key => $list) {?>
					<tr>
						<td class="text-center"><?php echo $key+1?></td>
						<td>
							<?php if( $list->signup_status>0 ){?>
								<a href="<?php echo site_url("upload/registration")?>/<?php echo $this->conf_id?>/<?php echo $list->signup_filename?>"><?php echo $list->signup_filename?></a>
							<?php }else{?>
								<div class="col-md-8">
									<input type="file" name="file" accept=".jpg,.png,.bmp,.pdf" disabled>
								</div>
								<div class="col-md-4">
									<button type="button" class="ui button blue disabled">上傳檔案</button>
								</div>
								<div class="text-info">※上傳格式限定為圖片檔(jpg、png、bmp)及 PDF 檔</div>
							<?php }?>
						</td>
						<td class="text-center"><?php echo $list->signup_price?></td>
						<td class="text-center"><?php echo $this->signup->signup_status($list->signup_status)?></td>
						<td class="text-center"><?php echo date("Y-m-d H:i:s",$list->signup_time)?></td>
						<td>
							<button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#detail<?php echo $key+1?>">
								註冊資訊
							</button>
							<!-- Modal -->
							<div class="modal fade" id="detail<?php echo $key+1?>" tabindex="-1" role="dialog">
								<div class="modal-dialog modal-lg" role="document">
									<div class="modal-content">
										<div class="modal-header">
											<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
											<h4 class="modal-title">註冊資訊</h4>
										</div>
										<div class="modal-body">

										<table class="table table-bordered">
											<tr>
												<th class="col-md-2 text-right">姓名</th>
												<td>
													<?php echo $list->user_name?>
												</td>
											</tr>
											<tr>
												<th class="col-md-2 text-right">性別</th>
												<td>
													<label class="checkbox-inline"><input disabled type="radio"<?php if( $list->user_gender == 1 ){?> checked<?php }?>> 男</label>
													<label class="checkbox-inline"><input disabled type="radio"<?php if( $list->user_gender == 0 ){?> checked<?php }?>> 女</label>
												</td>
											</tr>
											<tr>
												<th class="col-md-2 text-right">飲食習慣</th>
												<td>
													<label class="checkbox-inline"><input disabled type="radio"<?php if( $list->user_food == 1 ){?> checked<?php }?>> 葷</label>
													<label class="checkbox-inline"><input disabled type="radio"<?php if( $list->user_food == 0 ){?> checked<?php }?>> 素</label>
												</td>
											</tr>
											<tr>
												<th class="col-md-2 text-right">服務單位</th>
												<td>
													<?php echo $list->user_org?>
												</td>
											</tr>
											<tr>
												<th class="col-md-2 text-right">身分職稱</th>
												<td>
													<?php echo $list->user_title?>
												</td>
											</tr>
											<tr>
												<th class="col-md-2 text-right">聯絡電話</th>
												<td>
													<?php echo $list->user_phone?>
												</td>
											</tr>
											<tr>
												<th class="col-md-2 text-right">E-Mail</th>
												<td>
													<?php echo $list->user_email?>
												</td>
											</tr>
											<tr>
												<th class="col-md-2 text-right">收據抬頭</th>
												<td>
													<?php echo $list->receipt_header?>
												</td>
											</tr>
										</table>
										<?php $signup_type = $list->price_type."|".$list->price_id."|".$list->signup_type?>
										<?php $iseb = $this->signup->is_early_bird($early_bird->start_value,$early_bird->end_value,$list->signup_time)?>
										<table class="table table-bordered table-hover">
											<thead>
												<tr>
													<th class="col-md-6"></th>
													<th class="col-md-2">一般人士</th>
													<th class="col-md-2">教師</th>
													<th class="col-md-2">學生</th>
												</tr>
											</thead>
											<tbody>

												<?php foreach ($prices as $key => $price) {?>
												<tr>
													<th>
														<?php if( $iseb ){?>
														<div class="ui green horizontal label">早鳥</div>
														<?php }?>
														<?php echo $price->type_name?>
													</th>
													<td>
														<input disabled type="radio"<?php if($price->type_id."|".$price->price_id."|o" == $signup_type){?> checked<?php }?>>
														<?php if( $iseb ){?>
															<?php echo $price->early_other?> <s><?php echo $price->other_price?></s>
														<?php }else{?>
															<?php echo $price->other_price?>
														<?php }?>
													</td>
													<td>
														<input disabled type="radio"<?php if($price->type_id."|".$price->price_id."|t" == $signup_type){?> checked<?php }?>>
														<?php if( $iseb ){?>
															<?php echo $price->early_teacher?> <s><?php echo $price->teacher_price?></s>
														<?php }else{?>
															<?php echo $price->teacher_price?>
														<?php }?>
													</td>
													<td>
														<input disabled type="radio"<?php if($price->type_id."|".$price->price_id."|s" == $signup_type){?> checked<?php }?>>
														<?php if( $iseb ){?>
															<?php echo $price->early_student?> <s><?php echo $price->student_price?></s>
														<?php }else{?>
															<?php echo $price->student_price?>
														<?php }?>
													</td>
												</tr>
												<?php }?>
											</tbody>
										</table>
										<h2>論文註冊</h2>
										<table class="table table-bordered">
											<tr>
												<th class="col-md-2 text-right">論文編號</th>
												<td>
													<?php echo $list->paper_id?>
												</td>
											</tr>
											<tr>
												<th class="col-md-2 text-right">論文標題</th>
												<td>
													<?php echo $list->paper_title?>
												</td>
											</tr>
											<tr>
												<th class="col-md-2 text-right">備註</th>
												<td>
													<?php echo $list->user_note?>
												</td>
											</tr>
											<?php if( $list->signup_status>0 ){?>
											<tr>
												<th class="col-md-2 text-right">繳費紀錄</th>
												<td>
													<a href="<?php echo site_url("upload/registration")?>/<?php echo $this->conf_id?>/<?php echo $list->signup_filename?>"><?php echo $list->signup_filename?></a>
												</td>
											</tr>
											<?php }?>
										</table>
										</div>
									</div>
								</div>
							</div>
						</td>
					</tr>
					<?php }?>
				</tbody>
			</table>
		<?php }else{?>
			<div class="page-header">
				<h1>登入</h1>
			</div>
			<?php echo form_open(get_url("signup",$conf_id),array("class" => "form-horizontal"))?>
			<?php echo form_hidden('do', 'login');?>
			<div class="form-group">
				<label class="col-sm-2 control-label">E-Mail</label>
				<div class="col-sm-10">
					<input type="email" class="form-control" name="user_email">
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label">密碼</label>
				<div class="col-sm-10">
					<input type="password" class="form-control" name="user_pass">
				</div>
			</div>
			<div class="form-group">
				<div class="col-sm-offset-2 col-sm-10">
					<button type="submit" class="btn btn-default">登入</button>
				</div>
			</div>
			<?php echo form_close()?>
		<?php }?>
		</div><!-- #upload -->
	</div>
</div>