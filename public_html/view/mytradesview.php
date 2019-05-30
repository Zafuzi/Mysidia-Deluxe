<?php

use Resource\Native\String;
use Resource\Collection\LinkedList;

class MytradesView extends View{
	
	public function index(){
	    $mysidia = Registry::get("mysidia");
		$document = $this->document;
		$document->setTitle($mysidia->user->username.$this->lang->title);		
        $document->addLangvar($this->lang->default.$this->lang->warning);
		$stmt = $this->getField("stmt")->get();
        		
		$tradeTable = new TableBuilder("tradetable", 700);
		$tradeTable->setAlign(new Align("center", "middle"));
		$tradeTable->buildHeaders("ID", "Sender", "Adopt Offered", "Adopt Wanted", "Item Offered", "Item Wanted", "Cash Offered", "Message", "Accept", "Decline");
        $tradeHelper = $this->getField("tradeHelper");
        $tradeHelper->setView($this);	

        $path = $mysidia->path->getAbsolute().'picuploads/trades/';
		$document->addLangvar("<style>
			* { 
			    -moz-box-sizing: border-box; 
			    -webkit-box-sizing: border-box; 
			     box-sizing: border-box; 
			}

			.tradebg {
				background:url({$path}bg.png);
				background-size: 100% 100%;
    			background-repeat: no-repeat; 
				position:relative; 
				padding: 40px;
			}

			.postit {
				height: 162px;
				width: 100px;
				display:inline-block;
				padding-top: 18%;
			}

			.postititem {
				background-size: 100% 100%;
				height: 92px;
				width: 75px;
				display:inline-block;
			}

			.tinypostit {
				background:url({$path}yellowpostit.png);
				background-size: 100% 100%;
    			background-repeat: no-repeat; 
				height: 50px;
				width: 50px;
				display:inline-block;
				padding-top: 25%;
			}
		</style>");
		
		while($tid = $stmt->fetchColumn()){
		    $trade = new TradeOffer($tid);
			$cells = new LinkedList;
		    $cells->add(new TCell("<div class='tinypostit'>$tid</div>"));
		    $sender = $trade->getSender('model');
			$cells->add(new TCell("<div class='postit' style='background:url({$path}pinkpostit.png);background-size: 100px 162px;'>{$sender->username}<br>{$sender->getAvatar(80)->render()}</div>"));
			$class = 'postit';
			if ($trade->getAdoptOffered() == null) $class = null;
			$cells->add(new TCell("<div class='$class' style='background:url({$path}greenpostit.png);background-size: 100px 162px;'>{$tradeHelper->getAdoptImages($trade->getAdoptOffered())->render()}</div>"));
			$class = 'postit';
			if ($trade->getAdoptWanted() == null) $class = null;
			$cells->add(new TCell("<div class='$class' style='background:url({$path}orangepostit.png);background-size: 100px 162px;'>{$tradeHelper->getAdoptImages($trade->getAdoptWanted())->render()}</div>"));			
			$cells->add(new TCell("<div class='postititem' style='background:url({$path}greenpostit.png);background-size: 80px 100px;background-repeat: no-repeat; '>{$tradeHelper->getItemImages($trade->getItemOffered())->render()}</div>"));
			$cells->add(new TCell("<div class='postititem' style='background:url({$path}orangepostit.png);background-size: 80px 100px;background-repeat: no-repeat; '>{$tradeHelper->getItemImages($trade->getItemWanted())->render()}</div>"));	
			$cash = $trade->getCashOffered();
			if ($cash <= 0) {
				$cash = "<img src='/picuploads/trades/postitx.png' height='100px' width='80px'>";
			}	
			$cells->add(new TCell("<div class='postititem' style='background:url({$path}purplepostit.png);background-size: 80px 100px;background-repeat: no-repeat;'>{$cash}</div>"));			
			$cells->add(new TCell("<div class='postit' style='background:url({$path}yellowpostit.png);background-size: 100px 162px;'>{$trade->getMessage()}</div>"));
			$cells->add(new TCell(new Link("mytrades/accept/{$tid}", new Image("templates/icons/yes.gif"))));
			$cells->add(new TCell(new Link("mytrades/decline/{$tid}", new Image("templates/icons/delete.gif"))));
			$tradeTable->buildRow($cells);
		}		
		$document->addLangvar('<div class="tradebg"><br>');
		$document->add($tradeTable);	
		$document->addLangvar('<br><br></div>');
	}
			
	public function accept(){
		$mysidia = Registry::get("mysidia");		
		$document = $this->document;	
		if((string)$mysidia->input->get("confirm")){
            $document->setTitle($this->lang->accepted_title);	   
            $document->addLangvar($this->lang->accepted); 			
		    return;
		}
		
		$document->setTitle($this->lang->accept_title);		
        $document->addLangvar($this->lang->accept);
		$tradeOffer = $this->getField("tradeOffer");
        $tradeHelper = $this->getField("tradeHelper");
        $tradeHelper->setView($this);	
 
        $document->addLangvar($this->lang->review);
        $document->add(new Image("templates/icons/warning.gif"));
		$document->add(new Comment($this->lang->review_partner.$tradeOffer->getSender(), TRUE, "b"));
        $document->add(new Comment);
        $document->add(new Image("templates/icons/next.gif"));
        $document->addLangvar($this->lang->review_adoptoffered);
        $document->add($tradeHelper->getAdoptImages($tradeOffer->getAdoptOffered(), FALSE));
        $document->add(new Image("templates/icons/next.gif"));        
		$document->addLangvar($this->lang->review_adoptwanted);
        $document->add($tradeHelper->getAdoptImages($tradeOffer->getAdoptWanted(), FALSE)); 

		$document->add(new Image("templates/icons/next.gif"));
        $document->addLangvar($this->lang->review_itemoffered);
        $document->add($tradeHelper->getItemImages($tradeOffer->getItemOffered(), FALSE));        
		$document->add(new Image("templates/icons/next.gif"));
        $document->addLangvar($this->lang->review_itemwanted);
        $document->add($tradeHelper->getItemImages($tradeOffer->getItemWanted(), FALSE)); 

        $document->add(new Image("templates/icons/next.gif"));
        $document->addLangvar($this->lang->review_cashoffered.$tradeOffer->getCashOffered()." ".$mysidia->settings->cost);
        $document->add(new Comment("<br>"));
        $document->add(new Image("templates/icons/warning.gif"));
		$document->addLangvar($this->lang->review_message);
		$document->add(new Paragraph(new Comment($tradeOffer->getMessage(), TRUE, "b")));	
		$document->add(new Link("mytrades/accept/{$mysidia->input->get("tid")}/confirm", "Yes, I confirm my action!", TRUE));
		$document->add(new Link("mytrades", "No, take me back to the tradeoffer list."));
	}
	
	public function decline(){
	    $mysidia = Registry::get("mysidia");
		$document = $this->document;
		if((string)$mysidia->input->get("confirm")){
		    $document->setTitle($this->lang->declined_title);
		    $document->addLangvar($this->lang->declined);
		    $document->add(new Link("mytrades", "Click here to see all of your pending trade requests."));	
            return;	
		}
        $document->setTitle($this->lang->decline_title);
        $document->addLangvar($this->lang->decline);
		$document->add(new Link("mytrades/decline/{$mysidia->input->get("tid")}/confirm", "Yes, I confirm my action!", TRUE));
		$document->add(new Link("mytrades", "No, take me back to the tradeoffer list."));
	}
}
?>