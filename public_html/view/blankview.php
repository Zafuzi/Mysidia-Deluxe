<?php
class BlankView extends View{
	
	public function index(){
		$mysidia = Registry::get("mysidia");
		/*
		$items = $mysidia->db->select('items')->fetchAll();
		foreach ($items as $item) {
			$description = trim($item['description']);
			$category = trim(ucwords($item['category']));
			$name = ucwords(trim($item['itemname']));
			$name = str_replace(['And ', 'To ', 'Of ', 'In ', 'A '], ['and ', 'to ', 'of ', 'in ', 'a '], $name);
			$name = ucfirst($name);
			$mysidia->db->update('items', ['itemname'=>$name,'description'=>$description, 'category'=>$category], 'id='.$item['id']);
		}*/

		$document = $this->document;
		$document->setTitle(' ');						echo 'SESSION '.$_SESSION['5743e0bd733e9usr_name']. ' -- '.$_SESSION['5743e0bd733e9usr_ses_id'];
//SESSION Array ( [5743e0bd733e9xhash] => d51748dd50cf0e016508e5f4432f7795 [5743e0bd733e9rtl] => [5743e0bd733e9freistatus] => 1 [5743e0bd733e9custom_mesg] => I am available [5743e0bd733e9in_room] => -1 [5743e0bd733e9gst_nam] => Guest-1wwq [5743e0bd733e9gst_ses_id] => 1525246286 [5743e0bd733e9time] => 1524857022 [5743e0bd733e9is_guest] => 0 [5743e0bd733e9usr_name] => Je Vous Defie [5743e0bd733e9usr_ses_id] => 87 [5743e0bd733e9is_banned] => [5743e0bd733e9isset_freichatx] => 0 [5743e0bd733e9is_cached] => 1 [5743e0bd733e9FreiChatX_init] => 1 [5743e0bd733e9main_loaded] => 1 [5743e0bd733e9room_created] => 1524857022 )
		$image = Registry::get('cImage');

		$breeding = new services\ColorBreeding\ColorBreeding();

		$speciesArray = ['Hounda', 'Feesh', 'Catari'];
		$species = $speciesArray[array_rand($speciesArray)];
		//$species = 'Feesh';

		$image->setSpecies($species);
		$image->setGender('m');
		$image->random();
		
		$genetics = '{"species":"Catari","colors":[[147,42,104],[130,79,97],[89,69,82],[79,54,144],[80,136,78],[41,54,28],[120,75,110],[132,109,63],[127,77,58],[40,74,54],[39,131,85],[55,42,34],[46,87,67],[108,136,74],[95,124,48],[110,21,53],[126,52,63],[14,33,40],[140,69,16],[97,125,95],[95,19,82],[129,113,82],[44,86,61],[57,80,45],[77,131,113],[100,76,71],[62,30,86],[37,78,59],[146,154,63],[82,79,52],[133,143,53],[73,111,42],[112,92,24],[85,101,169],[88,137,55]],"genes":{"egg":{"dominant":[1,1]},"cracked egg":{"dominant":[1,1]},"bodies":{"dominant":[1,1]},"noses":{"dominant":[1,1]},"eyes":{"recessive":[2],"dominant":["1-1"]},"tails":{"recessive":[8],"dominant":[5]},"ears":{"dominant":[2,1]}}}';
		$genetics2 = '{"species":"Catari","colors":[[214,88,141],[180,130,121],[221,181,160],[173,112,252],[207,250,211],[120,126,11],[138,175,144],[142,103,122],[131,164,72],[104,100,81],[4,163,208],[96,102,19],[120,89,37],[172,235,181],[61,249,56],[146,27,86],[177,148,34],[5,95,17],[204,157,43],[196,231,165],[98,46,75],[230,89,88],[80,180,24],[73,195,69],[40,252,228],[164,52,3],[183,38,78],[22,127,159],[254,220,55],[199,11,129],[208,209,146],[43,200,54],[162,106,37],[237,106,252],[70,175,162]],"genes":{"egg":{"dominant":[1,1]},"cracked egg":{"dominant":[1,1]},"bodies":{"dominant":[1,1]},"noses":{"dominant":[1,1]},"eyes":{"dominant":["1-1"],"recessive":[2]},"tails":{"dominant":[4,5]},"ears":{"dominant":[2,2]}},"overrides":[]}';

		$image2 = new services\Image\ColorImage();
		$image2->setSpecies($species);
		$image2->setGender('f');
		$image2->random();
		$child = $breeding->breed(['sire'=>$image->genetics,'dam'=>$image2->genetics]);
/*
		echo '<pre>';
		print_r($image->genetics);
		echo '<br><hr><br>';
		print_r($image2->genetics);
		echo '</pre>';
*/
	//	$child = $breeding->breed(['sire'=>json_decode($genetics,true),'dam'=>json_decode($genetics2,true)]);
	//	ddd($child,json_decode($genetics,true),json_decode($genetics2,true));

		$imagechild = new services\Image\ColorImage();
		$imagechild->setSpecies($species);
		$imagechild->create($child);
	//	$document->add(new Comment("<img src='{$imagechild->base64()}'>"));

	//	$document->add(new Comment("Below is a randomly generated Catari, Hounda or Feesh with some example variations. It's base 64 encoded, which means it's not saved anywhere on the server but you can download or link to this particular one by right clicking and 'copy image address' or 'save image as'.<br>"));
		$document->add(new Comment("Below is a randomly generated pair of Catari, Hounda, or Feesh with a litter of offspring to demonstrate current breeding inheritance."));

		$child = $breeding->breed(['sire'=>$image->genetics,'dam'=>$image2->genetics], 'colorBrighten');
		$imagechild2 = new services\Image\ColorImage();
		$imagechild2->setSpecies($species);
		$imagechild2->create($child);

		$child = $breeding->breed(['sire'=>$image->genetics,'dam'=>$image2->genetics], 'colorMergePlusWhite');
		$imagechild3 = new services\Image\ColorImage();
		$imagechild3->setSpecies($species);
		$imagechild3->create($child);

		$child = $breeding->breed(['sire'=>$image->genetics,'dam'=>$image2->genetics], 'colorMergePlusBlack');
		$imagechild4 = new services\Image\ColorImage();
		$imagechild4->setSpecies($species);
		$imagechild4->create($child);

		$child = $breeding->breed(['sire'=>$image->genetics,'dam'=>$image2->genetics], 'colorDarken');
		$imagechild5 = new services\Image\ColorImage();
		$imagechild5->setSpecies($species);
		$imagechild5->create($child);

		$child = $breeding->breed(['sire'=>$image->genetics,'dam'=>$image2->genetics], 'favorsPa');
		$imagechild6 = new services\Image\ColorImage();
		$imagechild6->setSpecies($species);
		$imagechild6->create($child);

		$child = $breeding->breed(['sire'=>$image->genetics,'dam'=>$image2->genetics], 'favorsMa');
		$imagechild7 = new services\Image\ColorImage();
		$imagechild7->setSpecies($species);
		$imagechild7->create($child);



		$document->add(new Comment("<img src='{$image->base64()}'> + <img src='{$image2->base64()}'> = <br><table border=0><tr><td><img src='{$imagechild->base64()}'></td><td><img src='{$imagechild2->base64()}'></td><td><img src='{$imagechild5->base64()}'></td><td><img src='{$imagechild3->base64()}'></td><td><img src='{$imagechild4->base64()}'></td></tr><tr><td>
			50/50</td><td>Brighten Color</td><td>Darken Color</td><td>White added</td><td>Black Added</td></tr><tr><td>
			<img src='{$imagechild6->base64()}'></td><td><img src='{$imagechild7->base64()}'></td></tr><tr><td>
			75/25</td><td>25/75</td></tr></td></tr></table>"));

		/*
		// Debug code below
		echo '<pre>';
		echo json_encode($imagechild->genetics),'<br>';
		print_r($imagechild->genetics);
		echo '</pre>';
		*/

	//	$document->add(new Comment("Here's another one that you can get by going to /image/display. You can't link or save it though (when clicking to save the server will call the page again, which will refresh it, causing a new image to be generated.<br>In the near future this will link to specific adopts through their id, ie /image/display/123"));
	//	$document->add(new Comment('<img src="/image/display">'));

	}
}