{include file="{$root}{$temp}{$theme}/header.tpl"}

<body>
 <!-- / / / / / / / / / PAGE WRAP -->
<div id="wrap">
 <!-- / / / / / / / / / TOP NAVIGATION -->
<nav class="navbar navbar-default navbar-fixed-top" role="navigation">
  <!-- Site Name and Toggle Button -->
  <div class="navbar-header" style="margin-left: 10%;">
    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
      <span class="sr-only">Toggle navigation</span>
      <span class="icon-bar"></span>
      <span class="icon-bar"></span>
      <span class="icon-bar"></span>
    </button>
	<a class="navbar-brand" href="{$path}index">{$site_name}</a>
  </div>
  <!-- Responsive Toggle -->
  <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1"> 
  <!-- ddmenu -->
  {$menu} 
  </div> 
  </nav>
 <!-- TOP NAVIGATION END / / / / / / / / / -->

 <!-- / / / / / / / / / SIDEBAR -->
 
<div class="col-sm-3" style="margin-top: 65px;">
<div class="panel panel-default" style="padding: 10px;">
{if rand(0,500) <= 5} {$giftbox} {/if}
{$sidebar}
</div>
</div>
 <!-- SIDEBAR END / / / / / / / / / -->

 <!-- / / / / / / / / / CONTENTS --> 
<div class="col-xs-12 col-sm-9" style="margin-top: 50px;">
<h2>{$document_title}</h2>
<p>	{$document_content}</p>
</div>
 <!-- CONTENTS END / / / / / / / / / -->

</div>
 <!-- PAGE WRAP END / / / / / / / / / -->

 <!-- / / / / / / / / / FOOTER -->
<div id="footer" class="container text-center" style="padding: 0px; margin: 10px;">
{$footer}
</div>
 <!-- FOOTER WRAP END / / / / / / / / / --> 

<!-- / / / / / / / / / SCRIPT LINKS --> 
	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script> <!-- REQUIRED -->
	<script src="//netdna.bootstrapcdn.com/bootstrap/3.0.3/js/bootstrap.min.js"></script> <!-- REQUIRED -->
	<script src="{$home}{$temp}{$theme}/js-kyt.js"></script> <!-- REQUIRED -->
	<script src="{$home}{$temp}{$theme}/mods-kyt.js"></script>

<!-- Theme Switcher - comment out this line to remove: -->
<script src="{$home}{$temp}{$theme}/themeswitcher-kyt.js"></script>
<!-- End Theme Switcher -->
<!-- INCLUDE YOUR JQUERY PLUGINS AND MODS BELOW THIS LINE -->

<!-- SCRIPT LINKS END / / / / / / / / / --> 
 
</body></html> 