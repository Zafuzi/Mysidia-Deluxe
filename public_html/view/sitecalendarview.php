<?php
class sitecalendarView extends View{	
	public function index(){
		$mysidia = Registry::get("mysidia");
		$document = $this->document;	
		$document->setTitle('Atrocity site Calendar');
		$document->add(new Comment("<center><h1>Here is where you can see the site events Calendar! If you feel something is missing please let <a href='http://atrocity.mysidiahost.com/profile/view/Ittermat'>Ittermat</a> know! Also Go <a href='https://calendar.google.com/calendar?cid=aWQzODUyNXAycm5ldTI2OWdtOTluNGx1NjhAZ3JvdXAuY2FsZW5kYXIuZ29vZ2xlLmNvbQ'>here</a> to add your birthday to the calendar!</h1></center>"));
                $document->add(new Comment ('<center><style>
                .googleCalendar{
  position: relative;
  height: 0;
  width: 50%;
  padding-bottom: 50%;
}

.googleCalendar iframe{
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
}
</style>
                <div class="googleCalendar">
  <iframe src="https://calendar.google.com/calendar/embed?title=Atrocity%20Petsite%20calendar&amp;showCalendars=0&amp;height=600&amp;wkst=1&amp;bgcolor=%23ffffff&amp;src=8b3eoo3g85cl91o2h6nfr8rto0%40group.calendar.google.com&amp;color=%238D6F47&amp;ctz=America%2FNew_York" style="border-width:0" width="800" height="600" frameborder="0" scrolling="no"></iframe>
</div></center>'));
	} 
} 
?>