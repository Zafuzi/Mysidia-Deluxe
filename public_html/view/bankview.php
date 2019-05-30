 <?php
class BankView extends View{

    public function index(){
      
        $mysidia = Registry::get("mysidia");
        $document = $this->document;      
        $balance = $mysidia->user->getbank();
        $cash = $mysidia->user->getcash();
        $document->setTitle("<center>The Bank<br><img src='http://atrocity.mysidiahost.com/picuploads/png/fe24affe6cc0fdf9a752b91a0d5893f4.png'</center>");  
        
        $document->add(new Comment("<center><b>Sion says:</b> Welcome to the bank! Please choose an option below!
        <br> Interest is set at 1% of current balance a day<br></b></center>"));
        
        if ($balance <= 0){
            $document->add(new Comment("<h2><center></center>Current Balance: 0 Beads</h2>"));
        }
        else{
            $document->add(new Comment("<h2><center>Current Balance: {$balance} Beads</center></h2>", FALSE));
        }
        $document->add(new paragraph);
        $document->add(new Comment("<center>"));
        if($mysidia->input->post("deposit")){
            $amount = $mysidia->input->post("amount");
            $mysidia->user->changecash(-$amount);
            $mysidia->user->changebank(+$amount);
            $document->add(new Comment("<h2><center>You deposited {$amount} Beads into your bank account</center></h2>", FALSE));
            $document->add(new Comment("<br><center><a href='{$path}bank'>Return to Bank</a></center>  ", FALSE));
            return TRUE;
        }

        $depositForm = new FormBuilder("depositForm", "", "post");
        $depositForm->buildComment("Amount: ", FALSE)
            ->buildTextField("amount", FALSE)
            ->buildButton("Deposit", "deposit", "submit");
        $document->add($depositForm);
        
        if($mysidia->input->post("withdraw")){
            $amount = $mysidia->input->post("amount");
            $mysidia->user->changecash(+$amount);
            $mysidia->user->changebank(-$amount);
            $document->add(new Comment("<h2><center>You withdrew {$amount} Beads from your bank account</center></h2>", FALSE));
            $document->add(new Comment("<br><center><a href='{$path}bank'>Return to Bank</a></center>  ", FALSE));
            return TRUE;
        }  

        $withdrawForm = new FormBuilder("withdrawForm", "", "post");
        $withdrawForm->buildComment("Amount: ", FALSE)
            ->buildTextField("amount", FALSE)
            ->buildButton("Withdraw", "withdraw", "submit");
        $document->add($withdrawForm);
        $document->add(new Comment("</center>"));
    }
}
?>