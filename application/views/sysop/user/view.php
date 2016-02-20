<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
	<div class="col-xs-12 col-sm-12">
   		<div class="panel panel-info">
			<div class="panel-heading">
				<h2 class="panel-title">User: <?php echo $user->user_login?></h2>
			</div>
			<div class="panel-body">
				<div class="row">
					<div class="col-md-3 col-lg-3 text-center">
						<img src="<?php echo $this->user->get_gravatar($user->user_email,250)?>" class="img-rounded img-responsive">
					</div>
						<div class="col-md-9 col-lg-9"> 
						<table class="table table-user-information">
							<tr>
								<td>姓名:</td>
								<td>
									<?php echo $user->user_first_name?> <?php echo $user->user_last_name?>
								</td>
							</tr>
							<tr>
								<td>電子信箱:</td>
								<td>
									<?php echo $user->user_email?>
								</td>
							</tr>
							<tr>
								<td>所屬機構:</td>
								<td>
									<?php echo $user->user_org?>
								</td>
							</tr>
							<tr>
								<td>性別:</td>
								<td>
									<?php if($user->user_gender=="M"){?>
										<i class="fa fa-mars"></i> 男
									<?php }else if($user->user_gender=="F"){?>
										<i class="fa fa-venus"></i> 女
									<?php }?>
								</td>
							</tr>
							<tr>
								<td>電話(公):</td>
								<td>
									(<?php echo $user->user_phone_o[0]?>)-<?php echo $user->user_phone_o[1]?>
									<?php if(isset($user->user_phone_o[2])){?>分機：<?php echo $user->user_phone_o[2]?><?php }?>
								</td>
							</tr>
							<tr>
								<td>聯絡地址:</td>
								<td>
									<?php echo $user->user_postcode?>
									<?php
										foreach ($user->user_postaddr as $key => $v) {
											echo $v." ";
										}
									?>
								</td>
							</tr>
							<tr>
								<td>國別:</td>
								<td>
									<?php echo $country_list[$user->user_country]?>
								</td>
							</tr>
							<tr>
								<td>語言:</td>
								<td>
									<?php if($user->user_lang=="zhtw"){?>
										<i class="fa fa-mars"></i> 繁體中文(Traditional Chinese)
									<?php }else if($user->user_lang=="eng"){?>
										<i class="fa fa-venus"></i> 英文(English)
									<?php }?>
								</td>
							</tr>
							<tr>
								<td>研究領域:</td>
								<td>
									<?php echo $user->user_research?>
								</td>
							</tr>
						</table>
					</div>
				</div>
			</div>
			<div class="panel-footer">
				<a class="btn btn-sm btn-primary"><i class="fa fa-envelope"></i> 寄信給 <?php echo $user->user_login?></a>
				<span class="pull-right">
					<a href="<?php echo site_url("sysop/user/edit/".$user->user_login)?>" class="btn btn-sm btn-success"><i class="fa fa-edit"></i>編輯使用者</a>
					<a href="<?php echo site_url("sysop/user/reset/".$user->user_login)?>" class="btn btn-sm btn-warning"><i class="fa fa-edit"></i>重置密碼</a>
				</span>
			</div>
		</div>
	</div>
</div>