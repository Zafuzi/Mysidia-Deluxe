<!-- / / / / / / / / / / Need help with this template?
You can contact me (Kyttias) on AIM, GoogleTalk, Skype, Tumblr, 
DeviantART or @gmail.com. I prefer chatting over AIM, and email 
is your best bet if I've not been recently active on Tumblr or
DeviantART. I can use GoogleTalk or Skype if it is of preference
to you. -->

<!DOCTYPE html>
<html lang="en"><head>
<script src="{$home}{$temp}{$theme}/flickerfix-kyt.js""></script>
<title>{$browser_title}</title>
 <meta name="viewport" content="width=device-width, initial-scale=1.0">
 <!-- / / / / / / / / / FULL CSS RESET -->
 <link href="//cdnjs.cloudflare.com/ajax/libs/meyer-reset/2.0/reset.css" rel="stylesheet">
 <!-- / / / / / / / / / BOOTSTRAP 3 -->
 <link href="//netdna.bootstrapcdn.com/bootstrap/3.0.3/css/bootstrap.min.css" rel="stylesheet" title="bootstrap">
 <!-- 
 If you picked out a theme from BootSwatch, find it on BootstrapCDN.com and replace the link above.
 If using themeswitcher.js, make sure the line above always includes title="bootstrap" as an attribute!
 If you make a custom Bootstrap theme at StyleBootstrap.info, observe the lines below as a hint on how to include it.
 Replace the href above if you prefer to use a custom theme with the theme changer, or, delete the line above,
 and include in the same manner as the stylesheet is below. {$home}{$temp}{$theme} is this template folder!
 -->
{$header->loadFavicon("{$home}favicon.ico")}
{$header->loadStyle("{$home}{$temp}{$theme}/style.css")}
{$header->loadAdditionalStyle()}
<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->
    {$header->loadStyle("{$home}{$css}/tooltip.css")}
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script> 
<script src="{$home}{$js}/tooltip.js"></script>
<script src="{$home}{$js}/tabs.js"></script>
<script>
$(function() { $("#profile").organicTabs(); });
</script>
</head>

