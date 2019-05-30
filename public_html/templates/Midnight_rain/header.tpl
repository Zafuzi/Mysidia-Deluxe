<html>
<head>
<title>{$browser_title}</title>
{$header->loadFavicon("{$home}favicon.ico")}
{$header->loadStyle("{$home}{$temp}{$theme}/style.css")}
{$header->loadStyle("{$home}{$css}/menu.css")}
{$header->loadAdditionalStyle()}

<!--[if lte IE 6]>
{$header->loadStyle("{$home}{$css}/media/dropdown_ie.css")}
<![endif]-->
<!--[if lte IE 7]>
{$header->loadStyle("{$home}{$temp}{$theme}/links_ie.css")}
<![endif]-->
<!--[if lte IE 8]>
{$header->loadStyle("{$home}{$temp}{$theme}/links_ie.css")}
<![endif]-->
</head>