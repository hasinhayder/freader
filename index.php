<?php
get_template_part( "header" );
?>
<div class="container-fluid">
	<div class="row-fluid">
		<div class="span12">
			<?php get_template_part( "content", "header" );?>
		</div>
	</div>
	<div class="row-fluid">
		<div class="span4">
			<?php get_sidebar();?>
		</div>
		<div class="span8">
			<?php get_template_part( "content", "home" );?>
		</div>
	</div>
</div>

<?php
get_template_part( "footer" );
?>