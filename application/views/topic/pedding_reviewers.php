<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<div class="ui segment raised yellow">
	
	<?php echo form_open(get_url("topic",$conf_id,"detail",$paper->sub_id))?>
	<?php echo form_hidden('act', 'assign');?>
	<div class="modal-header">
		<h4 class="modal-title">分派審查(確認中)</h4>
	</div>
	<div class="modal-body">
		<?php if($pedding_count%2==0){?>
		<div class="ui info message">
			<div class="header">
				本篇稿件目前審查人人數為 <?php echo $pedding_count?>人，分派審查人人數必須為奇數個
			</div>
		</div>
		<?php }?>
		<div class="ui info message">
			<div class="header">
				目前審查為確認中，若以確認後，請按"送出"，分派審查人才算完成，分派之審查人才可進行審查稿件。
			</div>
		</div>
		
		<table class="table table-hover table-bordered">
			<thead>
				<tr>
					<th> </th>
					<th>帳號(姓名)</th>
					<th>審查期限</th>
					<th>所屬機構</th>
					<th>研究領域</th>
				</tr>
			</thead>
			<?php foreach ($pedding_reviewers as $key => $user) {?>
			<tr>
				<td class="text-center">
					<input type="checkbox" value="<?php echo $user->user_login?>" name="user_login[]">
				</td>
				<td>
					<img src="<?php echo $this->user->get_gravatar($user->user_email,32)?>" class="img-rounded">
					<?php echo $user->user_login?>
					(<?php echo $user->user_first_name?> <?php echo $user->user_last_name?>)
				</td>
				<td>
					<input type="text" value="<?php echo date("Y-m-d H:i",$user->review_timeout)?>" name="review_timeout[<?php echo $user->user_login?>]" class="form-control datetimepicker">
				</td>
				<td>
					<?php echo $user->user_org?>
				</td>
				<td>
					<?php echo $user->user_research?>
				</td>
			</tr>
			<?php }?>
		</table>
	</div>
	<button type="submit" class="ui button red" name="type" value="del">刪除審查人</button>
	<button type="submit" class="ui button teal" name="type" value="time">更新審查期限</button>
	<?php echo form_close()?>
	<?php
		echo form_open(get_url("topic",$conf_id,"detail",$paper->sub_id),array("class"=>"text-center"));
		echo form_hidden('type', 'confirm');
		echo form_hidden('act', 'assign');
		foreach ($pedding_reviewers as $key => $user) { echo form_hidden('user_login[]', $user->user_login);}
	?>
	<button type="submit" class="ui button blue"<?php if($pedding_count%2==0){?> disabled<?php }?>>確認審查人</button>
	<?php echo form_close()?>
</div>
<script type="text/javascript">
$(function () {
    $('.datetimepicker').datetimepicker({
    	format: 'YYYY/MM/DD hh:mm',
    	minDate: '<?php echo $schedule["submit"]["start"]?>',
    	maxDate: '<?php echo $schedule["hold"]["start"]?>',
    	sideBySide: true,
    	locale: "zh-tw",
        icons: {
            time: "fa fa-clock-o",
            date: "fa fa-calendar",
            up: "fa fa-arrow-up",
            down: "fa fa-arrow-down",
            previous: "fa fa-chevron-left",
            next: "fa fa-chevron-right",
            today: "fa fa-screenshot",
            clear: "fa fa-trash",
            close: "fa fa-remov"
        }
    });
});
</script>
