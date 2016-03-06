<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="ui segment">
<div class="table-responsive">
	<table class="table table-bordered table-hover datatable">
		<thead>
			<tr>
				<th style="width:5%" class="text-center">#</th>
				<th style="width:50%" class="text-center">題目</th>
				<th style="width:15%" class="text-center">主題</th>
				<th style="width:10%" class="text-center">審查狀態</th>
				<th style="width:10%" class="text-center">完成時間</th>
				<th style="width:10%" class="text-center">操作</th>
			</tr>
		</thead>
		<?php if(is_array($papers)){?>
		<?php foreach ($papers as $key => $paper) {?>
		<tr>
			<td class="text-center"><?php echo $paper->sub_id?></td>
			<td>
				<?php echo $paper->sub_title?>
			</td>
			<td>
				<?php if($_lang=="zhtw"){?>
				<span title="<?php echo $paper->topic_info?>"><?php echo $paper->topic_name?></span>
				<?php }elseif($_lang=="en"){?>
				<?php echo $paper->topic_name_eng?>
				<?php }?>
			</td>
			<td class="text-center">
				<?php $bool = $paper->review_timeout < $time && $paper->review_status == 0;?>
				<?php if( $bool ){?>
					審查逾期
				<?php }else{?>
					<?php echo $this->reviewer->review_status($paper->review_status)?>
				<?php }?>
			</td>
			<td class="text-center">
				<?php if($paper->review_time > 0){?>
					<?php echo date("Y-m-d",$paper->review_time);?>
				<?php }else{?>
					-
				<?php }?>
			</td>
			<td class="text-center">
				<?php if($paper->sub_status == 3){?>
					<?php if( $bool ){?>	
						審查逾期
					<?php }else{?>
						<?php if( $paper->review_confirm == -1 ){?>
						論文審查請求
						<div class="btn-group btn-group-xs">
						<a target="_blank" class="confirm btn btn-success" href="<?php echo site_url("review_confirm/accept/".$paper->review_token);?>">接受</a>
						<a target="_blank" class="confirm btn btn-danger" href="<?php echo site_url("review_confirm/reject/".$paper->review_token);?>">不方便</a>
						</div>
						<?php }else{?>
						<a href="<?php echo get_url("reviewer",$conf_id,"detail",$paper->sub_id)?>" class="ui blue button basic">進行審查</a>
						<?php }?>
					<?php }?>
				<?php }?>
			</td>
		</tr>
		<?php }?>
	<?php }?>
	</table>
</div>
</div>
<script>
$(function(){
	$(".confirm").click(function(e){
		window.location.reload();
	});
});
</script>