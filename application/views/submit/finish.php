<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<div class="ui segment blue">
	<h3>完稿檔案</h3>
	<table class="table table-bordered">
		<thead>
			<tr>
				<th>刪除</th>
				<th>檔案類型</th>
				<th>檔案名稱</th>
				<th>操作</th>
			</tr>
		</thead>
		<tr>
			<td><input type="checkbox" name="del_file[]" value=""></td>
			<td>檔案類型</td>
			<td>檔案名稱</td>
			<td>
				<a href="#" class="btn btn-primary btn-xs">查看</a>
				<a href="#" class="btn btn-warning btn-xs">下載</a>
			</td>
		</tr>
	</table>
</div>
<div class="ui segment raised">
<h3>完稿上傳</h3>
<div class="tabbable-panel">
	<div class="tabbable-line">
		<ul class="nav nav-tabs nav-tabs-center">
			<li class="active"> <a href="#tab_ffile" data-toggle="tab"> 上傳投稿文件 </a> </li>
			<li> <a href="#tab_other" data-toggle="tab"> 上傳補充資料 </a> </li>
		</ul>
		<div class="tab-content">
			<div class="tab-pane active container-fluid" id="tab_ffile">
				<?php echo validation_errors('<div class="ui message negative">', '</div>');?>
				<?php echo form_open_multipart(get_url("submit",$conf_id,"finish",$paper_id),array("class"=>"form-horizontal"));?>
				<div class="ui blue segment">
					<h2>上傳投稿文件</h2>
					<div class="form-group">
						<div class="col-sm-12">
							<input name="paper_file" type="file" required="required" id="paper_file" accept=".pdf">
							<p class="help-block">只限PDF上傳投稿資料</p>
						</div>
						<!--[if IE 8]>
						<button id="check" type="submit" class="ui blue button">上傳</button>
						<script>
							$(function(){
								$("#check").on("click",function(){
									if(!$("#paper_file").val()==""){
										if($("#paper_file").val().split('.').pop()=="pdf"){
											return true;
										}else{
											alert("存檔格式必須為pdf!!");
											return false;
										}
									}else{
										alert("尚未上檔案");return false;
									}
								});
							});
						</script>
						<![endif]-->
					</div>
				</div>
				<?php echo form_close()?>
			</div>
			<div class="tab-pane container-fluid" id="tab_other">
				<div id="alert1"></div>
				<?php echo form_open_multipart(get_url("submit",$conf_id,"finish",$paper_id),array("class"=>"form-horizontal"));?>
				<div class="ui blue segment">
					<h2>上傳補充資料</h2>
					<div id="alert"></div>
					<div class="form-group">
						<div class="col-sm-12">
							<input name="paper_file[]" type="file" multiple id="paper_files" accept=".pdf">
							<p class="help-block">只限PDF上傳投稿資料(一次可多個上傳檔案)</p>
						</div>
						<!--[if IE 8]>
						<button id="check" type="submit" class="ui blue button">上傳</button>
						<![endif]-->
					</div>
				</div>
				<?php echo form_close()?>
			</div>
		</div>
	</div>
</div>
</div>


<!--[if IE 8]>
<script>
$(document).ready(function(){
	$("#checks").on("click",function(){
		if($("#paper_files").val().length>0){
			for(i=0;i<$("#paper_file")[0].files.length;i++){
				var e=$("#paper_file")[0].files[i];
				var t=e.name;
				var n=e.size;
				var r=t.substr(t.lastIndexOf(".")+1);
				if(r!="pdf"){
					$("#alert1").add( '<div class="ui negative message"><strong>'+t+'</strong> 存檔格式必須為pdf!!</div>' ).appendTo( "#alert" );
					alert(t+"存檔格式必須為pdf!!");
					return false;
				}
			}
		}else{
			alert("尚未上檔案");
			return false;
		}
	});
});
</script>
<![endif]-->
<script>
$(function(){
	$("#paper_file").fileinput({
		language: "zh-TW",
	    autoReplace: true,
	    maxFileCount: 1,
	    allowedPreviewTypes: [],
	    allowedFileExtensions: ["pdf"],
	    removeIcon: '<i class="fa fa-trash"></i>',
	    
	    browseIcon: '<i class="fa fa-folder-open"></i>',
	    cancelIcon: '<i class="fa fa-ban"></i>',
	    uploadIcon: '<i class="fa fa-upload"></i>',
	    previewFileIcon: '<i class="fa fa-file"></i>',

	    previewFileIconSettings: {
	        'pdf': '<i class="fa fa-file-pdf-o text-danger"></i>',
	    }
	});
	$("#paper_files").fileinput({
		language: "zh-TW",
	    autoReplace: true,
	    allowedPreviewTypes: [],
	    allowedFileExtensions: ["pdf"],
	    removeIcon: '<i class="fa fa-trash"></i>',
	    
	    browseIcon: '<i class="fa fa-folder-open"></i>',
	    cancelIcon: '<i class="fa fa-ban"></i>',
	    uploadIcon: '<i class="fa fa-upload"></i>',
	    previewFileIcon: '<i class="fa fa-file"></i>',

	    previewFileIconSettings: {
	        'pdf': '<i class="fa fa-file-pdf-o text-danger"></i>',
	    }
	});
	$("input[type='checkbox']").change(function (e) {
		if ($(this).is(":checked")) { //If the checkbox is checked
			$(this).closest('tr').addClass("danger"); 
		} else {
			$(this).closest('tr').removeClass("danger");
		}
	});
});
</script>