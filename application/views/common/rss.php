<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<?xml version="1.0" encoding="UTF-8"?>
<rss version="2.0"
    xmlns:dc="http://purl.org/dc/elements/1.1/"
    xmlns:sy="http://purl.org/rss/1.0/modules/syndication/"
    xmlns:admin="http://webns.net/mvcb/"
    xmlns:rdf="http://www.w3.org/1999/02/22-rdf-syntax-ns#"
    xmlns:content="http://purl.org/rss/1.0/modules/content/">

<channel>
	<title><?php echo $conf_config["conf_name"]?></title>
	<atom:link href="<?php echo get_url("rss",$conf_config['conf_id']);?>" rel="self" type="application/rss+xml" />
	<link><?php echo get_url($conf_config['conf_id']);?></link>
	<description><?php echo strip_tags($conf_config["conf_desc"])?></description>
	<language>zh-TW</language>
	<dc:rights>Copyright <?php echo gmdate("Y", time()); ?></dc:rights>
	<sy:updatePeriod>hourly</sy:updatePeriod>
	<sy:updateFrequency>1</sy:updateFrequency>
	<generator><?php echo site_url()?></generator>
	<?php foreach ($conf_news as $key => $news) {?>
	<item>
		<title><?php echo $news->news_title;?></title>
		<link><?php echo get_url("news",$conf_config['conf_id']);?>#<?php echo $news->news_id;?></link>
		<pubDate><?php echo gmdate("D, d M Y H:i:s", $news->news_posted); ?> +0000</pubDate>
		<dc:creator><![CDATA[<?php echo $conf_config['conf_id'];?>]]></dc:creator>
		<guid isPermaLink="false"><?php echo get_url("news",$conf_config['conf_id']);?>#<?php echo $news->news_id;?></guid>
		<description><![CDATA[<?php echo strip_tags($news->news_content); ?>]]></description>
		<content:encoded><![CDATA[<?php echo $news->news_content;?>]]></content:encoded>
	</item>
	<?php }?>
</channel>

</rss>