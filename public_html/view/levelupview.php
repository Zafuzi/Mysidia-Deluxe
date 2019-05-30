<?php

use Resource\Collection\ArrayList;
use Resource\Utility\Curl;

class LevelupView extends View{

	public function click(){
	    $mysidia = Registry::get("mysidia");
		$document = $this->document;
        $adopt = $this->getField("adopt");
		$reward = $this->getField("reward")->getValue();
		$document->setTitle("{$this->lang->gave} {$adopt->getName()} one {$this->lang->unit}");
		$document->add(new Link("levelup/daycare", "Go to the Daycare list", TRUE));
		$document->add(new Link("levelup/raising", "Go to the Raising list", TRUE));
		$image = $adopt->getImage("gui");
		$summary = new Division;
		$summary->setAlign(new Align("center"));
        $summary->add(new Comment($image));
        $summary->add(new Comment("{$this->lang->gave}{$adopt->getName()} one {$this->lang->unit}."));
        $summary->add(new Comment($this->lang->encourage));
        $summary->add(new Comment("<a href='/pet/profile/{$adopt->aid}'>Click here to view {$adopt->getName()}'s profile.</a>"));
        $summary->add(new Comment("<br> You have earned {$reward} {$mysidia->settings->cost} for leveling up this adoptable. "));
        $summary->add(new Comment("You now have {$mysidia->user->getcash()} {$mysidia->settings->cost}"));
        $document->add($summary);	
        $dropstatus = $this->getField("dropstatus")->getValue();
        if($dropstatus == 1){
            $dropitem = $this->getField("dropitem");
            $document->addLangvar("<br>Congratulations, you have acquired item {$dropitem->itemname} after leveling up this adoptable."); 
        }
        else $document->addLangvar("<br>Unfortunately no item is dropped from this adoptable this time, you have to try again.");  
	}

	public function siggy(){

	}

	public function daycare(){
		$mysidia = Registry::get("mysidia");
		$document = $this->document;
        $document->setTitle($this->lang->daycare_title);
        $document->addLangvar($this->lang->daycare, TRUE);

		$daycare = $this->getField("daycare");
    //    $adopts = $daycare->getAdopts();
		$daycareTable = new Table("daycare", "", FALSE);
		$daycareTable->setBordered(FALSE);

        // New method call
        $adopts = $daycare->joinedListing();

        $total = $daycare->getTotalAdopts();
        $index = 0;

        for($row = 0; $row < $daycare->getTotalRows(); $row++){
	        $daycareRow = new TRow("row{$row}");
            for($column = 0; $column < $daycare->getTotalColumns(); $column++){
			//    $adopt = new OwnedAdoptable($adopts[$index]);
                $adopt = $adopts[$index];
				$cell = new ArrayList;
			    //$cell->add(new Link("levelup/click/{$adopt->getAdoptID()}", $adopt->getImage("gui"), TRUE));
			    //$cell->add(new Comment($daycare->getStats($adopt)));
                $cell->add(new Link("levelup/click/{$adopt['aid']}", "<div style='background:url({$mysidia->path->getAbsolute()}/picuploads/nest{$index}.png); position:relative; height:263px; width:163px'><div style='position:absolute;top:55px;left:4px;z-index:2'><img src='{$daycare->getImageFromArray($adopt)}'></div>", TRUE));
                $cell->add(new Comment("<div style='position:absolute;top:224px;left:24px;z-index:2;width:100px;text-align:center;'><b>". $daycare->getStatsFromArray($adopt) . '</b></div></div>'));

				$daycareCell = new TCell($cell, "cell{$index}");
                $daycareCell->setAlign(new Align("center", "center"));
				$daycareRow->add($daycareCell);
				$index++;
				if($index == $total) break;
            }
            $daycareTable->add($daycareRow);
		}

        $document->add($daycareTable);
		if($pagination = $daycare->getPagination()) $document->addLangvar($pagination->showPage());
	}
	
	
	public function raising(){
		$mysidia = Registry::get("mysidia");
		$document = $this->document;
        $document->setTitle($this->lang->raising_title);
        $document->addLangvar($this->lang->raising, TRUE);

		$raising = $this->getField("raising");
    //    $adopts = $raising->getAdopts();
		$raisingTable = new Table("raising", "", FALSE);
		$raisingTable->setBordered(FALSE);

        // New method call
        $adopts = $raising->joinedListing();

        $total = $raising->getTotalAdopts();
        $index = 0;

        for($row = 0; $row < $raising->getTotalRows(); $row++){
	        $raisingRow = new TRow("row{$row}");
            for($column = 0; $column < $raising->getTotalColumns(); $column++){
			//    $adopt = new OwnedAdoptable($adopts[$index]);
                $adopt = $adopts[$index];
				$cell = new ArrayList;
			//	$cell->add(new Link("levelup/click/{$adopt->getAdoptID()}", $adopt->getImage("gui"), TRUE));
			//	$cell->add(new Comment($raising->getStats($adopt)));
                $cell->add(new Link("levelup/click/{$adopt['aid']}", "<div style='background:url({$mysidia->path->getAbsolute()}/picuploads/nest{$index}.png); position:relative; height:263px; width:163px'><div style='position:absolute;top:55px;left:4px;z-index:2'><img src='{$raising->getImageFromArray($adopt)}'></div>", TRUE));
                $cell->add(new Comment("<div style='position:absolute;top:224px;left:24px;z-index:2;width:100px;text-align:center;'><b>". $raising->getStatsFromArray($adopt) . '</b></div></div>'));

				$raisingCell = new TCell($cell, "cell{$index}");
                $raisingCell->setAlign(new Align("center", "center"));
				$raisingRow->add($raisingCell);
				$index++;
				if($index == $total) break;
            }
            $raisingTable->add($raisingRow);
		}

        $document->add($raisingTable);
		if($pagination = $raising->getPagination()) $document->addLangvar($pagination->showPage());
	}
}