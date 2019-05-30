<div class="flex flex-col" style="padding: 10px; margin: 10px auto; font-size: .9rem;">
    <span>{date("m-d-Y")}</span> 
    <span>{date("h:ia")}</span>
</div>
{if $logged_in}
    <div id="avatarbox" style="display: flex; width: 100%;">
        <div id="avatarpic">
          <p style="width: 100%; display: flex; flex-flow: row wrap; justify-content: center; margin: 0; padding: 0; border-radius: 5px 5px 0 0;">
              {$avatar}
          </p>
          {if $team}
            <p class="flex flex-row align-center avatar_info_line">{$team}</p>
          {/if}
          <p class="flex flex-row align-center avatar_info_line"><span>📿</span>{$money}</p>
          <p class="flex flex-row align-center avatar_info_line"><span>🍬</span> {$premiumcurrency}</p>
        </div>
    </div>
    {$acp}
    <a href="/changestyle">Change Theme</a>
    <a href="/login/logout">Logout</a>
{/if}
<nav>
    <button class="accordion"><img src="/{$temp}icons/personal1.png">Personal</button>
    <div class="panel">
      <ul>
    		<li>
    			<a href="/account"><img src="/{$temp}icons/settings1.png"> SETTINGS</a>
    		</li>
    
    
    		<li>
    			<a href="/inventory"><img src="/{$temp}icons/inventory1.png">INVENTORY</a>
    		</li>
    
    
    		<li>
    			<a href="/myadopts"><img src="/{$temp}icons/pets1s.png"> PETS</a>
    		</li>
    
    
    		<li>
    			<a href="/shopcp"><img src="/{$temp}icons/inventory1.png"> SHOP SETTINGS </a>
    		</li>
    
    
    		<li>
    			<a href=""><img src="/{$temp}icons/chest1s.png"> <s>CHEST</s></a>
    		</li>
    
    
    		<li>
    			<a href="http://atrocity.mysidiahost.com/pages/view/myhouse/"><img src="/{$temp}icons/shops1.png"> <s>HOUSE/YARD</s></a>
    		</li>
    
    
    		<li>
    			<a href=""><img src="http://atrocity.mysidiahost.com/picuploads/png/72c06a6f9036b8c51e116aba31d471ce.png"> <s>FARM</s></a>
    		</li>
    		
    		<li>
    			<a href=""><img src="http://atrocity.mysidiahost.com/picuploads/png/75d57f1e3516ccf0ad05250c8ca3523f.png"> <s>GARDEN</s></a>
    		</li>
    
    		<li>
    			<a href=""><img src="http://atrocity.mysidiahost.com/picuploads/png/8e78a20868887c160a9f473ce06b93b7.png"> <s>ORCHARD</s></a>
    		</li>
    	</ul>
    </div>
    <button class="accordion"><img src="/{$temp}icons/explore1.png">Exploration</button>
    <div class="panel">
        <ul>
			<li>
				<a href="/pages/view/worldmap"><img src="/{$temp}icons/explore2.png"> EXPLORE</a>
			</li>


			<li>
				<a href="http://atrocity.mysidiahost.com/pages/view/scionscasino"><img src="/{$temp}icons/bank1.png">BANK/CASINO</a>
			</li>


			<li>
				<a href="/arcade"><img src="/{$temp}icons/arcade1.png">ARCADE</a>
			</li>


			<li>
				<a href="/shop"><img src="/{$temp}icons/shops1.png">SHOPS</a>
			</li>


			<li>
				<a href="/usershop"><img src="/{$temp}icons/shops1.png"> USER SHOPS</a>
			</li>


			<li>
				<a href="/pages/view/trashomatic3000"><img src="/{$temp}icons/shops1.png"> TRASH-O-MATIC</a>
			</li>


			<li>
				<a href="/inventory/alchemy"><img src="/{$temp}icons/alchemy.png">ALCHEMY</a>
			</li>


			<li>
				<a href="/search"><img src="/{$temp}icons/search1.png">SEARCH</a>
			</li>
		</ul>
    </div>
    <button class="accordion"><img src="/{$temp}icons/pets1s.png"> Pet care</button>
    <div class="panel">
        <ul>
    		<li>
    			<a href="/adopt"><img src="/{$temp}icons/pets1s.png">ADOPT</a>
    		</li>
    
    
    		<li>
    			<a href="/pound"><img src="/{$temp}icons/pets1s.png">POUND</a>
    		</li>
    
    
    		<li>
    			<a href="/levelup/daycare"><img src="/{$temp}icons/daycare1.png">DAYCARE</a>
    		</li>
    
    
    		<li>
    			<a href="/levelup/raising"><img src="/{$temp}icons/daycare1.png">RAISING</a>
    		</li>
    
    
    		<li>
    			<a href="/breeding"><img src="/{$temp}icons/personal1.png">BREEDING</a>
    		</li>
    
    
    		<li>
    			<a href="http://atrocity.mysidiahost.com/battle"><img src="/{$temp}icons/battlingbutton1.png"> BATTLE</a>
    		</li>
    
    
    		<li>
    			<a href="http://atrocity.mysidiahost.com/train"><img src="/{$temp}icons/train1.png"> TRAIN</a>
    		</li>
        </ul>
    </div>
    <button class="accordion"><img src="/{$temp}icons/mail.png">Communicate</button>
    <div class="panel">
        <ul>
			<li>
				<a href="/shoutbox"><img src="/{$temp}icons/Forums1.png">SHOUTBOX</a>
			</li>


			<li>
				<a href="/forum"><img src="/{$temp}icons/Forums1.png">FORUM</a>
			</li>


			<li>
				<a href="/messages"><img src="/{$temp}icons/mail.png">MAIL</a>
			</li>


			<li>
				<a href="/pages/view/submit"><img src="/{$temp}icons/mail.png">SUBMIT</a>
			</li>


			<li>
				<a href="/encyclopedia"><img src="http://atrocity.mysidiahost.com/picuploads/png/312ec8dafe13c8fd8059906d9898f1bc.png">ENCYCLOPEDIA</a>
			</li>
		</ul>
    </div>
</nav>

<hr/>
{if $logged_in}
    {$favpet}
{/if}

<!-- Login Form -->
{if !$logged_in}
    <!-- XXX This login form should have a unique ID seperate from the other login form - Zach -->
    <form id='login' class='login' action='/login' name='login' method='post'>
        <!--
        {if $logged_in == false}
        <div style="font-size: 30px; position: absolute; margin-top: -30px"><a href="/login">Login</a></div>
        {/if}
        -->
        <b>Member Login:</b>
        
        <label for="username">
            Username:
            <input id='username' name='username' value=''>
        </label>
        
        <label for="password">
            Password:
            <input id='password' name='password' type='password' value=''>
        </label>
        
        <button id='submit' value='submit' name='submit' type='submit'>Log In</button>
        
        <a href='/register'>Register New Account</a>
        <a href='/forgotpass'>Forgot Password?</a>
        
    </form>
{/if}

<?php
  include('...public_html/sidebarstats.php');
?>
