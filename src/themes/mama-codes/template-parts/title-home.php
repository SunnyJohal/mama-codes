<?php
/**
 * Page Title
 *
 * Displays the default page title on each page.
 *
 * @since 1.0.0
 * @version 1.0.0
 * @author Virginia Dooley <vcdooley@gmail.com>
 *
 */

$frontend = TT_Frontend::get_instance();
$context  = $frontend->get_context();
$template = TT_Template::get_instance();
?>
<!-- Title Markup -->
<div class="mc-title--bg">
	<div class="mc-title--overlay">
		<div class="mc-title--container container">
			<div class="mc-title--wrap">
				<div class="row">
					<!-- Title and Breadcrumbs -->
					<div class="col-xs-12 text-center">
						<h1 class="page-header"><?php echo $template->get_the_title(); ?></h1>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>




