<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<div class="ui segment blue">
	<table class="table table-bordered table-hover">
		<thead>
			<tr>
				<th>信件主旨</th>
				<th>操作</th>
			</tr>
		</thead>
		<tbody>
			<?php foreach ($mail_templates as $key => $template) {?>
			<tr>
				<td style="width: 80%;">
					<div><?php echo $template->email_subject_zhtw?></div>
					<div><?php echo $template->email_subject_eng?></div>
				</td>
				<td style="width: 20%;">
					<a href="<?php echo get_url("dashboard",$conf_id,"email","edit")?>?key=<?php echo $template->email_key?>" class="ui button blue">編輯</a>
				</td>
			</tr>
			<?php }?>
		</tbody>
	</table>
</div>