<?php

//Language variables used for AdminCP/Reward Page

$lang['default_title'] = "Manage Rewards";
$lang['default'] = "This page allows you to manage the rewards for promo codes you have created
				    Only admins who can edit adoptables can carry out this task.
					Use the table below to find a promocode, click the browse rewards link to view a list of rewards available for this promocode. 
                    In the browse rewardspage, you may add/remove rewards for a given promocode as well.";
$lang['browse_title'] = "Browse rewards for promocode";
$lang['browse'] = "This page allows you to browse available rewards for promocode, and create/remove these rewards at any time.
					Use the table below to view/delete a reward for your promocode, or click the following link to generate a new reward for this promocode.
					<br /><br /><b><a href='../add/{$mysidia->input->get("promo")}'><img src='../../../templates/icons/add.gif' border=0>Create a New Reward</a></b>";
$lang['add_title'] = "Create a new reward for promocode";
$lang['add'] = "This page allows you to create a new reward for the promocode you have created.
				      Please fill in the form below and hit the <i>Create Reward</i> button below when you're ready to complete this action.";
$lang['added_title'] = "Reward Created Successfully";
$lang['added'] = "Your Reward has been created successfully for this promocode. You can now <a href='../../reward'>return to the reward list page.";
$lang['delete_title'] = "Reward Deleted";
$lang['delete'] = "This reward has been erased.";
$lang['type'] = "You have not selected the reward type(adoptable or item), please return to previous page and complete this action.";
$lang['quantity'] = "The field quantity ust be a positive integer...";
$lang['reward'] = "You have not specified the adoptable/item a user can obtain through this reward, way to go being an evil admin.";
$lang['nonexist'] = "The Reward does not exist in database.";

?>