<?php

class IndexView extends View{

    public function index(){
        $mysidia = Registry::get("mysidia");
        $document = $this->document;
        $document->setTitle("<p><center>Atrocity is being worked on!</center></p>");
        
        //new index style
        $document->add(new Comment("
            <style>
                .item1 { grid-area: main; }
                .item2 { grid-area: events; }
                .item3 { grid-area: news; }
                .item4 { grid-area: tpets; }
                .item5 { grid-area: pound; }

                .grid-container {
                    display: grid;
                    grid-template-areas:
                        'main main events events news news'
                        'tpets tpets tpets tpets tpets tpets'
                        'pound pound pound pound pound pound';
                    grid-gap: 10px;
                    background-color: #385e0f;
                    padding: 10px;
                }
                .grid-container > div {
                    background-color: rgba(255, 255, 255, 0.8);
                    text-align: center;
                    padding: 20px;
                    font-size: 16px;
                }
                #parent {
                    display: flex;
                }
            </style>"));
        //new style end
        
        //new content
        $document->add(new Comment("
            <div class='grid-container'>
                <!-- MAIN BOX -->
                <div class='item1'>
                    <p><img src='https://cdn.discordapp.com/attachments/435464465597595649/567786650827096095/pardonourdustbasicsmaller.png'></p>
                    
                    <p>
                        <b>PARDON OUR DUST</b><br/>
                        Atrocity is a side project for all of us- Life always comes first- Thank you so much for your patience!
                    </p>
                    
                    <b><u>Why is it Called Atrocity?</u></b><br />
					<p>Its an inside joke really lol</p>
					
					<p>It started out that I just couldnt think of a name... When you have ones that have cool names like Kaylune or something... or even what seemed like a strange made up word... (Trust me I've seen some wierd ones...)
					and as it was my first petsite- I wasnt expecting it to go very far... so I half heartedly named it atrocity cuz I figured thats how it'd end up.</p> 
					<p>Well...then I ended up making so much site art, and signing so many pictures with (C) Atrocity I was just like meh. its just silly now..So I kept it.. and rolled with it.. plus its easy to remember XD</p>
                </div>
                
                <!-- NEWS BOX -->
                <div class='item2'>
                    <img src='http://atrocity.mysidiahost.com/picuploads/png/ba7b1391cfdebe1ae50507affd31cb80.png'>
                    <br></br>"));
                    
        // select last 5 news articles that are published - so no drafts
		$lastnews = $mysidia->db->select("news", array(), "posted = 'yes' ORDER BY id DESC LIMIT 5");
		
		while($news = $lastnews->fetchObject()){
			$newsid = $news->id; $title = $news->title; $author = $news->user; $newsdate = $news->date;

			// look up the screenname of news author
			$authorname = $mysidia->db->select("users", array("username"), "uid = {$author}")->fetchColumn();

			$document->add(new Comment("<div>
			    <a href='../../news/view/{$newsid}'>
			        <b>{$title}</b><br>
			    </a>
				Written by <a href='../../profile/view/{$author}'>{$authorname}</a> at {$newsdate}</a><br>
			</div><br/>", FALSE));
		}
		// end loop
                    
        $document->add(new Comment("</div>
            <!-- CURRENT EVENTS -->
            <div class='item3'>
                <p><a href='http://atrocity.mysidiahost.com/pages/view/sitecalendar'><img src='http://atrocity.mysidiahost.com/picuploads/png/cb4e85f8965f2338c7184fab6f57926a.png'></a><br/>
                Current events go here (click image for site calendar)</p>
                
                <a href='http://atrocity.mysidiahost.com/raffle'>
					<img src='http://atrocity.mysidiahost.com/picuploads/png/b6fa8afcf34be457185209a9f1e5c486.png' />
				</a>
				
            </div>
                
            <!-- TOP PETS -->
            <div class='item4'>
                <img src='http://atrocity.mysidiahost.com/picuploads/png/2984df1d6b389210b8f0a499e5177fc2.png'/><br/>"));
                
        $top_pets = $mysidia->db->select("owned_adoptables", array('aid','name'), "aid!='0' AND isdead='0' ORDER BY totalclicks DESC LIMIT 5");
		
		while($pet = $top_pets->fetchObject()){
			$aid = $pet->aid; $name = $pet->name;
			$adopt = new OwnedAdoptable($aid);
			$document->add(new Comment("
				    <a href='/pet/profile/{$aid}'>
				        <img src='{$adopt->getImage()}' style='height:150px; width:auto;'>
				    </a>&nbsp &nbsp", FALSE));
		} 
		// end loop
                
        $document->add(new Comment("</div>
            <!-- POUND PETS -->
            <div class='item5'>
                <img src='http://atrocity.mysidiahost.com/picuploads/png/5755fca9a46c95a76bd22ffdfd8acdc6.png'/>"));
                
        $pound_pets = $mysidia->db->select("pounds", array(), "currentowner='SYSTEM' ORDER BY datepound DESC LIMIT 3");
        
        if($pound_pets->rowCount() == 0){
            $document->add(new Comment("<br><center>There aren't any pets in the pound, hooray!</center></div></div>"));
            return;
            
        }
        else{
            $document->add(new Comment("<div id='parent'>"));
        }
		
		while($pet = $pound_pets->fetchObject()){
			$aid = $pet->aid;
			$adopt = new OwnedAdoptable($aid);
			
			$extra = null;
			if ($adopt->getClass() == 'Colorful'){
				$type = strtolower($adopt->type);
				if ($adopt->getCurrentLevel() < 2){
					$extra = "<div style='background:url({$mysidia->path->getAbsolute()}picuploads/pet_statuses/{$type}/{$type}eggsadface.png);position:absolute;height:150px; width:150px;z-index:5;bottom:0px'></div>";
				}
				else{
					$extra = "<div style='background:url({$mysidia->path->getAbsolute()}picuploads/pet_statuses/{$type}/1/{$type}sadexpression1.png);position:absolute;height:200px; width:150px;z-index:5;bottom:0px'>
					    <img src='http://atrocity.mysidiahost.com/picuploads/png/{$type}sadexpression1.png'>
					</div>";
				}
			}
			
			$document->add(new Comment("
				<div style='position:relative; height:225px; width:216px'>
				    <div style='position:absolute;left:30px;z-index:2;bottom:0px'>
				        <img src='{$adopt->getImage()}'> {$extra}
				    </div>
				    <div style='position:relative; top:200px; left:30px; height:53px; width:146px'>
				        <br><a href='/pound'>Adopt {$adopt->getName()}</a>
				    </div>
				</div>&nbsp &nbsp", FALSE));
		} 
		// end loop        
                
        $document->add(new Comment("</div></div></div>"));
        //new content end
	}
}
?> 