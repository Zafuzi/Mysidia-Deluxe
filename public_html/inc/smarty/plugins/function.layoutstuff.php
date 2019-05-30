<?php
use services\FavPet\FavPet;

function smarty_function_layoutstuff($params, Smarty_Internal_Template $template) {
	$f = new FavPet();
	$template->assign('favpet', $f->display());

	$mysidia = Registry::get("mysidia");

	// Get Who's Online
	$all = $mysidia->db->select("online", array('username'));
	$total = $all->rowCount();
	$allMembers = $all->fetchAll(PDO::FETCH_ASSOC);
	$memberArray = array_count_values(array_column($allMembers,'username'));

	$visitors = 0;
	if (isset($memberArray['Visitor']))	$visitors = $memberArray['Visitor'];
	$members = $total-$visitors;

	$display = 'There ';
	if ($members == 1) $display .= 'is 1 member';
	else $display .= 'are '.$members.' members';

	if ($visitors == 1) $display .= ' and 1 guest';
	elseif ($visitors > 1) $display .= ' and '.$visitors.' guests';
	$template->assign('wol', $display.' online.');

	// Decide if user is logged in or not
	if (!$mysidia->user->isloggedin) {
		$template->assign('logged_in', false);
		$template->assign('avatar', null);
		$template->assign('acp', null);
		$template->assign('money', null);
		$template->assign('messages',null);
		$template->assign('trades',null);
		return;
	}
	$template->assign('logged_in', true);

	$profile = $mysidia->user->getprofile();
	$avatar = new Image($profile->getAvatar(), "avatar image", 100);

	$template->assign('avatar', "<a href='/profile/view/{$mysidia->user->username}'>{$avatar->render()}</a>");
	$template->assign('money', number_format($mysidia->user->money));		$template->assign('premiumcurrency', number_format($mysidia->user->premiumcurrency));	if($mysidia->user->news_notify==1){$template->assign('newsnotice', "<div align='center'><div style='border:1px solid black;background-color:green;width:300px;text-align:center;vertial-align:center;color:#fff;'><img src='/templates/icons/news1.png' /><a href='/news' style='color:#fff;'>Finny has a new news post for you!</a><img src='/templates/icons/news1.png' /></div></div>");}	else{$template->assign('newsnotice',null);}

	$numMessages = $mysidia->db->select("messages", array("touser"), "touser='{$mysidia->user->username}' and status='unread'")->rowCount();
	$template->assign('messages', $numMessages);

	$numTrades = $mysidia->db->select("trade", array("status"), "recipient='{$mysidia->user->username}' and status='pending'")->rowCount();
	$template->assign('trades', $numTrades);

	$acp = null;
	if($mysidia->user instanceof Admin)
	{
		$acp = '<a href="/admincp">Admin Control Panel</a>';
	}
	$template->assign('acp', $acp);
}