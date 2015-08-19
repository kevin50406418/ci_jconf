<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<script>
$(function () {
	$('.chosen-select').chosen({no_results_text: "找不到國家"});
	$('#addr_6').twzipcode({
		'css': ['form-control', 'form-control', 'form-control'],
		zipcodeName: 'user_postcode',
		countyName: 'user_addcounty',
		districtName: 'user_area'
	});
	$("#register").validate({
		rules:{
			user_id:{
				required: true
			},
			user_pw:{required:true,minlength:6},
			user_pw2:{required:true,minlength:6,equalTo:"#user_pw"},
			user_firstname:{required:true},
			user_lastname:{required:true},
			user_org:{required:true,maxlength: 40},
			user_email:{
				required:true,
				email:true
			},
			user_phoneO_1:{required:true,maxlength: 5,number: true},
			user_phoneO_2:{required:true,maxlength: 20,number: true},
			user_phoneO_3:{maxlength: 10,number: true},
			user_postcode:{required:true,minlength:3,number: true},
			user_postadd:{required:true,maxlength:80},
			user_cellphone:{required:true,maxlength:13},
			user_research:{required:true,minlength:4},
		},
		messages:{
			user_id:{
				required: "帳號尚未填寫"
			},
			user_pw:{
				required:"密碼尚未填寫",
				minlength:"密碼長度過短，密碼必須是至少 6 字符。"
			},
			user_pw2:{
				required:"重覆輸入密碼尚未填寫",
				minlength:"重覆輸入密碼長度過短，重覆輸入密碼必須是至少 6 字符。",
				equalTo:"兩個密碼不相符"
			},
			user_firstname:{
				required:"名字尚未填寫"
			},
			user_lastname:{
				required:"姓氏尚未填寫"
			},
			user_org:"所屬機構尚未填寫",
			user_email:{
				required:"電子信箱尚未填寫",
				email:"請輸入正確的電子信箱",
				remote: jQuery.validator.format("電子信箱 {0} 已存在"),
			},
			user_phoneO_1:{
				required: "電話(公)區碼為必填欄位",
				maxlength: "請輸入正常的區碼",
				number: "有非法字元"
			},
			user_phoneO_2:{
				required: "電話(公)號碼為必填欄位",
				maxlength: "輸入的號碼超過長度",
				number: "有非法字元"
			},
			user_phoneO_3:{
				maxlength: "輸入的分機號碼超過長度",
				number: "有非法字元"
			},
			user_postcode:{
				required:"請輸入郵遞區號",
				minlength: "請輸入郵遞區號",
				number: "請輸入數字"
			},
			user_postadd:{
				required:"請輸入聯絡地址",
				maxlength:"輸入的聯絡地址超過長度"
			},
			user_cellphone:{
				required:"請輸入手機",
				maxlength:"輸入的手機超過長度",
				number: "有非法字元"
			},
			user_research:{
				required:"請輸入研究領域",
				minlength:"輸入的內容至少四個字"
			},
		},
		highlight: function(element) {
			$(element).closest('.form-group').addClass('has-error');
		},
		unhighlight: function(element) {
			$(element).closest('.form-group').removeClass('has-error');
		},
		errorElement: 'span',
		errorClass: 'help-block',
		errorPlacement: function(error, element) {
			if(element.parent('.input-group').length) {
				error.insertAfter(element.parent());
			} else {
				error.insertAfter(element);
			}
		}
	})
});
</script>
