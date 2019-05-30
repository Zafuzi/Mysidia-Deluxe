{include file="{$root}{$temp}{$theme}/header.tpl"}

{* This file is found in inc/smarty/plugins *}
{layoutstuff}

<body>
  <div class="container">
    <div class="sidebar">
        {include file="{$root}{$temp}{$theme}/sidebar.tpl"}
    </div><!-- end .sidebar -->

    <div class="content">
        
        <div class="topright" >
            <div class="table">
                <div id="imgcontainer">
                  <a href="/"><img src="/{$temp}{$theme}/springbanner2smaller.png" id="image" width="auto" height="128px" style="background:#;" border=0/></a>
                </div>
                <div>
                    {include file="{$root}{$temp}{$theme}/menu.tpl"}
                </div>
                <div style="display: table-cell; width:40px;"></div>
            </div>
        </div> <!-- end .topright -->

        <div class="midright">
            <h1>{$document_title} </h1>
            <p> {$newsnotice} </p>
            <div> {$document_content} </div>
        </div> <!-- end .midright -->
  
        <!-- FOOTER -->
        <div class="bottomright">
            {include file="{$root}{$temp}{$theme}/footer.tpl"}
            {$footer}
        </div> <!-- end .bottomright -->  
    </div><!-- end .content -->
  </div><!-- end .container -->
  <script src="https://unpkg.com/pell"></script>
      <script>
        let ed = document.querySelector("#editor");
        if(ed) {
          // Make sure there is an editor element before adding pell
          var editor = window.pell.init({
            element: ed,
            defaultParagraphSeparator: 'p',
            onChange: function (html) {
              document.getElementById('html-output').textContent = html
            }
          })
        }
    </script>
</body>
</html>  