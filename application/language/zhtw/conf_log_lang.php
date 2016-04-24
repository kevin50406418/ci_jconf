<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$lang['log_conf'] = "研討會管理";
$lang['log_submit'] = "投稿者編修";
$lang['log_topic'] = "主編操作";
$lang['log_review'] = "審查人操作";

$lang['update_status'] = "更新研討會狀態：{conf_staus}";
$lang['add_filter'] = "新增投稿檢核清單";
$lang['update_filter'] = "更新投稿檢核清單";
$lang['del_filter'] = "刪投稿檢核清單";
$lang['add_news'] = "新增研討會公告";
$lang['update_news'] = "更新研討會公告";
$lang['del_news'] = "刪投研討會公告";
$lang['update_confinfo'] = "更新研討會資訊";
$lang['sysop_updateconf'] = "系統管理員更新研討會狀態";
$lang['add_topic'] = "新增研討會主題";
$lang['del_topic'] = "刪除研討會主題";
$lang['update_topic'] = "更新研討會主題";
$lang['add_assign_topic'] = "新增 {user_login} 為研討會主題 {topic_id} 主編";
$lang['del_assign_topic'] = "取消 {user_login} 研討會主題 {topic_id} 主編";
$lang['add_content'] = "新增研討會網頁 {page_title}";
$lang['update_contents'] = "更新研討會網頁 {page_title}";
$lang['update_content'] = "更新研討會網頁 {page_title}";
$lang['del_contents'] = "刪除研討會網頁";
$lang['update_confcol'] = "更新首頁排版 {conf_col}";
$lang['update_confmost'] = "{conf_most} 科技部成果發表狀態";
	$lang['update_schedule'] = "更新重要日期：<li>開始時間:{start_value}</li><li>結束時間:{end_value}</li><li>中文名稱:{date_title_zhtw}</li><li>英文名稱:{date_title_en}</li>";
$lang['most_review'] = "更新科技部成果報名表狀態";
$lang['update_most'] = "更新科技部成果報名表";
$lang['add_register_meal'] = "新增研討會餐點";
$lang['update_register_meal'] = "更新研討會餐點"; 
$lang['del_register_meal'] = "刪除研討會餐點";
$lang['update_sort_topic'] = "更新研討會排序";
$lang['update_mail_template'] = "更新電子郵件樣版";
$lang['conf_topic_assign'] = "{topic_assign} 主編設置審查人設置";
$lang['change_paper_status'] = '更改稿件 <a target="_blank" href="submit/detail/{paper_id}">#{paper_id}</a> 狀態為 {paper_status}，原狀態為 {old_status}';

$lang['assign_reviewer_pedding'] = '指派 {user_login} 為<a target="_blank" href="submit/detail/{paper_id}">#{paper_id}</a>稿件暫定審查人(審查期限：{review_timeout})';
$lang['update_pedding_timeout'] = "更新暫定審查人審查期限";
$lang['del_reviewer_pedding'] = '取消 {user_login} 為 <a target="_blank" href="submit/detail/{paper_id}">#{paper_id}</a>稿件暫定審查人';
$lang['assign_reviewer'] = '指派 {user_login} 為 <a target="_blank" href="submit/detail/{paper_id}">#{paper_id}</a>稿件審查人';
$lang['notice_reviewer'] = "審查提醒";
$lang['topic_review'] = "稿件審查：{sub_status}";

$lang['update_review'] = "更新審查意見<li>審查時間：{review_time}</li><li>審查狀態：{review_status}</li><li>審查意見：{review_comment}</li>";

$lang['add_paper'] = "新增投稿論文";
$lang['update_paper'] = "更新投稿論文";
$lang['del_author'] = "刪除論文作者";
$lang['add_file'] = "新增投稿論文檔案";
$lang['update_file'] = "更新投稿論文檔案";
$lang['del_file'] = "刪除投稿論文檔案";
$lang['add_file'] = "新增投稿論文檔案";
$lang['paper_to_review'] = "投稿論文送審";
$lang['paper_to_reviewing'] = "投稿論文送審";

$lang['add_most'] = "新增科技部成果報名表";
$lang['add_most_report'] = "新增科技部成果發表者資料";
$lang['add_most_file'] = "新增科技部成果電子檔資料";
$lang['update_most_report'] = "更新科技部成果發表者資料";
$lang['update_most_file'] = "更新科技部成果電子檔資料";
$lang['submit_most'] = "提交科技部成果報名表";
$lang['add_register'] = "新增研討會註冊";

$lang['update_register_status'] = "更新研討會註冊狀態";

$lang['add_conf_admin'] = "將使用者 {user_login} 設為研討會管理員身分";
$lang['del_conf_admin'] = "取消使用者 {user_login} 研討會管理員身分";
$lang['add_reviewer'] = "新增 {user_login} 為研討會審查人";
$lang['del_reviewer'] = "取消 {user_login} 為研討會審查人";

$lang['remove_paper'] = '刪除稿件 <a target="_blank" href="submit/detail/{paper_id}">#{paper_id}</a>';
$lang['update_confstyle'] = "更新研討會樣式";

$lang['add_signup_type'] = "新增繳費分類 {type_name}";
$lang['add_signup_price'] = "新增繳費項目";
$lang['update_signup'] = "更新註冊資訊";
$lang['update_signup_info'] = "更新研討會註冊資訊";
$lang['update_signup_status'] = "更新註冊 #{signup_id} 狀態";