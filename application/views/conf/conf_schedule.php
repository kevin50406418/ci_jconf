<div class="ui segments collapse" id="collapseschedule">
<div class="ui segment center aligned">
	研討會重要日期
</div>
<div class="ui inverted segment">
	<div class="ui statistics small inverted">
		<div class="statistic red">
			<div class="label">
				會議時間
			</div>
			<div class="value">
				<?php echo $schedule['conf'][0]?>~<?php echo $schedule['conf'][1]?>
			</div>
		</div>
		<div class="statistic">
			<div class="label">
				投稿時間
			</div>
			<div class="value">
				<?php echo $schedule['submit'][0]?>~<?php echo $schedule['submit'][1]?>
			</div>
		</div>
		<div class="statistic">
			<div class="label">
				邀稿時間
			</div>
			<div class="value">
				<?php echo $schedule['invite'][0]?>~<?php echo $schedule['invite'][1]?>
			</div>
		</div>
		<div class="statistic">
			<div class="label">
				審稿時間
			</div>
			<div class="value">
				<?php echo $schedule['reviewer'][0]?>~<?php echo $schedule['reviewer'][1]?>
			</div>
		</div>
		<div class="statistic">
			<div class="label">
				完稿時間
			</div>
			<div class="value">
				<?php echo $schedule['finish'][0]?>~<?php echo $schedule['conf'][1]?>
			</div>
		</div>
		<div class="statistic">
			<div class="label">
				註冊時間
			</div>
			<div class="value">
				<?php echo $schedule['singup'][0]?>~<?php echo $schedule['singup'][1]?>
			</div>
		</div>
	</div>
</div>
</div>