<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<?php echo form_open(get_url("submit",$conf_id,"add")."?step=2")?>
<div class="ui green segment">
	<h2>檢核清單</h2>
	<table class="table table-striped">
		<tr>
			<td><input type="checkbox" id="chks0" name="list[]"<?php if($this->user->is_sysop()){?> checked<?php }?>></td>
			<td>
				<label for="chks0">本稿件從未出版過，同時也未曾在其他研討會中發表過 (或者提供相關的解釋與說明給主編)。</label>
			</td>
		</tr>
		<?php if(is_array($filter)){?>
		<?php foreach ($filter as $key => $f) {?>
		<tr>
			<td><input type="checkbox" id="chk<?php echo $f->filter_id?>" name="list[]"<?php if($this->user->is_sysop()){?> checked<?php }?>></td>
			<td>
				<label for="chk<?php echo $f->filter_id?>"><?php echo $f->filter_content?></label>
			</td>
		</tr>
		<?php }?>
		<?php }?>
	</table>
	<br><br>
	<div class="text-center">
		<input name="sub_1" type="submit" class="ui blue button" id="sub_1" value="下一步" >
		<a href="<?php echo get_url("main",$conf_id)?>" class="ui red button" onClick="return confirm('本操作將會失去所有資料');">放棄填寫</a>
	</div>
</div>

<?php echo form_close()?>
