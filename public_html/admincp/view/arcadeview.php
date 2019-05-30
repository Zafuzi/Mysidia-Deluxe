<?php

class ACPArcadeView extends View{

    public function index(){
		parent::index();
		$mysidia = Registry::get("mysidia");
		//this should include a table with all the games
		$document = $this->document;
		$document->add(new Link("admincp/arcade/add", "<p>Add game to the arcade</p>", TRUE));	
		
		$stmt = $mysidia->db->select("arcade", array("id"));
		if($stmt->rowCount() == 0){
		$document->add(new Comment("There aren't any games in the arcade!"));
        	return;
        }
        
        $document->add(new Comment("<center><table style='text-align:center;border-collapse:collapse;'>
  			<thead>
    			<tr>
      			<th style='text-align:center;border: 2px solid #7F7F7F;padding:8px;'>Name</th>
      			<th style='text-align:center;border: 2px solid #7F7F7F;padding:8px;'>Image</th>
      			<th style='text-align:center;border: 2px solid #7F7F7F;padding:8px;'>Description</th>
      			<th style='text-align:center;border: 2px solid #7F7F7F;padding:8px;'>Available</th>
      			<th style='text-align:center;border: 2px solid #7F7F7F;padding:8px;'>Action</th>
		    	</tr>
 			</thead>
  			<tbody>", FALSE));
  		while($game_id = $stmt->fetchColumn()){
		    $game = $mysidia->db->select("arcade", array(), "id='{$game_id}'")->fetchObject(); 
			$document->add(new Comment("<tr>
     				<td style='border: 2px solid #7F7F7F;padding:8px;'>{$game->name}</td>
				<td style='border: 2px solid #7F7F7F;padding:8px;'><img src='{$game->img}' height=90px; width=auto;></td>
				<td style='border: 2px solid #7F7F7F;padding:8px;'>{$game->description}</td>
				<td style='border: 2px solid #7F7F7F;padding:8px;'>{$game->available}</td>
				<td style='border: 2px solid #7F7F7F;padding:8px;'>
					<a href='/admincp/arcade/edit/{$game_id}' class='btn btn-primary' style='width:100%; height:auto;'>Edit</a>
				</td>

    				</tr>", FALSE));
		} 
		$document->add(new Comment("</tbody></table></center>"));
		
    }

    public function add(){
        // The action of adding a game to the arcade!
	    $mysidia = Registry::get("mysidia");
		$document = $this->document;
		
		if($mysidia->input->post("submit")){		    
			$document->setTitle("Successfully added!");
			$document->addLangvar("Redirecting to previous page...");
			$document->addLangvar("<meta http-equiv='refresh' content=\"1; URL='http://atrocity.mysidiahost.com/admincp/arcade'\" />");
		    return;
		}
		
		$document->setTitle("Add a new game");
		
		$gameForm = new FormBuilder("addform", "add", "post");  
			
            $gameForm->add(new Comment("Name:", TRUE, "b"));
			$gameForm->add(new TextField("name"));
			$gameForm->add(new Comment("<hr>"));
			
			$gameForm->add(new Comment("Image:", TRUE, "b"));
			$gameForm->add(new TextField("image"));
			$gameForm->add(new Comment("Remember it must be a full URL, including \"http\".", FALSE));
			$gameForm->add(new Comment("<hr>"));
			
			$gameForm->add(new Comment("Description:", TRUE, "b"));
			$gameForm->add(new TextArea("description"));
			$gameForm->add(new Comment("<hr>"));
			
			$gameForm->add(new Comment("Link:", TRUE, "b"));
			$gameForm->add(new TextField("link"));
			$gameForm->add(new Comment("Remember it must be a full URL, including \"http\".", FALSE));
			$gameForm->add(new Comment("<hr>"));
			
			$gameForm->add(new Comment("Available:", TRUE, "b"));
			$gameForm->add(new RadioButton("Yes ", "status", "yes"));
			$gameForm->add(new RadioButton("No ", "status", "no"));
			$gameForm->add(new Comment("</br>Can be used to hide a game from the arcade without deleting it from the database.", FALSE));
			$gameForm->add(new Comment("<hr>"));

			$gameForm->add(new Button("Create", "submit", "submit"));
			$document->add($gameForm);										   
    }

    public function edit(){
        $mysidia = Registry::get("mysidia");
		$document = $this->document;

		if($mysidia->input->post("submit")){
		    // A form has been submitted, time to carry out out action.
			if($mysidia->input->post("delete") == "yes"){
				$document->setTitle("The game has been deleted.");
				$document->addLangvar("Returning to previous page...");
				$document->addLangvar("<meta http-equiv='refresh' content=\"1; URL='http://atrocity.mysidiahost.com/admincp/arcade'\" />");
			}
			else{
				$document->setTitle("Game successfully edited!");
				$document->addLangvar("Returning to previous page...");
				$document->addLangvar("<meta http-equiv='refresh' content=\"1; URL='http://atrocity.mysidiahost.com/admincp/arcade'\" />");
			}
		}
		else{
            $game_id = $this->getField("game");
            $game = $mysidia->db->select("arcade", array(), "id='{$game_id}'")->fetchObject();
		    $document->setTitle("edit game");
			$document->add(new Comment("<img src='{$game->img}'>"));
			$document->add(new Comment("<p>This page allows you to edit {$game->name}.  Use the form below to edit (or delete) it.</p>"));
			
			$gameForm = new FormBuilder("editform", "$game_id", "post");  
			
            $gameForm->add(new Comment("Name:", TRUE, "b"));
			$gameForm->add(new Comment("Insert a new name: ", FALSE));
			$gameForm->add(new TextField("name", "{$game->name}"));
			$gameForm->add(new Comment("<hr>"));
			
			$gameForm->add(new Comment("Image:", TRUE, "b"));
			$gameForm->add(new Comment("Insert a new image: ", FALSE));
			$gameForm->add(new TextField("image", "{$game->img}"));
			$gameForm->add(new Comment("Remember it must be a full URL, including \"http\".", FALSE));
			$gameForm->add(new Comment("<hr>"));
			
			$gameForm->add(new Comment("Description:", TRUE, "b"));
			$gameForm->add(new TextArea("description", "{$game->description}"));
			$gameForm->add(new Comment("<hr>"));
			
			$gameForm->add(new Comment("Link:", TRUE, "b"));
			$gameForm->add(new Comment("Use a new link: ", FALSE));
			$gameForm->add(new TextField("link", "{$game->link}"));
			$gameForm->add(new Comment("Remember it must be a full URL, including \"http\".", FALSE));
			$gameForm->add(new Comment("<hr>"));
			
			$gameForm->add(new Comment("Available:", TRUE, "b"));
			$gameForm->add(new RadioButton("Yes ", "status", "yes"));
			$gameForm->add(new RadioButton("No ", "status", "no"));
			$gameForm->add(new Comment("</br>Can be used to hide a game from the arcade without deleting it from the database.", FALSE));
			$gameForm->add(new Comment("<hr>"));
			
			$gameForm->add(new Comment("<span style='color:red'>Danger Zone:</span>", TRUE, "b"));
			$gameForm->add(new CheckBox("<b>I want to delete this game </b>", "delete", "yes"));
			$gameForm->add(new Comment("Deleting a game will only remove it from the arcade, and the files will remain on the site."));

            $gameForm->add(new Comment("<hr>"));
			$gameForm->add(new Button("Submit Changes", "submit", "submit"));
			$document->add($gameForm);		
	    }
    }

    public function delete(){

    }	
}
?>