<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<div class="col-md-<?php echo $col_right;?>">
<div class="ui segment raised">
<div class="tabbable-panel">
	<div class="tabbable-line">
		<ul class="nav nav-tabs nav-tabs-center">
			<li class="active"> <a href="#tab_info" data-toggle="tab"> 研討會資訊 </a> </li>
			<li> <a href="<?php echo site_url("sysop/conf/admin/".$conf_config['conf_id'])?>"> 研討管理員 </a> </li>
			<!--<li> <a href="#tab_file" data-toggle="tab"> 研討會ID更換 </a> </li>
			<li> <a href="#tab_review" data-toggle="tab"> 審查資料 </a> </li>-->
		</ul>
		<div class="tab-content">
			<div class="tab-pane active container-fluid" id="tab_info">
				<h2>編輯研討會</h2>
				<?php echo validation_errors('<div class="ui message red">', '</div>');?>
				<?php echo form_open(site_url("sysop/conf/edit/".$conf_id),array("class"=>"form-horizontal"))?>
					<div class="form-group">
						<label for="conf_id" class="col-sm-2 control-label">研討會ID <span class="text-danger">*</span></label>
						<div class="col-sm-10">
							<input type="text" class="form-control" id="conf_id" name="conf_id" value="<?php echo $conf_config['conf_id']; ?>" readonly>
						</div>
					</div>
					<div class="form-group">
						<label for="conf_name" class="col-sm-2 control-label">研討會名稱 <span class="text-danger">*</span></label>
						<div class="col-sm-10">
							<input type="text" class="form-control" id="conf_name" name="conf_name" value="<?php echo $conf_config['conf_name']; ?>">
						</div>
					</div>
					<div class="form-group">
						<label for="conf_master" class="col-sm-2 control-label">主要聯絡人 <span class="text-danger">*</span></label>
						<div class="col-sm-10">
							<input type="text" class="form-control" id="conf_master" name="conf_master" value="<?php echo $conf_config['conf_master']; ?>">
						</div>
					</div>
					<div class="form-group">
						<label for="conf_email" class="col-sm-2 control-label">聯絡信箱 <span class="text-danger">*</span></label>
						<div class="col-sm-10">
							<input type="text" class="form-control" id="conf_email" name="conf_email" value="<?php echo $conf_config['conf_email']; ?>">
						</div>
					</div>
					<div class="form-group">
						<label for="conf_phone" class="col-sm-2 control-label">聯絡電話 <span class="text-danger">*</span></label>
						<div class="col-sm-10">
							<input type="text" class="form-control" id="conf_phone" name="conf_phone" value="<?php echo $conf_config['conf_phone']; ?>">
						</div>
					</div>
					<div class="form-group">
						<label for="conf_address" class="col-sm-2 control-label">通訊地址 <span class="text-danger">*</span></label>
						<div class="col-sm-10">
							<input type="text" class="form-control" id="conf_address" name="conf_address" value="<?php echo $conf_config['conf_address']; ?>">
						</div>
					</div>
					<div class="form-group">
						<label for="conf_fax" class="col-sm-2 control-label">承辦單位 <span class="text-danger">*</span></label>
						<div class="col-sm-10">
							<input name="conf_host" type="text" class="form-control" id="conf_host" value="<?php echo $conf_config['conf_host'];?>">
						</div>
					</div>
					<div class="form-group">
						<label for="conf_place" class="col-sm-2 control-label">大會地點 <span class="text-danger">*</span></label>
						<div class="col-sm-10">
							<input name="conf_place" type="text" class="form-control" id="conf_place" value="<?php echo $conf_config['conf_place'];?>">
						</div>
					</div>
					<div class="form-group">
						<label for="conf_lang" class="col-sm-2 control-label">語言 <span class="text-danger">*</span></label>
						<div class="col-sm-10">
							<div class="btn-group" data-toggle="buttons">
								<label class="btn btn-success<?php if(in_array("zhtw",$conf_lang)){?> active<?php }?>">
									<input type="checkbox" name="conf_lang[]" autocomplete="off" value="zhtw"<?php if(in_array("zhtw",$conf_lang)){?> checked<?php }?>> 繁體中文(Traditional Chinese)
								</label>
								<label class="btn btn-warning<?php if(in_array("eng",$conf_lang)){?> active<?php }?>">
									<input type="checkbox" name="conf_lang[]" autocomplete="off" value="eng"<?php if(in_array("eng",$conf_lang)){?> checked<?php }?>> 英文(English)
								</label>
							</div>
						</div>
					</div>
					<div class="form-group">
						<label for="conf_staus" class="col-sm-2 control-label">顯示/隱藏 <span class="text-danger">*</span></label>
						<div class="col-sm-10">
							<div class="btn-group" data-toggle="buttons">
								<label class="btn btn-primary<?php if($conf_config['conf_staus'] == 0){?> active<?php }?>">
									<input type="radio" name="conf_staus" autocomplete="off" value="0"<?php if($conf_config['conf_staus'] == 0){?> checked<?php }?>> 顯示
								</label>
								<label class="btn btn-danger<?php if($conf_config['conf_staus'] == 1){?> active<?php }?>">
									<input type="radio" name="conf_staus" autocomplete="off" value="1"<?php if($conf_config['conf_staus'] == 1){?> checked<?php }?>> 隱藏
								</label>
							</div>
						</div>
					</div>
					<div class="form-group">
						<label for="conf_fax" class="col-sm-2 control-label">傳真</label>
						<div class="col-sm-10">
							<input type="text" class="form-control" id="conf_fax" name="conf_fax" value="<?php echo $conf_config['conf_fax']; ?>">
						</div>
					</div>
					<div class="form-group">
						<label for="conf_keywords" class="col-sm-2 control-label">關鍵字 <span class="text-danger">*</span></label>
						<div class="col-sm-10">
							<input name="conf_keywords" type="text" class="form-control" id="conf_keywords" value="<?php echo $conf_config['conf_keywords'];?>">
						</div>
					</div>
					<div class="form-group">
						<label for="conf_desc" class="col-sm-2 control-label">關於研討會 <span class="text-danger">*</span></label>
						<div class="col-sm-10">
							<textarea class="form-control" id="conf_desc" name="conf_desc"><?php echo $conf_config['conf_desc']; ?></textarea>
						</div>
					</div>
					<div class="form-group">
						<div class="col-sm-offset-2 col-sm-10">
							<button type="submit" class="ui button teal">更新研討會</button>
						</div>
					</div>
				<?php echo form_close();?>
			</div>
		</div>
	</div>
</div>
</div>
</div>