<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<html lang="en">
<head>
    
    <title>{$browser_title}</title>
        
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    
    <link rel='stylesheet' href='/css/site.css' type='text/css'/>
    <link rel='stylesheet' href='/css/monsters.css' type='text/css'/>
    <link rel='stylesheet' href='/css/lightbox.min.css' type='text/css'/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/dark-hive/jquery-ui.css">
    <link rel="stylesheet" type="text/css" href="https://unpkg.com/pell/dist/pell.min.css">

    {$header->loadFavicon("{$home}favicon.ico")}
    {$header->loadStyle("{$home}{$temp}{$theme}/style.css")}
    {$header->loadAdditionalStyle()}
    {$header->loadStyle("/css/tooltip.css")}
    {$header->loadStyle("{$home}{$css}/progress.css")}
    
    <script src="https://code.jquery.com/jquery-3.4.1.js"></script>
    <script src="/js/spinwheel.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js" integrity="sha256-VazP97ZCwtekAsvgPBSUwPFKdrwD3unUfSGVYrahUqU=" crossorigin="anonymous"></script>

    <script src="https://cdn.jsdelivr.net/npm/@widgetbot/crate@3" async defer>
      new Crate({
        server: '471651340074876948',
        channel: '502505548818939941',
        shard: 'https://cl1.widgetbot.io'
      })
    </script>
    <script>
        $(function(){
            // $('#tabs').tabs();
            
            // Makes accordion style menus possible
            $('.accordion').on('click', ac => {
                $('.accordion').removeClass('active');
                
                let panels = $('.panel');
                panels.each((index, panel) => {
                    panel.style.maxHeight = null;
                })
                
                let self = ac.currentTarget;
                self.classList.toggle("active");
                
                var panel = self.nextElementSibling;
                if($(panel).css('maxHeight') != "0px"){
                    console.log($(panel).css('maxHeight'))
                    panel.style.maxHeight = null;
                    self.classList.toggle("active");

                } else {
                    panel.style.maxHeight = panel.scrollHeight + "px";
                }
            })
        });
    </script>
</head>           