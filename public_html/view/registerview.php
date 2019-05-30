<?php

class RegisterView extends View{
	
	public function index(){
	    $mysidia = Registry::get("mysidia");
		$document = $this->document;		
if($mysidia->input->post("submit")){
    $document->setTitle($this->lang->success_title);
    $document->addLangvar($this->lang->success.$mysidia->input->post("username").$this->lang->success2);

    $pm = new PrivateMessage(); // Send them a welcoming message
    $pm->setsender('Ittermat');
    $pm->setrecipient(htmlentities(addslashes(trim($mysidia->input->post("username")))));
    $pm->setmessage("Welcome to Atrocity!", "Hi there and Welcome to Atrocity! I sincerely hope you enjoy your time here! Please feel free to inquire if you have any questions, and for up to date details and some more fun we have a facebook page and a Forum, and please make sure you read and follow the rules and Terms of service! Have a great day!! ~Ittermat");
    $pm->post();  
    
    return;
}  
        $document->setTitle($this->lang->title);
        $document->addLangvar($this->lang->default);		
		$registerForm = new Form("regform", "", "post");
		
		$requiredField = new FieldSet("required");
		$requiredField->add(new Legend("Required Info"));
		$requiredField->add(new Comment("Username: ", FALSE, "b"));
        $requiredField->add(new Comment("Your username may be up to 20 characters long with letters, numbers and spaces only."));
        $requiredField->add(new TextField("username"));
        $requiredField->add(new Comment("Password: ", FALSE, "b"));
        $requiredField->add(new Comment("Your password may be up to 20 characters long and may contain letters, numbers, spaces and special characters. The use of a special character, such as * or ! is recommended for increased security. "));
        $requiredField->add(new Comment("Enter Password ", FALSE));
		$requiredField->add(new PasswordField("password", "pass1", "", FALSE));
        $requiredField->add(new Comment(" Confirm Password ", FALSE));
        $requiredField->add(new PasswordField("password", "pass2", "", TRUE));
        $requiredField->add(new Comment("Email Address: ", FALSE, "b"));
        $requiredField->add(new Comment("Enter a valid email address for yourself."));
        $requiredField->add(new PasswordField("email", "email", "", TRUE));
        $registerForm->add($requiredField);

        $additionalField = new FieldSet("additional");
        $additionalField->add(new Legend("Additional Info"));
        $additionalField->add(new Comment("Birthday: ", FALSE, "b"));
        $additionalField->add(new Comment("(mm/dd/yyyy)"));	
        $additionalField->add(new TextField("birthday"));
		$additionalField->add(new Comment("Avatar: ", FALSE, "b"));
        $additionalField->add(new Comment("Enter the url of your avatar beginning with http://www. and 100 x 100 size only"));	
        $additionalField->add(new TextField("avatar"));
		$additionalField->add(new Comment("Nickname: ", FALSE, "b"));
        $additionalField->add(new Comment("A nickname for yourself, do not use inappropriate words! "));	
        $additionalField->add(new TextField("nickname"));
		$additionalField->add(new Comment("Gender: ", FALSE, "b"));
        $additionalField->add(new Comment("Male, Female, Other or not specified"));

        $genderList = new RadioList("gender");	
		$genderList->add(new RadioButton("Male", "gender", "male"));
        $genderList->add(new RadioButton("Female", "gender", "female"));
        $genderList->add(new RadioButton("Other", "gender", "other"));
        $genderList->add(new RadioButton("Unknown", "gender", "unknown"));
        $genderList->add(new RadioButton("Agender", "gender", "agender"));
	    $genderList->add(new RadioButton("Cisgender", "gender", "cisgender"));
	    $genderList->add(new RadioButton("Gender fluid", "gender", "gender fluid"));
	    $genderList->add(new RadioButton("Bi gender", "gender", "bi gender"));
	    $genderList->add(new RadioButton("Gender nonconforming", "gender", "gender nonconforming"));
	    $genderList->add(new RadioButton("Genderqueer", "gender", "genderqueer"));
	    $genderList->add(new RadioButton("Intersex", "gender", "intersex"));
	    $genderList->add(new RadioButton("Non binary", "gender", "non binary"));
	    $genderList->add(new RadioButton("Pangender", "gender", "pangender"));
	    $genderList->add(new RadioButton("Transgender mtf", "gender", "transgender mtf"));
	    $genderList->add(new RadioButton("Transgender ftm", "gender", "transgender ftm"));
	    $genderList->add(new RadioButton("Two spirit", "gender", "two spirit"));
        $genderList->check("unknown");
        $additionalField->add($genderList);

		$additionalField->add(new Comment("Favorite Color: ", FALSE, "b"));
        $additionalField->add(new Comment("Your favorite color. Red, Yellow, Blue, who knows? "));	
        $additionalField->add(new TextField("color"));
		$additionalField->add(new Comment("Biography: ", FALSE, "b"));
        $additionalField->add(new Comment("Enter a bio for yourself, if you want to."));	
        $additionalField->add(new TextArea("bio", "", 4, 50));
		$registerForm->add($additionalField);
		
		$securityField = new FieldSet("security");
		$securityField->add(new Legend("Anti-Spam Security Question"));
		$securityField->add(new Comment("Question: ", FALSE, "b"));
		$securityField->add(new Comment($mysidia->settings->securityquestion));
		$securityField->add(new Comment("Answer: ", FALSE, "b"));
		$securityField->add(new TextField("answer"));
		$securityField->add(new CheckBox("I agree to the <a href='tos' target='_blank'>Terms of Service", "tos", "yes"));
		$securityField->add(new PasswordField("hidden", "ip", $_SERVER['REMOTE_ADDR'], TRUE));
		$securityField->add(new Button("Register", "submit", "submit"));
		$registerForm->add($securityField);
		$document->add($registerForm);
	}              
}
?>