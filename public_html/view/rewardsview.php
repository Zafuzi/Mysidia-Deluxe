<?php
class RewardsView extends View{

	public function index(){
		$this->document->setTitle($this->lang->title);
		$d = $this->document;

		if ($this->getField('pay') != null) {
			$pay = number_format($this->getField('pay')->getValue());
			$item = $this->getField('item');
			$d->addLangVar("{$this->lang->pay_text}
				<br><center>
				<i>Pay</i>: $pay beads<br>
				<i>Item</i>: A {$item->rarity} {$item->itemname}!<br><img src='{$item->imageurl}'><br>
				</center><br>
				{$this->lang->pay_end_text}");
			return;
		}

		$d->addLangVar($this->lang->default);
		$canGetReward = $this->getField('canGetReward')->getValue();

		if ($canGetReward == true){
			$d->addLangVar("<style type='text/css'> .paybutton{
				{$this->lang->pay_button_style}
			}</style>");
			$d->addLangVar($this->lang->can_collect_text.'<br><center><form method="post"><input class="paybutton" type="submit" name="paycheck" value="Get Paid"></form></center>');
		}else{
			$d->addLangVar($this->lang->already_paid);
		}
	}
}