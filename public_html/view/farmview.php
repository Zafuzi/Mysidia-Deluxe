<?php
class FarmView extends View{
	
	public function index(){
		$doc = $this->document;
		$doc->setTitle($this->lang->title);
		$doc->addLangVar($this->lang->default);

		$mysidia = Registry::get('mysidia');

		// Javascript
		$doc->addLangVar('<script type="text/javascript">
        $(function() {
				var $item = $( ".items" ),
				$plot = $( ".plot" );

    			// let the items be draggable
				$( ".active", $item ).draggable({
					revert: "invalid", // when not dropped, the item will revert back to its initial position
					containment: "document",
					helper: "clone",
					cursor: "move"
			  	});

    			// let the plots be droppable, accepting the items
				$plot.droppable({
					greedy: true,
					accept: ".active",
					activeClass: "ui-state-highlight",
					hoverClass: "ui-state-active",
					drop: function( event, ui ) {
						var plotid = $(this).attr("id");
						var result = workSoil(ui.draggable, plotid);
						$(this).html(result);
					}
				});

				function workSoil($item, $plot) {
					var id = $item.attr("id");
					plotid = $plot;
					$item.addClass("inactive").removeClass("active");

        			// Build the AJAX request
					$.ajax({
						type: "POST",
						async: false,
						url: "http://atrocity.mysidiahost.com/ajax/Farming.php",
						data: {value: id, plot:plotid},
						dataType:"JSON",
						error: function(xhr){
				            alert("An error occured: " + xhr.status + " " + xhr.statusText);
				        },
						timeout: 3000,
						success: function(response) {
							alert(response.result);
							return response.result;
						}
					});
				}
			});
		</script>');

		// CSS
		$doc->addLangVar('
			<style>
				.inactive {
					opacity: 0.4;
					filter: alpha(opacity=40);
				}
				.active {
					z-index:30;
				}

				.plot {
					border-radius: 8px;
					background: brown;
					border-bottom: 2px dashed black;
					border-top: 2px dashed black;
					position: relative;
					width: 83px;
					height: 36px;
					display:inline-block;
					padding: 10px;
					top:200px;
					z-index:2;
				}
			</style>');

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
		$doc->addLangVar("<div style='display:inline-block;border-left:1px solid black;' class='items'>Seedbox<br>");
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