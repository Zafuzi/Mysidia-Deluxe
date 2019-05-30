<html>
<head>
<title>{$browser_title}</title>
{$header->loadFavicon("{$home}favicon.ico")}
{$header->loadStyle("{$home}{$temp}{$theme}/media/acp-style.css")}
{$header->loadScript("http://ajax.googleapis.com/ajax/libs/jquery/1.3.2/jquery.min.js")}
{$header->loadScript("{$home}{$js}/acp.js")}
{$header->loadStyle("{$home}{$css}/tooltip.css")}
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script> 
<script src="{$home}{$js}/tooltip.js"></script>
<script src="{$home}{$js}/tabs.js"></script>
<script>
$(function() { $("#profile").organicTabs(); });
</script>
</head>