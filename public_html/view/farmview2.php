<?php
class FarmView extends View{
	
	public function index(){
		$doc = $this->document;
		$doc->setTitle($this->lang->title);
		$doc->addLangVar($this->lang->default);

		$mysidia = Registry::get('mysidia');

		

		// Tools
		$tools = ['Shovel', 'Hoe', 'Hatchet', 'Watering can'];
		foreach ($tools as $tool) {
			$toolname = str_replace(' ','',$tool);
			$$toolname = new PrivateItem($tool, $mysidia->user->username);
			$classname = $toolname.'class';
			$$classname = 'active';
			if ($$toolname->iid == 0) { //if you don't have the item, then you can't use it obviously
				$$toolname = new Item($tool);
				$$classname = 'inactive';
			}
		}

		// Toolbox
		$doc->addLangVar("
		<div style='position:absolute;'>
			<div style='display:inline-block;vertical-align:bottom;position:relative;' class='items'>
				Toolbox<br>
				<img src='{$Shovel->imageurl}' class='$Shovelclass' id='shovel'><img src='{$Hoe->imageurl}' class='$Hoeclass' id='hoe'><img src='{$Hatchet->imageurl}' class='$Hatchetclass' id='hatchet'><img src='{$Wateringcan->imageurl}' class='$Wateringcanclass' id='watercan'>
			</div>");

		// Seeds
		$seeddb = $mysidia->db->select('inventory', [], "category='Seeds' AND owner='{$mysidia->user->username}'")->fetchAll(PDO::FETCH_CLASS, 'PrivateItem');
		if (count($seeddb)>0){
			$seedname = [];
			foreach ($seeddb as $seed) {
				$seedname[] = $seed->itemname;
			}
			$seednames = implode('\', \'',$seedname);
			$seeddb = $mysidia->db->select('items', [], "itemname IN('$seednames')")->fetchAll(PDO::FETCH_CLASS,'Item');
		}

		// Seedbox
		$doc->addLangVar('<div style=\'display:inline-block;border-left:1px solid black;\' class="items">Seedbox<br>');
		$i = 0;
		foreach ($seeddb as $seed) {
			$doc->addLangVar("<img src='{$seed->imageurl}' class='active' id='{$seed->itemname}'>");
			$i++;
			if ($i > 5) {
				$i = 0;
				$doc->addLangVar('<br>');
			}
		}
		$doc->addLangVar('</div>');

		// Farm
		$doc->addLangVar("
		<div style='background:url({$mysidia->path->getAbsolute()}picuploads/farming/farm/farmbg2.png); position:relative; height:350px; width:700px; z-index:1'>
			<div style='text-align:center;'>");

			for($i=1;$i<13;$i++) {
				if($i>6){
					$doc->addLangVar("
						<div id='plot{$i}' style='position:relative;top:150px;display:inline-block;'>
									<img src='{$mysidia->path->getAbsolute()}picuploads/farming/farm/commondirt1.png' />
						</div>");
				}
			elseif ($i==6) $doc->addLangVar('<br>');
			else{$doc->addLangVar("
			<div id='plot{$i}' style='position:relative;top:150px;display:inline-block;'>
						<img src='{$mysidia->path->getAbsolute()}picuploads/farming/farm/commondirt1.png' />
			</div>");}
		}

		$doc->addLangVar('</div></div></div>');
	}
}