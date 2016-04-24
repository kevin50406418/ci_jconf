<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<html xmlns:o='urn:schemas-microsoft-com:office:office' xmlns:w='urn:schemas-microsoft-com:office:word' xmlns='http://www.w3.org/TR/REC-html40'>
<head>
<title>Microsoft Office HTML Example</title>
<style><!-- 
@page
{
    size:21cm 29.7cmt;  /* A4 */
    margin:1cm 1cm 1cm 1cm; /* Margins: 2.5 cm on each side */
    mso-page-orientation: portrait;  
}
@page Section1 { }
div.Section1 { page:Section1; }
body{font-family: "標楷體","Times New Roman";}
.MsoHeader img{width: 100%; height: auto;}
table{border: 1px solid black;}
table td{font-size: 14pt;line-height: 30pt;}
.title{font-size: 22pt;text-align: center; font-weight: bold;}
.a{font-size: 14pt;line-height: 30pt;}
.u{border-bottom: 1px solid #000;}
.au{font-size: 14pt;line-height: 30pt;border-bottom: 1px solid #000;}
--></style>
</head>
<body>
	<!-- <div style="mso-element:header;" id="h1">
		<?php echo $conf_config['conf_name']?>
	</div> -->
	<p class="title">著作權授權書</p>
	<p class="a">本授權書所授權之論文為本人在「<?php echo $conf_config['conf_name']?>」所發表之論文。</p>
	<p></p>
	<p class="a">論文名稱(中文或英文)︰<div class="au"><?php echo $paper->sub_title?></div></p>
	<p class="a">作者姓名︰<div class="au">
		<?php foreach ($authors as $key => $author) {?>
			<?php echo $author->user_last_name?><?php echo $author->user_first_name?> 
		<?php }?>
		</div>
	</p>
	<p class="a">	本人具有著作財產權之論文全文，授予：</p>
	<p class="a">
		<ol>
			<li class="a"><?php echo $conf_config['conf_name']?></li>
			<li class="a">國家圖書館(申請研討會論文集ISBN用)</li>
		</ol>
	</p>
	<p class="a">且得不限地域時間與次數，以光碟或紙本重製發行並分送各圖書館及重製成電子資料檔後收錄於研討會論文集主辦單位之網路，並與臺灣學術網路及科技網路連線以達學術研究之目的。</p>
	<p class="a">上述著作權授權書內容均無需訂立讓與及授權契約書，依本授權之發行權為非專屬性發行權利。</p>
	<p style="text-align: right" class="a">
		請簽名：<u>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</u>
	</p>
	<p style="text-align: right" class="a">
		日  期︰<u>&nbsp;&nbsp;&nbsp;</u>年<u>&nbsp;&nbsp;&nbsp;</u>月<u>&nbsp;&nbsp;&nbsp;</u>日
	</p>
</body>
</html>