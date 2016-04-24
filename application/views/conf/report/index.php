<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<div class="ui segment blue">
<h2>投稿主題統計報表</h2>
<div class="table-responsive">
<table class="table table-bordered table-hover">
	<thead>
		<tr>
			<th class="text-center" rowspan="2" scope="col">主題名稱</th>
			<th class="text-center" rowspan="2" scope="col">篇數統計</th>
			<th class="text-center" colspan="7" scope="col">投稿狀態</th>
		</tr>
		<tr>
			<th class="text-center" scope="col">拒絕</th>
			<th class="text-center" scope="col">大會待決</th>
			<th class="text-center" scope="col">編輯中</th>
			<th class="text-center" scope="col">投稿完成</th>
			<th class="text-center" scope="col">審查中</th>
			<th class="text-center" scope="col">接受</th>
			<th class="text-center" scope="col">完稿</th>
		</tr>
	</thead>
	<tbody>
		<?php $status = array("sum",-2,-1,2,1,3,4,5);$status_count = array();foreach($status as $val){$status_count[$val] = 0;}?>
		<?php foreach ($topics as $key => $topic) {?>
		<tr>
			<th scope="row">
				<?php echo $topic->topic_name?>
			</th>
			<td class="text-center">
				<?php $status_sum = isset($report_topic[$topic->topic_id])?array_sum($report_topic[$topic->topic_id]):0;?>
				<?php $status_count["sum"] += $status_sum;?>
				<?php echo $status_sum;?>
			</td>
			<td class="text-center">
				<?php $status__2 = isset($report_topic[$topic->topic_id])?element(-2, $report_topic[$topic->topic_id], 0):0;?>
				<?php $status_count[-2] += $status__2;?>
				<?php echo $status__2;?>
			</td>
			<td class="text-center">
				<?php $status_2 = isset($report_topic[$topic->topic_id])?element(2, $report_topic[$topic->topic_id], 0):0;?>
				<?php $status_count[2] += $status_2;?>
				<?php echo $status_2;?>
			</td>
			<td class="text-center">
				<?php $status__1 = isset($report_topic[$topic->topic_id])?element(-1, $report_topic[$topic->topic_id], 0):0;?>
				<?php $status_count[-1] += $status__1;?>
				<?php echo $status__1;?>
			</td>
			<td class="text-center">
				<?php $status_1 = isset($report_topic[$topic->topic_id])?element(1, $report_topic[$topic->topic_id], 0):0;?>
				<?php $status_count[1] += $status_1;?>
				<?php echo $status_1;?>
			</td>
			<td class="text-center">
				<?php $status_3 = isset($report_topic[$topic->topic_id])?element(3, $report_topic[$topic->topic_id], 0):0;?>
				<?php $status_count[3] += $status_3;?>
				<?php echo $status_3;?>
			</td>
			<td class="text-center">
				<?php $status_4 = isset($report_topic[$topic->topic_id])?element(4, $report_topic[$topic->topic_id], 0):0;?>
				<?php $status_count[4] += $status_4;?>
				<?php echo $status_4;?>
			</td>
			<td class="text-center">
				<?php $status_5 = isset($report_topic[$topic->topic_id])?element(5, $report_topic[$topic->topic_id], 0):0;?>
				<?php $status_count[5] += $status_5;?>
				<?php echo $status_5;?>
			</td>
		</tr>
		<?php }?>
	</tbody>
	<tfoot>
		<tr>
			<th scope="row" class="text-right">總計</th>
			<td class="text-center"><?php echo $status_count["sum"];?></td>
			<td class="text-center"><?php echo $status_count[-2];?></td>
			<td class="text-center"><?php echo $status_count[2];?></td>
			<td class="text-center"><?php echo $status_count[-1];?></td>
			<td class="text-center"><?php echo $status_count[1];?></td>
			<td class="text-center"><?php echo $status_count[3];?></td>
			<td class="text-center"><?php echo $status_count[4];?></td>
			<td class="text-center"><?php echo $status_count[5];?></td>
		</tr>
	</tfoot>
</table>

</div>
<div class="row"> 
	<div class="col-xs-12 col-sm-10">
		<div id="columnchart_material" style="height: 500px;"></div>
	</div>
</div>
</div>
<script type="text/javascript">
	google.charts.load('current', {'packages':['bar']});
	google.charts.setOnLoadCallback(drawChart);
	function drawChart() {
		var data = google.visualization.arrayToDataTable([
			['主題名稱', '拒絕', '大會待決', '投稿完成', '審查中', '接受', '完稿'],
			<?php foreach ($topics as $key => $topic) {?>
			['<?php echo $topic->topic_name?>', <?php echo isset($report_topic[$topic->topic_id])?element(-2, $report_topic[$topic->topic_id], 0):0;?>, <?php echo isset($report_topic[$topic->topic_id])?element(2, $report_topic[$topic->topic_id], 0):0;?>, <?php echo isset($report_topic[$topic->topic_id])?element(1, $report_topic[$topic->topic_id], 0):0;?>,<?php echo isset($report_topic[$topic->topic_id])?element(3, $report_topic[$topic->topic_id], 0):0;?>,<?php echo isset($report_topic[$topic->topic_id])?element(4, $report_topic[$topic->topic_id], 0):0;?>,<?php echo isset($report_topic[$topic->topic_id])?element(5, $report_topic[$topic->topic_id], 0):0;?>],
			<?php }?>
		]);
		var options = {
			chart: {
				title: '投稿主題統計報表'
			},
			colors:['#db2828','#fbbd08','#009c95','#f26202','#16ab39','#1678c2'],
		};
		var chart = new google.charts.Bar(document.getElementById('columnchart_material'));
		chart.draw(data, options);
	}
</script>