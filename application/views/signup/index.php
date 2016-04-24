<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<div class="ui segment blue">
	<ul class="nav nav-tabs nav-justified">
		<li class="active"><a href="#form" role="tab" data-toggle="tab" onclick="$('#personal_agree').modal('show');">研討會報名</a></li>
		<li><a href="#upload" role="tab" data-toggle="tab">查詢報名記錄 / 繳費記錄上傳</a></li>
	</ul>
	<div class="tab-content">
		<div role="tabpanel" class="tab-pane active" id="form">
			<div class="page-header">
				<h1>研討會報名</h1>
			</div>
			<?php if( !empty($conf_config['signup_info']) ){?>
			<div class="ui message info">
				<h2 class="header">註冊資訊</h2>
				<?php echo $conf_config['signup_info']?>
			</div>
			<?php }?>
			<?php echo form_open(get_url("signup",$conf_id),array("id"=>"conf_signup"))?>
			<?php echo form_hidden('do', 'form');?>
			<?php echo validation_errors();?>
			<table class="table table-bordered">
				<tr>
					<th class="col-md-2 text-right">姓名 <span class="text-danger">*</span></th>
					<td>
						<input type="text" name="user_name" class="form-control" value="<?php echo set_value('user_name'); ?>">
						<?php echo form_error('user_name'); ?>
					</td>
				</tr>
				<tr>
					<th class="col-md-2 text-right">性別 <span class="text-danger">*</span></th>
					<td>
						<label class="checkbox-inline"><input type="radio" name="user_gender" value="1"> 男</label>
						<label class="checkbox-inline"><input type="radio" name="user_gender" value="0"> 女</label>
						<?php echo form_error('user_gender'); ?>
					</td>
				</tr>
				<tr>
					<th class="col-md-2 text-right">飲食習慣 <span class="text-danger">*</span></th>
					<td>
						<label class="checkbox-inline"><input type="radio" name="user_food" value="1"> 葷</label>
						<label class="checkbox-inline"><input type="radio" name="user_food" value="0"> 素</label>
						<?php echo form_error('user_food'); ?>
					</td>
				</tr>
				<tr>
					<th class="col-md-2 text-right">服務單位 <span class="text-danger">*</span></th>
					<td>
						<input type="text" name="user_org" class="form-control" value="<?php echo set_value('user_org'); ?>">
						<?php echo form_error('user_org'); ?>
					</td>
				</tr>
				<tr>
					<th class="col-md-2 text-right">身分職稱 <span class="text-danger">*</span></th>
					<td>
						<input type="text" name="user_title" class="form-control" value="<?php echo set_value('user_title'); ?>">
						<?php echo form_error('user_title'); ?>
					</td>
				</tr>
				<tr>
					<th class="col-md-2 text-right">聯絡電話 <span class="text-danger">*</span></th>
					<td>
						<input type="text" name="user_phone" class="form-control" value="<?php echo set_value('user_phone'); ?>">
						<?php echo form_error('user_phone'); ?>
					</td>
				</tr>
				<tr>
					<th class="col-md-2 text-right">E-Mail <span class="text-danger">*</span></th>
					<td>
						<input type="email" name="user_email" class="form-control" value="<?php echo set_value('user_email'); ?>">
						<?php echo form_error('user_email'); ?>
					</td>
				</tr>
				<tr>
					<th class="col-md-2 text-right">收據抬頭 <span class="text-danger">*</span></th>
					<td>
						<input type="text" name="receipt_header" class="form-control" value="<?php echo set_value('receipt_header'); ?>">
						<?php echo form_error('receipt_header'); ?>
					</td>
				</tr>
			</table>
			<?php echo form_error('price_type'); ?>
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
							<?php if( $is_early_bird ){?>
							<div class="ui green horizontal label">早鳥</div>
							<?php }?>
							<?php echo $price->type_name?>
						</th>
						<td>
							<label class="checkbox-inline" for="pt_o<?php echo $price->type_id?>">
							<input class="type<?php echo $price->type_id?>" type="radio" value="<?php echo $price->type_id."|".$price->price_id."|o"?>" name="price_type" id="pt_o<?php echo $price->type_id?>">
							<?php if( $is_early_bird ){?>
								<?php echo $price->early_other?> <s><?php echo $price->other_price?></s>
							<?php }else{?>
								<?php echo $price->other_price?>
							<?php }?>
							</label>
						</td>
						<td>
							<label class="checkbox-inline" for="pt_t<?php echo $price->type_id?>">
							<input class="type<?php echo $price->type_id?>" type="radio" value="<?php echo $price->type_id."|".$price->price_id."|t"?>" name="price_type" id="pt_t<?php echo $price->type_id?>">
							<?php if( $is_early_bird ){?>
								<?php echo $price->early_teacher?> <s><?php echo $price->teacher_price?></s>
							<?php }else{?>
								<?php echo $price->teacher_price?>
							<?php }?>
							</label>
						</td>
						<td>
							<label class="checkbox-inline" for="pt_s<?php echo $price->type_id?>">
							<input class="type<?php echo $price->type_id?>" type="radio" value="<?php echo $price->type_id."|".$price->price_id."|s"?>" name="price_type" id="pt_s<?php echo $price->type_id?>">
							<?php if( $is_early_bird ){?>
								<?php echo $price->early_student?> <s><?php echo $price->student_price?></s>
							<?php }else{?>
								<?php echo $price->student_price?>
							<?php }?>
							</label>
						</td>
					</tr>
					<?php }?>
				</tbody>
			</table>
			<div id="extra_form"></div>
			<h2>論文註冊</h2>
			<table class="table table-bordered">
				<tr>
					<th class="col-md-2 text-right">是否註冊論文? <span class="text-danger">*</span></th>
					<td>
						<label class="checkbox-inline"><input type="radio" name="reg_paper" value="1">是</label>
						<label class="checkbox-inline"><input type="radio" name="reg_paper" value="0">否</label>
						<?php echo form_error('reg_paper'); ?>
						<?php echo form_error('paper_id'); ?>
						<?php echo form_error('paper_title'); ?>
					</td>
				</tr>
				<tr id="row"></tr>
			</table>
			<h2>密碼設定與備註</h2>
			<table class="table table-bordered">
				<tr>
					<th>密碼 <span class="text-danger">*</span></th>
					<td>
						<input type="password" name="user_pass" class="form-control">
						<?php echo form_error('user_pass'); ?>
					</td>
				</tr>
				<tr>
					<th>確認密碼 <span class="text-danger">*</span></th>
					<td>
						<input type="password" name="user_pass2" class="form-control">
						<?php echo form_error('user_pass2'); ?>
					</td>
				</tr>
				<tr>
					<th>備註</th>
					<td>
						<textarea id="comment" name="comment" class="form-control" rows="4" placeholder="在此寫下備註"><?php echo set_value('comment'); ?></textarea>
					</td>
				</tr>
			</table>
			<div class="text-center">
		        <label class="checkbox inline">
		            <input id="check" type="checkbox" required><span class="text-danger">*</span>
		            本人已閱讀並了解<a data-toggle="modal" href="#personal_agree">個人資料蒐集、處理、利用告知暨同意書</a>，並同意貴研討會在符合同意書告知事項範圍內蒐集、處理及利用本人個人資料。
		        </label>
		    </div>
			<div class="text-center">
				<span class="ui red horizontal label massive">費用總計：<span id="total">0</span></span>
				<button type="button" class="btn btn-default" id="calculate">計算費用</button>
				<button type="submit" class="btn btn-primary">送出資料</button>
			</div>
			<?php echo form_close()?>
		</div><!-- #form -->
		<div role="tabpanel" class="tab-pane" id="upload">
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
							<?php echo form_open_multipart(get_url("signup",$conf_id));?>
							<?php echo form_hidden('do', 'upload');?>
							<?php echo form_hidden('signup_id', $list->signup_id);?>
								<div class="col-md-8">
									<input type="file" name="file" accept=".jpg,.png,.bmp,.pdf">
								</div>
								<div class="col-md-4">
									<button type="submit" class="ui button blue">上傳檔案</button>
								</div>
								<div class="text-info">※上傳格式限定為圖片檔(jpg、png、bmp)及 PDF 檔</div>
							<?php echo form_close()?>
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
<table id="hidden_table" style="display: none">
<tr id="hidden_row"></tr>
<tr id="tr_paper_id">
	<th class="col-md-2 text-right">論文編號 <span class="text-danger">*</span></th>
	<td>
		<input type="text" class="form-control" id="paper_id" name="paper_id" value="<?php echo set_value('paper_id'); ?>">
	</td>
</tr>
<tr id="tr_paper_title">
	<th class="col-md-2 text-right">論文標題 <span class="text-danger">*</span></th>
	<td>
		<input type="text" class="form-control" id="paper_title" name="paper_title" value="<?php echo set_value('paper_title'); ?>">
	</td>
</tr>
</table>
<!-- <div class="hidden">
	<div id="tmp_eform"></div>
	<div id="memberid">
		<div class="form-group">
			<label class="col-sm-2 control-label">會員編號 <span class="text-danger">*</span></label>
			<div class="col-sm-10">
				<input type="text" class="form-control" name="signup_memberid" required>
			</div>
		</div>
	</div>
</div> -->
<div class="modal fade" id="personal_agree" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title">
					<?php echo $conf_config['conf_name']?> 個人資料蒐集、處理、利用告知暨同意書
				</h4>
			</div>
			<div class="modal-body">
				<p>本研討會為落實個人資料之保護，茲依據個人資料保護法（以下稱個資法）第8條規定告知下列事項：</p>
				<ol>
					<li>蒐集目的：辦理本研討會活動、保險及相關行政管理。</li>
					<li>個資類別：辨識個人者如姓名、職稱、聯絡方式、地址等。現行之受僱情形如公司名稱、部門、職稱等。</li>
					<li>利用期間：至蒐集目的消失為止。</li>
					<li>利用地區：本研討會僅於中華民國領域內利用您的個人資料。</li>
					<li>利用對象及方式：於蒐集目的之必要範圍內，利用您的個人資料。</li>
					<li>當事人權利：您可向本研討會聯絡人行使查詢或請求閱覽、製給複製本、補充或更正、停止蒐集處理利用或刪除您的個人資料之權利，電話：<?php echo $conf_config['conf_phone']?>。</li>
					<li>不同意之權益影響：若您不同意提供個人資料，本研討會將無法為您提供特定目的之相關服務。</li>
				</ol>
				<p>本人已閱讀並了解上述之告知事項，並同意 貴研討會在符合上述告知事項範圍內蒐集、處理及利用本人個人資料。</p>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-primary" data-dismiss="modal" id="yes">同意</button>
				<a href="<?php echo site_url()?>" class="btn btn-danger">不同意</a>
			</div>
		</div>
	</div>
</div>
<script>
$(document).ready(function(){
	$('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
		localStorage.setItem('signup_<?php echo $this->conf_id?>', $(this).attr('href'));
	});
	var lastTab = localStorage.getItem('signup_<?php echo $this->conf_id?>');
	if (lastTab) {
		$('[href="'+lastTab+'"]').tab('show');
		if( lastTab == "#form"){
			$('#personal_agree').modal('show');
		}
	};
	$('input[name=reg_paper]').change(function(){
		if( $(this).val() == "1" ){
			$("#row").after( $( "#tr_paper_id" ));
			$("#row").after( $( "#tr_paper_title" ));
		}else{
			$("#hidden_row").after( $( "#tr_paper_id" )).hide();
			$("#hidden_row").after( $( "#tr_paper_title" )).hide();
		}
	});
	// $('input[name=price_type]').change(function(){
	// 	if( $(this).val() == "4|4|o" || $(this).val() == "4|4|t" || $(this).val() == "4|4|s"){
	// 		$("#extra_form").after( $( "#memberid" ));
	// 	}else{
	// 		$("#tmp_eform").after($( "#memberid" )).hide();
			
	// 	}
	// });
	$("#calculate").click(function(){
		$.post('<?php echo site_url("ajax/calsignup/".$this->conf_id);?>', $( "#conf_signup" ).serialize(), function(data) {
			$("#total").text(data);
		});
	})
	$("#yes").click(function(){
		$("#check").prop('checked', true);
	})
});
</script>