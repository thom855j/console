    <div id="menu">
    	<?php if( session()['auth'] ): ?>
        	<b><p class="logout"><a id="exit" href="#">LOGOUT</a></p></b>
        	<p><b>CONNECTED TO TERMINAL:</b> <?php echo $host; ?></p>
    	<?php endif; ?>
        <div style="clear:both"></div>
    </div>  
