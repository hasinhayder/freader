<div class="feeds" id="feedscanvas">
	<?php
	while(have_posts()){ the_post(); ?>
	<div class="feed">
		<div class="icon"> ☆ </div>
		<div class="info"> <?php the_author( );?> </div>
		<div class="content"> <?php the_title();?> </div>
		<div class="meta"> <?php the_time();?> </div>
		<div class="clear"></div>
	</div>	
	<?php } ?>
</div>

