/* =============== Hello! *
This file is being used to modify Mysidia's base coding without
touching it, all so it's base HTML can match up with Bootstrap.
This file is necessary to use this template! It adds classes to
the top navigation menu, makes both it and the sidebar mobile
friendly, and changes adds classes to default buttons, inputs,
and other page elements that are hard-coded into Mysidia via PHP.

I recommend NOT changing this file unless you know how!
*/

/* =============== Need help with this template? *
You can contact me (Kyttias) on AIM, GoogleTalk, Skype, Tumblr, 
DeviantART or @gmail.com. I prefer chatting over AIM, and email
is your best bet if I've not been recently active on Tumblr or
DeviantART. I can use GoogleTalk or Skype if it is of preference
to you. */

/* =============== jQuery Syntax Example *
$( selector ).event(function() {
    $( selector ).effect( parameters );
});
* End Example =============== */



/* =============== Top Navigation */
$(".ddmenu ul:first").addClass("nav navbar-nav");
$(".ddmenu ul:first-child li").addClass("dropdown");
$(".ddmenu ul:first-child li a").addClass("dropdown-toggle"); 
$(".ddmenu ul li .hides a").removeClass("dropdown-toggle"); 
$(".ddmenu ul li").removeClass("hides");
$(".ddmenu ul li ul").addClass("dropdown-menu"); 
$(".dropdown-menu li").removeClass("dropdown"); 	
/* End Top Navigation =============== */



/* =============== Sidebar */
$(".sidebar").addClass("text-center");
$(".sidebar ul li").addClass("btn-group btn-primary");
$(".sidebar ul li a").addClass("btn btn-primary").css('border','0px');
$(window).bind("load resize", function() {
var width = $(window).width();
if(width <= 766) {
	if(width<=566){	/*iPhone portrait and smaller*/ 
				$(".sidebar ul").addClass("btn-group-vertical");
				$(".sidebar ul").removeClass("btn-group");
				$("#theme-dropdown").hide(); 		
		} else { 	/*iPhone landscape to anything smaller than iPad portrait*/ 
				$(".sidebar ul").removeClass("btn-group-vertical");
				$(".sidebar ul").addClass("btn-group");
				$("#theme-dropdown").hide(); 
		} } else { 	/*iPad portrait and larger, desktop defaults*/ 
			$(".sidebar ul").addClass("btn-group-vertical");
			$(".sidebar ul").removeClass("btn-group");
			$("#theme-dropdown").show();
} });
/* End Sidebar =============== */



/* =============== Buttons */
$("button, input:button").addClass("btn btn-default");
$("#submit").addClass("btn btn-primary");
/* End Buttons =============== */



/* =============== Form Inputs */
$("form").attr("role","form");
$("input").addClass("form-control");
$(":checkbox").removeClass("form-control").css("width","");
$(":radio").removeClass("form-control").css("width","");
$("select").addClass("form-control");
$("textarea").addClass("form-control");
/* End Form Inputs =============== */



/* =============== Tables */
$("table").addClass("table table-hover table-condensed");
$("table td").css("vertical-align","middle");
/* End Tables =============== */



/* =============== Profile Page */
$("#page-wrap").addClass("panel panel-default");
$("#profile .nav").addClass("nav-pills");
$("#profile .nav a").attr("data-toggle", "tab");
$("#profile .nav a").removeClass("current");
$("#profile .list-wrap").addClass("tab-content");
$("#profile .tab-content ul").removeClass("hide");
$("#profile .tab-content ul").addClass("tab-pane");
$("#profile .tab-content ul:nth-child(2)").addClass("active");
/* End Profile Page =============== */

/* = TO DO:
- swap out icons in Manage Adopts, Trade Center, Members List, etc
- swap out social networking icons in the Profile
- remove MSN from contact info in the Profile, add Tumblr?
- remove carets entirely, at least until I can place them only on drop downs
- wrap Search form elements in .form-groups divs 
*/