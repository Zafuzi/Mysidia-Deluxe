<?php

//Language variables used for Inventory Page

$lang['inventory'] = "Here is the list of every item you own";
$lang['inventory_empty'] = "You currently do not have any items in inventory.";
$lang['select_title'] = "Select an adoptable";
$lang['select'] = "Now you need to choose an adoptable to use this item:<br>";
$lang['item_error'] = "An error has occurred while manipulating item";
$lang['use_none'] = "It appears that you do not have this item in your inventory.";
$lang['use_fail'] = "It seems that item can not be used on the adoptable selected.";
$lang['use_effect'] = "The item refuses to take effect, what a waste of money and effort!";
$lang['sell_empty'] = "<center><img src='http://atrocity.mysidiahost.com/picuploads/png/839b3b4b99ff8ce7091a5583e56f62d9.png'><br><b>Ace says:</b> You have yet to specify the quantity of items to sell Stranger...</center><br>";
$lang['sell_none'] = "<center><img src='http://atrocity.mysidiahost.com/picuploads/png/839b3b4b99ff8ce7091a5583e56f62d9.png'><br><b>Ace says:</b>It appears that you do not have this item in your inventory Stranger... Find it and try again.</center>";
$lang['sell_quantity'] = "<center><img src='http://atrocity.mysidiahost.com/picuploads/png/839b3b4b99ff8ce7091a5583e56f62d9.png'><br><b>Ace says:</b>It seems that you wish to sell more items than you actually own, Stranger.</center><br>"; 
$lang['sell'] = "<center><img src='http://atrocity.mysidiahost.com/picuploads/png/d55cbf264ea3da4cfa5a4d89a425aa4b.png'><br><b>Ace says:</b> Thank you for selling your $qty $item ";
$lang['sell2'] = "For {$mysidia->input->post("priced")} {$mysidia->settings->cost} each, Stranger!<br> <a href='http://atrocity.mysidiahost.com/inventory'> Go back to your inventory</a><br></center>"; 
$lang['toss_confirm'] = "Confirm your Action"; 
$lang['toss_warning'] = "Are you sure you wish to toss {$mysidia->input->post("itemname")}?<br> 
	                     It will be permanently removed from your inventory, and this action cannot be undone!<br>";
$lang['toss_none'] = "It appears that you do not have this item in your inventory.";					 
$lang['toss'] = "You have successfully removed ";
$lang['toss2'] = " from your inventory.";
$lang['alchemy_title'] = "Welcome to the Alchemy Service";
$lang['alchemy'] = "Here you can use the powerful alchemy system to merge two of your items to produce a new item, whether brand new or not. 
                    Fill in the form below to start using this service we offer, you may find plenty of surprises!";
$lang['alchemy_choose'] = "To begin with, select the first ingredient item from the list: ";
$lang['alchemy_choose2'] = "Now select the second ingredient item from the list: ";
$lang['alchemy_choose3'] = "Now select the third ingredient item from the list: (optional)";
$lang['alchemy_choose4'] = "Now select the fourth ingredient item from the list: (optional)";
$lang['alchemy_choose5'] = "Now select the fifth ingredient item from the list: (optional)";

$lang['alchemy_disabled'] = "Unfortunately the admin has disabled the Alchemy System for this site, you may send him/her a message for more information.";
$lang['alchemy_success'] = "Congratulations!";
$lang['alchemy_newitem'] = "You have successfully produced a new item "; 
$lang['alchemy_newitem2'] = " by using Alchemy, sweet isnt it? You may now manage it in your inventory, or continue to use the alchemy system.";
$lang['alchemy_invalid'] = "The specified item combination is invalid, it does not produce a new item...";
$lang['alchemy_empty'] = "You have not entered two valid items for doing alchemy.";
$lang['alchemy_insufficient'] = "You do not have the necessary items for producing a new item through alchemy.";
$lang['alchemy_chance'] = "The alchemy fails! How unfortunate, maybe you wanna try again with better effort?";
$lang['alchemy_cost'] = "Apparently you do not have enough money to afford the alchemy service, please come back later.";
$lang['alchemy_license'] = "You appear to lack the license required to perform alchemy, please make sure you have the license in your inventory first.";
$lang['alchemy_recipe'] = "It seems that you do not have the recipe to produce an item from the two selected items.";
$lang['alchemy_usergroup'] = "Unfortunately, the admin has specified that only certain users can perform alchemy, you may consult him/her by sending a message.";

?>