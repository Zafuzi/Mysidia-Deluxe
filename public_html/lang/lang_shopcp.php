<?php

//Language variables used for AdminCP/Shop Page

$lang['default_title'] = "Manage Shops";
$lang['default'] = "Here is a list of shops you have created";
$lang['default_none'] = "Currently there is no shop available";
$lang['add_title'] = "Create a new shop";
$lang['add'] = "This page allows you to create a new shop that will be available to other users.
				Please fill in the form below and hit the <i>Create Shop</i> button below when you're ready.";
$lang['us_name_explain'] = "(This may contain only letters, numbers and spaces)";		
$lang['npc_url_explain'] = "(Use a full image path, beginning with http://)";
$lang['restrict_explain'] = "(Enter the usergroup ids that are forbidden to buy items in this shop, separated by comma)";
$lang['nrtax_explain'] = "Enter a non-negative value to determine how much tax users should pay in order to purchase from this shop (<b>the amount is in percentage %</b>)<br>If you do not wish to make non-residents pay extra, simple put ''0''";
$lang['added_title'] = "Shop created Successfully";
$lang['added'] = "A new shop, {$mysidia->input->post("us_name")}, has been added to the database successfully. You may <a href='../shopcp'>go back to the shopcp page</a>.";
$lang['edit_title'] = "Edit shop";
$lang['edit'] = "This page allows you to edit a shop that you have already created.
				 Please fill in the form below and hit the <i>Edit Shop</i> button below when you're ready.";
$lang['edited_title'] = "Shop edited Successfully";
$lang['edited'] = "The shop {$mysidia->input->post("us_name")}, has been edited successfully. You may <a href='../../shopcp'>go back to the shopcp page</a>.";
$lang['delete_title'] = "Shop Deleted";
$lang['delete'] = "You have successfully removed this shop from database.";
$lang['shopname'] = "You did not enter in a name for the shop. Please go back and try again.";	
$lang['status'] = "You did not specify a shop status. Please enter this field as open or closed";
$lang['salestax'] = "You cannot set the Non-Resident Tax to be a negative number, please go back and change it.";
$lang['duplicate'] = "A shop with the same name has already existed, please go back and change its name.";
$lang['nonexist'] = "This shop does not exist in the database.";

?>