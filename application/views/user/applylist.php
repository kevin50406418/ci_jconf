<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="ui segment blue">
	<h1>申請研討會記錄</h1>
	<table class="table table-bordered">
		<thead>
			<tr>
				<th>申請研討會(研討會ID)</th>
				<th>申請時間</th>
				<th>申請狀態</th>
				<th>更多申請訊息</th>
			</tr>
		</thead>
		<tbody>
			<?php foreach ($applies as $key => $apply) {?>
			<tr>
				<td><?php echo $apply->conf_name?>(<?php echo $apply->conf_id?>)</td>
				<td><?php echo date("Y-m-d H:i",$apply->apply_time)?></td>
				<td><?php echo $this->conf->get_apply_conf_status($apply->apply_status)?></td>
				<td>
					<button type="button" class="ui button blue" data-toggle="modal" data-target="#apply<?php echo $apply->apply_id?>">
						申請資訊
					</button>
					<!-- Modal -->
					<div class="modal fade" id="apply<?php echo $apply->apply_id?>" tabindex="-1" role="dialog">
						<div class="modal-dialog">
							<div class="modal-content">
								<div class="modal-header">
									<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
									<h4 class="modal-title" id="modalLabel">申請資訊</h4>
								</div>
								<div class="modal-body">
									<table class="table table-bordered">
										<tr>
											<th class="col-sm-2 control-label">研討會ID</th>
											<td>
												<?php echo $apply->conf_id?>
											</td>
										</tr>
										<tr>
											<th class="col-sm-2 control-label">研討會名稱</th>
											<td>
												<?php echo $apply->conf_name?>
											</td>
										</tr>
										<tr>
											<th class="col-sm-2 control-label">主要聯絡人</th>
											<td>
												<?php echo $apply->conf_master?>
											</td>
										</tr>
										<tr>
											<th class="col-sm-2 control-label">聯絡信箱</th>
											<td>
												<?php echo $apply->conf_email?>
											</td>
										</tr>
										<tr>
											<th class="col-sm-2 control-label">聯絡電話</th>
											<td>
												<?php echo $apply->conf_phone?>
											</td>
										</tr>
										<tr>
											<th class="col-sm-2 control-label">通訊地址</th>
											<td>
												<?php echo $apply->conf_address?>
											</td>
										</tr>
										<tr>
											<th class="col-sm-2 control-label">承辦單位</th>
											<td>
												<?php echo $apply->conf_host?>
											</td>
										</tr>
										<tr>
											<th class="col-sm-2 control-label">大會地點</th>
											<td>
												<?php echo $apply->conf_place?>
											</td>
										</tr>
										<tr>
											<th class="col-sm-2 control-label">關鍵字</th>
											<td>
												<?php echo $apply->conf_keywords?>
											</td>
										</tr>
										<tr>
											<th class="col-sm-2 control-label">開設後狀態</th>
											<td>
												<label><input type="radio" value="0" disabled <?php if( $apply->conf_staus == 0 ){?>  checked<?php }?>> 隱藏</label>
												<label><input type="radio" value="1" disabled <?php if( $apply->conf_staus == 1 ){?>  checked<?php }?>> 開啟</label>
											</td>
										</tr>
										<tr>
											<th class="col-sm-2 control-label">管理員設置</th>
											<td>
												<div class="radio"><label><input type="radio" value="0" disabled <?php if( $apply->conf_admin == 0 ){?>  checked<?php }?>> 自動開啟研討會帳號</label></div>
												<div class="radio"><label><input type="radio" value="1" disabled <?php if( $apply->conf_admin == 1 ){?>  checked<?php }?>> 請將我設置為研討會管理員</label></div>
												<span class="help-block">
													<li>開啟研討會後，便會自動以研討會ID為帳號開設使用者帳號，系統將會產生隨機密碼發送給研討會申請者</li>
													<li>請將我設置為研討會管理員：不開設研討會專用帳號</li>
												</span>
											</td>
										</tr>
										<tr>
											<th class="col-sm-2 control-label">其他任何信息</th>
											<td>
												<?php echo $apply->conf_id?>
											</td>
										</tr>
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
</div>