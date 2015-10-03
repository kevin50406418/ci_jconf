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
body{font-family: "標楷體"}
.MsoHeader img{width: 100%; height: auto;}
table{border: 1px solid black;}
table td{font-size: 14pt;line-height: 30pt;}
.title{font-size: 22pt;text-align: center; font-weight: bold}
--></style>
</head>
<body>
	<div style="mso-element:header;" id="h1">
		<p class="MsoHeader"><img src="<?php echo asset_url()?>img/most.png"></p>
	</div>
	<p class="title"><?php echo $conf_config['conf_name']?>暨科技部成果發表會</p>
	<p class="title">授權同意書</p>
	<table width="100%" style="padding: 15pt 5pt" cellspacing="0">
	<tr><td>
		<p>為推廣科技部優良成果，積極協助產業技術升級，提升我國科技水準，厚植國家經濟發展基礎，並促進產學合作的機會，茲同意無償授權科技部工程科技推展中心將本人於</p>
		<p><?php echo $schedule['start']?>-<?php echo $schedule['end']?>，由 <?php echo $conf_config['conf_host']?> 主辦</p>
		<p>會議名稱: <?php echo $conf_config['conf_name']?>暨科技部成果發表會</p>
		<p>□口頭發表論文&nbsp;&nbsp;□海報展覽&nbsp;&nbsp;□專題演講</p>
		<p>計畫名稱:<u>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</u>之錄影檔、聲音檔、照片、投影片、論文摘要及全文內容，予以數位典藏並上網公開播放。本資料僅供科技部工程處產學媒合之目的使用。</p>
	<p style="text-align: right">
	立同意書人：<u>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</u>
	</p>
	<p style="text-align: right">
	身分證字號：<u>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</u>
	</p>
	<p style="text-align: right">
	聯絡電話：<u>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</u>
	</p>
	<p style="text-align: center">
	中華民國&nbsp;&nbsp;&nbsp;&nbsp;年&nbsp;&nbsp;&nbsp;&nbsp;月&nbsp;&nbsp;&nbsp;&nbsp;日
	</p>
	</td></tr>
	</table>
 
</body>
</html>