<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<div class="ui green segment">
	<h2>檢核清單</h2>
	<table class="table table-striped">
		<tr>
			<td class="text-success"><i class="fa fa-check-square-o fa-lg"></i></td>
			<td>
				<label>本稿件從未出版過，同時也未曾在其他研討會中發表過 (或者提供相關的解釋與說明給主編)。</label>
			</td>
		</tr>
		<?php if(is_array($filter)){?>
		<?php foreach ($filter as $key => $f) {?>
		<tr>
			<td class="text-success"><i class="fa fa-check-square-o fa-lg"></i></td>
			<td>
				<label><?php echo $f->filter_content?></label>
			</td>
		</tr>
		<?php }?>
		<?php }?>
	</table>
	<br><br>
	<div class="text-center">
		<a href="<?php echo get_url("submit",$conf_id,"edit",$paper_id)."?step=2";?>" class="ui blue button">下一步</a>
		<a href="<?php echo get_url("main",$conf_id)?>" class="ui red button" onClick="return confirm('本操作將會失去所有資料');">放棄填寫</a>
	</div>
</div>

