<nav id="toolbox"> 
<span class="welcome-message">
	<h3>
		<?php global $current_user;
			get_currentuserinfo();
			$first_name = strtolower($current_user->user_firstname);
			echo 'Hej ' . ucfirst($first_name) . "!";
		?>
	</h3>
	<?php 
		$user = wp_get_current_user();
		if ( in_array( 'volunteer', (array) $user->roles ) ) {
    ?>
	<?php the_field('text_for_volontarer', 'options'); ?>
	<?php
    /* -- SALESFORCE FÖR VOLONTÄR -- */
    $user = wp_get_current_user();
    global $wpdb;
    $results = $wpdb->get_results('SELECT meta_value FROM ' . $wpdb->prefix . 'usermeta WHERE meta_key = "_salesforce_contact_id" AND user_id = ' . $user->ID);
    $salesforce_ID = $results[0]->meta_value;
    echo '<ul>';
    echo '<li><a target="_blank" href="http://berattarministeriet.force.com/GW_Volunteers__PersonalSiteContactInfo?contactId=' . $salesforce_ID . '&Email">Mina uppgifter</a></li>';
    echo '<li><a target="_blank" href="http://berattarministeriet.force.com/GW_Volunteers__JobCalendar?campaignId=7015800000019hk&ndaystoshow=1">Boka i Södertälje</a></li>';
    echo '<li><a target="_blank" href="http://berattarministeriet.force.com/GW_Volunteers__JobCalendar?campaignId=7015800000019ha&ndaystoshow=1">Boka i Husby</a></li>';
    echo '<li><a target="_blank" href="http://berattarministeriet.force.com/GW_Volunteers__JobCalendar?campaignId=7015800000019hV&ndaystoshow=1">Boka i Hagsätra</a></li>';
    echo '<li><a target="_blank" href="http://berattarministeriet.force.com/GW_Volunteers__JobCalendar?campaignId=701580000001W2A&ndaystoshow=1">Boka i Göteborg</a></li>';
    /* -- END SALESFORCE FÖR VOLONTÄR -- */
    ?>
	<?php if( have_rows('volontarer-meny-verktyg', 'options') ): ?>
	<?php while( have_rows('volontarer-meny-verktyg', 'options') ): the_row(); ?>
		<li>
			<a target="_blank" href="<?php the_sub_field('lank-meny-verktyg-vol', 'options'); ?>">
				<?php the_sub_field('lanktext-meny-verktyg-vol', 'options'); ?>
			</a>
		</li>
	<?php endwhile; ?>
	<?php endif; ?>
	</ul>
	<a id="logga-ut" href="<?php echo wp_logout_url( get_permalink() ); ?>">Logga ut</a>
	<?php } elseif ( in_array( 'teacher', (array) $user->roles ) ) {?>
	<?php the_field('text_for_larare', 'options'); ?>
	<?php
    	/* -- SALESFORCE FÖR LÄRARE -- */
    	$user = wp_get_current_user();
        global $wpdb;
        $results = $wpdb->get_results('SELECT meta_value FROM ' . $wpdb->prefix . 'usermeta WHERE meta_key = "_salesforce_contact_id" AND user_id = ' . $user->ID);
        $salesforce_ID = $results[0]->meta_value;
        echo '<ul>';
        //echo '<li><a target="_blank" href="http://berattarministeriet.force.com/GW_Volunteers__PersonalSiteContactInfo?contactId=' . $salesforce_ID . '&Email">Mina uppgifter</a></li>';
        echo '<li><a target="_blank" href="http://berattarministeriet.force.com/GW_Volunteers__JobCalendar?campaignId=701580000001B2W&ndaystoshow=1">Boka i Södertälje</a></li>';
        echo '<li><a target="_blank" href="http://berattarministeriet.force.com/GW_Volunteers__JobCalendar?campaignId=701580000001BMM&ndaystoshow=1">Boka i Husby</a></li>';
        echo '<li><a target="_blank" href="http://berattarministeriet.force.com/GW_Volunteers__JobCalendar?campaignId=701580000001BMR&ndaystoshow=1">Boka i Hagsätra</a></li>';
        echo '<li><a target="_blank" href="http://berattarministeriet.force.com/GW_Volunteers__JobCalendar?campaignId=701580000001W2F&ndaystoshow=1">Boka i Göteborg</a></li>';
        /* -- END SALESFORCE FÖR LÄRARE -- */
    ?>
	<?php if( have_rows('larare-meny-verktyg', 'options') ): ?>
	<?php while( have_rows('larare-meny-verktyg', 'options') ): the_row(); ?>
		<li>
			<a target="_blank" href="<?php the_sub_field('lank-meny-verktyg-lar', 'options'); ?>">
				<?php the_sub_field('lanktext-meny-verktyg-lar', 'options'); ?>
			</a>
		</li>
	<?php endwhile; ?>
	<?php endif; ?>
	</ul>
	<a id="logga-ut" href="<?php echo wp_logout_url( get_permalink() ); ?>">Logga ut</a>
	<?php } else { ?>
	<a id="logga-ut" href="<?php echo wp_logout_url( get_permalink() ); ?>">Logga ut</a>
	<?php } ?>
	</span>
</nav>
