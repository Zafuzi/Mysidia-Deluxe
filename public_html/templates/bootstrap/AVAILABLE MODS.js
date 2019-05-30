/* MODS */
/* Copy and paste mods over to mods-kyt.js. These are jQuery mods I've made specifically for use in this template. */



/* SMALLER ADOPTABLES ON STATS PAGE (TOP 10, RANDOM 5) */
$(window).bind("load resize", function() {
var width = $(window).width();
if(width<=766) {
if(width<=566) { 
	/*iPhone portrait and smaller*/
	$("#top10 img, #rand5 img").css("min-width","50%").css("max-width","100%");
} else { 
	/*iPhone landscape to anything smaller than iPad portrait*/
	$("#top10 img, #rand5 img").css("min-width","50%").css("max-width","70%");
} } else { 
	/*iPad portrait and larger, desktop defaults*/
	$("#top10 img, #rand5 img").css("min-width","50%").css("max-width","50%");
} });
/* END */