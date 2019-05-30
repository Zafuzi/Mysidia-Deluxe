/* =============== Need help with this? *
You can contact me (Kyttias) on AIM, GoogleTalk, Skype, Tumblr, 
DeviantART or @gmail.com. I prefer chatting over AIM, and email
is your best bet if I've not been recently active on Tumblr or
DeviantART. I can use GoogleTalk or Skype if it is of preference
to you. */



/* =============== Theme Changer */
/* Add theme drop down to top navigation. */
$(".navbar-nav").append("<li class=\"dropdown\" id=\"theme-dropdown\"> <a href=\"#\" class=\"dropdown-toggle\" data-toggle=\"dropdown\"><i class=\"icon-cogs icon-large\"><\/i> Theme<\/a>  <ul class=\"dropdown-menu\">    <li><a href=\"#\" class=\"change-style-menu-item\" rel=\"amelia\"><i class=\"icon-fixed-width icon-pencil\"><\/i> Amelia &nbsp;<\/a><\/li>    <li><a href=\"#\" class=\"change-style-menu-item\" rel=\"cerulean\"><i class=\"icon-fixed-width icon-pencil\"><\/i> Cerulean &nbsp;<\/a><\/li>    <li><a href=\"#\" class=\"change-style-menu-item\" rel=\"cosmo\"><i class=\"icon-fixed-width icon-pencil\"><\/i> Cosmo &nbsp;<\/a><\/li>    <li><a href=\"#\" class=\"change-style-menu-item\" rel=\"cyborg\"><i class=\"icon-fixed-width icon-pencil\"><\/i> Cyborg &nbsp;<\/a><\/li>    <li><a href=\"#\" class=\"change-style-menu-item\" rel=\"flatly\"><i class=\"icon-fixed-width icon-pencil\"><\/i> Flatly &nbsp; &nbsp;<\/a><\/li>    <li><a href=\"#\" class=\"change-style-menu-item\" rel=\"journal\"><i class=\"icon-fixed-width icon-pencil\"><\/i> Journal<\/a><\/li>    <li><a href=\"#\" class=\"change-style-menu-item\" rel=\"readable\"><i class=\"icon-fixed-width icon-pencil\"><\/i> Readable<\/a><\/li>    <li><a href=\"#\" class=\"change-style-menu-item\" rel=\"simplex\"><i class=\"icon-fixed-width icon-pencil\"><\/i> Simplex &nbsp;<\/a><\/li>    <li><a href=\"#\" class=\"change-style-menu-item\" rel=\"slate\"><i class=\"icon-fixed-width icon-pencil\"><\/i> Slate &nbsp; &nbsp;<\/a><\/li>    <li><a href=\"#\" class=\"change-style-menu-item\" rel=\"spacelab\"><i class=\"icon-fixed-width icon-pencil\"><\/i> Spacelab<\/a><\/li>    <li><a href=\"#\" class=\"change-style-menu-item\" rel=\"united\"><i class=\"icon-fixed-width icon-pencil\"><\/i> United &nbsp; &nbsp; &nbsp;<\/a><\/li>    <li><a href=\"#\" class=\"change-style-menu-item\" rel=\"yeti\"><i class=\"icon-fixed-width icon-pencil\"><\/i> Yeti &nbsp;<\/a><\/li>  <li><a href=\"#\" class=\"change-style-menu-back\"><i class=\"icon-fixed-width icon-pencil\"><\/i> Blank (Default) &nbsp;<\/a><\/li>  <\/ul><\/li>");

/* Change the theme by clicking on it. */
 $('body').on('click', '.change-style-menu-item', function() { /*standard themes*/
      var theme_name = $(this).attr('rel') + "/";
      var theme = "//netdna.bootstrapcdn.com/bootswatch/3.0.3/" + theme_name + "bootstrap.min.css";
      set_theme(theme);
    });
  $('body').on('click', '.change-style-menu-back', function() { /*blank theme*/
      var theme = "//netdna.bootstrapcdn.com/bootstrap/3.0.3/css/bootstrap.min.css";
      set_theme(theme);
    });
	
	/* ADD CUSTOM THEME: UNCOMMENT TO USE */
	/*Make a custom theme at StyleBootstrap.info! 
	You'll need to find the list of themes above, copy one, and it must be pasted inline with the rest. 
	Give it a custom class, and then change that class below! 
	Then all you have to do is provide a direct path to your custom css file. */
	/*
  $('body').on('click', '.CUSTOM', function() { 
      var theme = "CUSTOM.css";
      set_theme(theme);
    });	
	*/

/* Does their browser support saving the theme to local storage? */
function supports_html5_storage() {
  try { return 'localStorage' in window && window['localStorage'] !== null; } 
  catch (e) { return false; }
}
var supports_storage = supports_html5_storage();

/* Remember user theme! */	
function set_theme(theme) {
  $('link[title="bootstrap"]').attr('href', theme);
  if (supports_storage) { localStorage.theme = theme;  }
}

/* On load, grab user's preferred theme from local storage. */
if (supports_storage) {
  var theme = localStorage.theme;
  if (theme) { set_theme(theme); }
} 
  else { /* Don't annoy user with options that don't persist. */
  $('#theme-dropdown').hide();
}
/* End Theme Changer =============== */