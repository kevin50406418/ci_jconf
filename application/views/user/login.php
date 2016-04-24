<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<div>
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<dvi class="pull-right">
					<button type="button" class="ui button brown" data-toggle="modal" data-target="#personal_agree">個資蒐集、處理、利用告知暨同意書</button>
					<a href="<?php echo site_url();?>" class="ui button teal"><?php echo lang('back_home')?></a>
					<a href="<?php echo base_url('user/signup');?>" class="ui button green"><?php echo lang('signup')?></a>
					<a href="<?php echo base_url('user/lostpwd');?>" class="ui button orange"><?php echo lang('lostpwd')?></a>
				</dvi>
				<h3 class="modal-title"><?php echo lang('login')?></h3>
			</div>
			<?php echo form_open(site_url('user/login'))?>
			<div class="modal-body">
				<div class="ui icon message blue">
					<i class="fa fa-info-circle icon"></i>
					<div class="content">
						<div class="header">
							<?php echo lang('regist_hint')?>
						</div>
						<p><?php echo sprintf(lang('register_here'),'<a href="'.base_url("user/signup").'" class="ui red button">'.lang('register_account').'</a>')?></p>
					</div>
				</div>
				<?php echo validation_errors();?>
				<input name="redirect" type="hidden" id="redirect" value="<?php echo $redirect?>">
				<div class="form-group">
					<label for="user_login" class="control-label"><?php echo lang('account')?> / <?php echo lang('user_email')?> <span class="text-danger">*</span></label>
					<input type="text" class="form-control" id="user_login" name="user_login" value="<?php echo set_value('user_login'); ?>">
				</div>
				<div class="form-group">
					<label for="user_pass" class="control-label"><?php echo lang('password')?> <span class="text-danger">*</span></label>
					<input type="password" class="form-control" id="user_pass" name="user_pass">
				</div>
			</div><!-- .modal-body -->
			<div class="modal-footer">
				<button type="submit" class="ui button blue fluid"><?php echo lang('login')?></button>
			</div><!-- .modal-footer -->
			<?php echo form_close()?>
		</div><!-- .modal-content -->
	</div><!-- .modal-dialog -->
</div>
<div class="modal fade" id="personal_agree" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title">
					<?php echo $this->config->item('site_name');?> 個人資料蒐集、處理、利用告知暨同意書
				</h4>
			</div>
			<div class="modal-body">
				<p>本系統為落實個人資料之保護，茲依據個人資料保護法（以下稱個資法）第8條規定告知下列事項：</p>
				<ol>
					<li>蒐集目的：辦理各項研討會活動、保險及相關行政管理。</li>
					<li>個資類別：辨識個人者如姓名、職稱、聯絡方式、地址等。現行之受僱情形如公司名稱、部門、職稱等。</li>
					<li>利用期間：至蒐集目的消失為止。</li>
					<li>利用地區：本系統僅於中華民國領域內利用您的個人資料。</li>
					<li>利用對象及方式：於蒐集目的之必要範圍內，利用您的個人資料。</li>
					<li>當事人權利：您可向本系統聯絡人行使查詢或請求閱覽、製給複製本、補充或更正、停止蒐集處理利用或刪除您的個人資料之權利，電話：04-23323456轉6301。</li>
					<li>不同意之權益影響：若您不同意提供個人資料，本系統將無法為您提供特定目的之相關服務。</li>
				</ol>
				<p>本人已閱讀並了解上述之告知事項，並同意 <?php echo $this->config->item('site_name');?>在符合上述告知事項範圍內蒐集、處理及利用本人個人資料。</p>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-primary" data-dismiss="modal">同意</button>
				<a href="<?php echo site_url()?>" class="btn btn-danger">不同意</a>
			</div>
		</div>
	</div>
</div>
