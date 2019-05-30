<?php

class AdoptView extends View{
	
    public function index(){
        $mysidia = Registry::get("mysidia");
        $document = $this->document;
        $document->setTitle($mysidia->lang->title);
        $document->addLangvar((!$mysidia->user->isloggedin)?$mysidia->lang->guest:$mysidia->lang->member); 
        $document->addLangvar('<b>Available Adoptables</b>');

        $adopts = $this->getField("adopts")->get()->fetchAll(PDO::FETCH_OBJ);
        echo '<style>
        .colorfuladopt {
            border-radius: 25px;
            border: 10px solid rgb(34,177,76);
            margin-bottom: 10px;
            width: 80%;
            position:relative;
        }

        .colorfuladopttext{
            color:rgb(34,177,76); 
            display: inline-block; 
            padding-left: 5%;
            font-size: 200%;
        }
        </style>';

        foreach ($adopts as $adopt){
            $document->addLangvar("<div class='colorfuladopt'><table width=100%><tr><td><img src='/image/display/{$adopt->type}'></td><td><b>{$adopt->type}</b><br>{$adopt->description}<br>
                <a href='adopt/adopt/{$adopt->type}'><div class='colorfuladopttext'><span style='color:pink;'>♥</span> Adopt</div></a> <div class='colorfuladopttext'><span style='color:orange'>★</span>Create!</div>(coming soon)
                </td></tr></table></div>");
        }
        $document->addLangvar('</table>');
    }

    public function adopt(){
        $mysidia = Registry::get("mysidia");
        $document = $this->document;
        $document->setTitle($mysidia->lang->title);

        echo '<style>
        .colorfuladopt {
            border-radius: 25px;
            border: 10px solid rgb(34,177,76);
            margin-bottom: 10px;
            width: 80%;
            position:relative;
        }

        .colorfuladopttext{
            color:rgb(34,177,76); 
            display: inline-block; 
            padding-left: 5%;
            font-size: 200%;
        }
        </style>';

        $document->addLangvar("<form method='post' action='/adopt/finish'><table><tr><td>
            <img src='{$_SESSION['adopt1']->base64()}'>
            <br><input type='radio' name='adopt' value='1'>
            </td><td>
            <img src='{$_SESSION['adopt2']->base64()}'>
            <br><input type='radio' name='adopt' value='2'>
            </td><td>
            <img src='{$_SESSION['adopt3']->base64()}'>
            <br><input type='radio' name='adopt' value='3'>
            </td></tr></table>
            <br><input type='submit' value='Adopt!'>
            </form>");
    }

    public function finish()
    {
        $mysidia = Registry::get("mysidia");
        $document = $this->document;
        $document->setTitle('Congratulations!');
        $image = Registry::get('cImage');
        $genetics = json_decode($this->getField('petGenetics')->getValue(),true);
        $species = $genetics['species'];
        $image->setOwner(null);
        $image->age = 0;
        $image->setSpecies($species);
        $image->create($genetics);
        $aid = $this->getField("aid")->getValue();
        $document->addLangvar("<img src='{$image->base64()}''><br>");
        $document->addLangvar('You\'ve successfully adopted a '.$species. ' egg!<br>');
        $document->add(new Link("myadopts", "Click here to visit your new {$species}!", TRUE));

        $document->addLangvar("Be sure to visit them every day so that they hatch!");
    }



	public function OLDindex(){
	    $mysidia = Registry::get("mysidia");
		$document = $this->document;
		
if($mysidia->input->post("submit")){
            $aid = $this->getField("aid")->getValue();
            $name = $this->getField("name")->getValue();
            $gender_lookup = $mysidia->db->select("owned_adoptables", array("gender"), "aid = '{$aid}'")->fetchColumn();
            if ($gender_lookup == "m") { $gender = "boy"; $pronoun = "him"; }
            if ($gender_lookup == "f") { $gender = "girl"; $pronoun = "her"; } 
            $eggImage = $this->getField("eggImage")->getValue();
            $image = new Image($eggImage);
            $image->setLineBreak(TRUE);    

            $document->setTitle("{$name} adopted successfully!");            
            $document->add($image);
            $document->addLangvar("Congratulations! The {$name} you just recruited is a ");
            $document->add(new Comment("<b>{$gender}</b>. Would you like to name {$pronoun}? <br> (Valid names may only contain letters, numbers and spaces.)", FALSE));
        
            $nameForm = new FormBuilder("renameform", "/myadopts/rename/{$aid}", "post");
            $nameForm->buildTextField("adoptname")->buildButton("Name", "submit", "submit");
            $document->add($nameForm);    


            $document->add(new Comment("Or if you'd rather wait until later, you can ", FALSE));
            $document->add(new Link("myadopts/manage/{$aid}", "click here to manage your new {$name}!", TRUE));

            $document->addLangvar("Be sure to");
            $document->add(new Link("levelup/{$aid}", "visit "));
            $document->addLangvar("{$name} every day so that they grow!");
            return;
        }  
		
		$document->setTitle($mysidia->lang->title);
        $document->addLangvar((!$mysidia->user->isloggedin)?$mysidia->lang->guest:$mysidia->lang->member);  		
        $adoptForm = new Form("form", "adopt", "post");
		$adoptTitle = new Comment("Available Adoptables");
		$adoptTitle->setHeading(3);
		$adoptForm->add($adoptTitle);
		$adoptTable = new Table("table", "", FALSE);
 		
		$adopts = $this->getField("adopts");
		for($i = 0; $i < $adopts->length(); $i++){
		    $row = new TRow;
		    $idCell = new TCell(new RadioButton("", "id", $adopts[$i]->getID()));				
			$imageCell = new TCell(new Image($adopts[$i]->getEggImage(), $adopts[$i]->getType()));
			$imageCell->setAlign(new Align("center"));
				
			$type = new Comment($adopts[$i]->getType());
			$type->setBold();
            $description = new Comment($adopts[$i]->getDescription(), FALSE);
			$typeCell = new TCell;
            $typeCell->add($type);
            $typeCell->add($description);			

		    $row->add($idCell);
			$row->add($imageCell);
			$row->add($typeCell);
            $adoptTable->add($row);
		}
		
	$adoptForm->add($adoptTable);           
        $adoptForm->add(new Button("Recruit", "submit", "submit"));
        $document->add($adoptForm);  
	}
}