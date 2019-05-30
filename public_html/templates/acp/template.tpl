{include file="{$root}{$temp}{$theme}/header.tpl"}

<body>
<table cellpadding="0" cellspacing="0">
<tr><td colspan="2" class="banner"><center>
<img src="http://i40.tinypic.com/64gk1k.jpg" alt="Mysidia PHP Adoptables" title="Mysidia Adoptables" />
</center></td></tr>
<tr><th width="25%" id="logo"><strong>MyMysidia</strong> Admin</th>
<th id="admin">Welcome Admin!</th></tr>
<tr><td width="25%" id="menu">{$sidebar}</td>
<td id="content">
 
<!-- Let's Hide This For Now
// <div id="stats">
// <center><strong>{$site_name} Statistics</strong></center>
// <p><span><a href="#">00</a> Adoptables</span><span><a href="#">00</a> Users</span></p>
// <p><span><a href="#">00</a> Items</span><span><a href="#">00</a> Shops</span></p>
// <p><span><a href="#">00</a> Pages</span><span><a href="#">00</a> Advertisers</span></p>
// <p><span><a href="#">00</a> Admin</span><span><a href="#">00</a> Artists</span></p>
// <p><span><a href="#">Site Index</a></span><span><a href="#">My Messages</a></span></p>
// <p><span><a href="#">Help Desk</a></span><span><a href="#">Site Logs</a></span></p>
// </div>
// 
-->
<p><font size="5"><b>{$document_title}</b></font></p><hr>
<p>{$document_content}</p>
</td></tr>
</table>

<center><b>MyMysidia</b> Powered By <a href="http://mysidiaadoptables.com">Mysidia Adoptables</a> &copy;Copyright 2011-2013.</center>
<script src="//cdn.jsdelivr.net/jquery/1.10.0/jquery.min.js"></script>
{$header->loadStyle("{$home}{$css}/tooltip.css")}
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script> 
<script src="{$home}{$js}/tooltip.js"></script>
<script src="{$home}{$js}/tabs.js"></script>
<script>
$(function() { $("#profile").organicTabs(); });
</script>

</body>
</html>