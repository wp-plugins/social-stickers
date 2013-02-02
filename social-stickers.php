<?php

	/* 
		Plugin Name: Social Stickers
		Plugin URI: http://wpplugz.is-leet.com
		Description: A simple plugin that shows the social networks you use.
		Version: 1.5.3
		Author: Bostjan Cigan
		Author URI: http://bostjan.gets-it.net
		License: GPL v2
	*/ 
	
	// Wordpress formalities here ...
	
	// Lets register things
	register_activation_hook(__FILE__, 'social_stickers_install');
	add_action('admin_menu', 'social_stickers_admin_menu_create');
	add_action('widgets_init', create_function('', 'return register_widget("social_stickers_widget");')); // Register the widget
	wp_enqueue_script('social-stickers-sortable-script', plugin_dir_url(__FILE__).'js/sortable.js', array( "jquery", "jquery-ui-core", "jquery-ui-sortable")); 
	
	$options = get_option('social_stickers_settings');
	if(is_array($options)) {
		if(((float)$options['version']) < 1.53) {
			update_social_stickers();
		}	
	}
	
	// Prepare the array for our DB variables
	function social_stickers_install() {

		$plugin_options = array(
			'version' => '1.53',
			'prefix' => '',
			'suffix' => '',
			'powered_by_msg' => false,
			'mode' => 0, // Mode of output - 0 is 32x32 icon, 1 is 64x64 icon, 2 is 128x128 icon, 3 is small icon and text
			'theme' => 'default',
			'show_edit_url' => false,
			'link_new' => false,
			'theme_stickers_order' => array( // Each theme has its own order of sticker positions
				"default" => NULL
			),
			'stickers' => array(
				'500px' => array(
					'url' => 'http://500px.com/[:username]',
					'name' => '500px',
					'active' => false,
					'username' => ''
				),
				'aboutme' => array(
					'url' => 'http://about.me/[:username]',
					'name' => 'About Me',
					'active' => false,
					'username' => ''
				),
				'aim' => array(
					'url' => 'aim:goim?screenname=[:username]',
					'name' => 'AIM',
					'active' => false,
					'username' => ''
				),
				'appnet' => array(
					'url' => 'https://alpha.app.net/[:username]',
					'name' => 'app.net',
					'active' => false,
					'username' => ''
				),
				'behance' => array(
					'url' => 'http://behance.net/[:username]',
					'name' => 'Behance',
					'active' => false,
					'username' => ''
				),
				'bebo' => array(
					'url' => 'http://bebo.com/[:username]',
					'name' => 'Bebo',
					'active' => false,
					'username' => ''
				),
				'blogconnect' => array(
					'url' => 'http://blog-connect.com/a?id=[:username]',
					'name' => 'Blogconnect',
					'active' => false,
					'username' => ''
				),
				'blogger' => array(
					'url' => 'http://[:username].blogspot.com/',
					'name' => 'Blogger',
					'active' => false,
					'username' => ''
				),
				'bloglovin' => array(
					'url' => 'http://www.bloglovin.com/en/blog/[:username]',
					'name' => 'Bloglovin',
					'active' => false,
					'username' => ''
				),
				'coderwall' => array(
					'url' => 'http://coderwall.com/[:username]',
					'name' => 'Coderwall',
					'active' => false,
					'username' => ''
				),
				'dailybooth' => array(
					'url' => 'http://dailybooth.com/[:username]',
					'name' => 'Dailybooth',
					'active' => false,
					'username' => ''
				),
				'delicious' => array(
					'url' => 'http://delicious.com/[:username]',
					'name' => 'Delicious',
					'active' => false,
					'username' => ''
				),
				'designfloat' => array(
					'url' => 'http://www.designfloat.com/user/profile/[:username]',
					'name' => 'Designfloat',
					'active' => false,
					'username' => ''
				),
				'deviantart' => array(
					'url' => 'http://[:username].deviantart.com',
					'name' => 'Deviantart',
					'active' => false,
					'username' => ''
				),
				'digg' => array(
					'url' => 'http://digg.com/[:username]',
					'name' => 'Digg',
					'active' => false,
					'username' => ''
				),
				'dribble' => array(
					'url' => 'http://dribbble.com/[:username]',
					'name' => 'Dribble',
					'active' => false,
					'username' => ''
				),
				'ebay' => array(
					'url' => 'http://myworld.ebay.com/[:username]',
					'name' => 'Ebay',
					'active' => false,
					'username' => ''
				),
				'email' => array(
					'url' => 'mailto:[:username]',
					'name' => 'Email',
					'active' => false,
					'username' => ''				
				),
				'exfm' => array(
					'url' => 'http://ex.fm/[:username]',
					'name' => 'exfm',
					'active' => false,
					'username' => ''
				),
				'etsy' => array(
					'url' => 'http://[:username].etsy.com',
					'name' => 'Etsy',
					'active' => false,
					'username' => ''
				),
				'flickr' => array(
					'url' => 'http://www.flickr.com/people/[:username]',
					'name' => 'Flickr',
					'active' => false,
					'username' => ''
				),
				'facebook' => array(
					'url' => 'http://facebook.com/[:username]',
					'name' => 'Facebook',
					'active' => false,
					'username' => ''
				),
				'forrst' => array(
					'url' => 'http://forrst.me/[:username]',
					'name' => 'Forrst',
					'active' => false,
					'username' => ''
				),
				'formspring' => array(
					'url' => 'http://www.formspring.me/[:username]',
					'name' => 'Formspring',
					'active' => false,
					'username' => ''
				),
				'foursquare' => array(
					'url' => 'https://foursquare.com/[:username]',
					'name' => 'Foursquare',
					'active' => false,
					'username' => ''
				),
				'github' => array(
					'url' => 'http://github.com/[:username]',
					'name' => 'Github',
					'active' => false,
					'username' => ''
				),
				'geeklist' => array(
					'url' => 'http://geekli.st/[:username]',
					'name' => 'Geeklist',
					'active' => false,
					'username' => ''
				),
				'googleplus' => array(
					'url' => 'http://plus.google.com/[:username]',
					'name' => 'Google+',
					'active' => false,
					'username' => ''
				),
				'goodreads' => array(
					'url' => 'http://www.goodreads.com/[:username]',
					'name' => 'Goodreads',
					'active' => false,
					'username' => ''
				),
				'gravatar' => array(
					'url' => 'http://gravatar.com/[:username]',
					'name' => 'Gravatar',
					'active' => false,
					'username' => ''
				),
				'grooveshark' => array(
					'url' => 'http://grooveshark.com/[:username]',
					'name' => 'Grooveshark',
					'active' => false,
					'username' => ''
				),
				'hi5' => array(
					'url' => 'http://www.hi5.com/[:username]',
					'name' => 'Hi5',
					'active' => false,
					'username' => ''
				),				
				'imdb' => array(
					'url' => 'http://imdb.com/user/[:username]',
					'name' => 'IMDB',
					'active' => false,
					'username' => ''
				),
				'instagram' => array(
					'url' => 'http://instagram.com/[:username]',
					'name' => 'Instagram',
					'active' => false,
					'username' => ''
				),
				'lastfm' => array(
					'url' => 'http://last.fm/user/[:username]',
					'name' => 'LastFM',
					'active' => false,
					'username' => ''
				),
				'livejournal' => array(
					'url' => 'http://[:username].livejournal.com/',
					'name' => 'Livejournal',
					'active' => false,
					'username' => ''
				),
				'linkedin' => array(
					'url' => 'http://linkedin.com/in/[:username]',
					'name' => 'Linkedin',
					'active' => false,
					'username' => ''
				),
				'lovelybooks' => array(
					'url' => 'http://www.lovelybooks.de/mitglied/[:username]',
					'name' => 'Lovelybooks',
					'active' => false,
					'username' => ''
				),
				'myspace' => array(
					'url' => 'http://myspace.com/[:username]',
					'name' => 'Myspace',
					'active' => false,
					'username' => ''
				),
				'newsvine' => array(
					'url' => 'http://[:username].newsvine.com/',
					'name' => 'Newsvine',
					'active' => false,
					'username' => ''
				),
				'orkut' => array(
					'url' => 'http://www.orkut.com/Profile.aspx?uid=[:username]',
					'name' => 'Orkut',
					'active' => false,
					'username' => ''
				),
				'picassa' => array(
					'url' => 'http://picasaweb.google.com/[:username]',
					'name' => 'Picassa',
					'active' => false,
					'username' => ''
				),
				'pinboard' => array(
					'url' => 'https://pinboard.in/u:[:username]',
					'name' => 'Pinboard',
					'active' => false,
					'username' => ''
				),
				'pinterest' => array(
					'url' => 'http://pinterest.com/[:username]',
					'name' => 'Pinterest',
					'active' => false,
					'username' => ''
				),
				'posterous' => array(
					'url' => 'http://[:username].posterous.com',
					'name' => 'Posterous',
					'active' => false,
					'username' => ''
				),
				'ravelry' => array(
					'url' => 'http://www.ravelry.com/people/[:username]',
					'name' => 'Ravelry',
					'active' => false,
					'username' => ''
				),
				'rss' => array(
					'url' => '[:username]',
					'name' => 'RSS',
					'active' => false,
					'username' => ''
				),
				'quora' => array(
					'url' => 'http://quora.com/[:username]',
					'name' => 'Quora',
					'active' => false,
					'username' => ''
				),
				'orkut' => array(
					'url' => 'http://www.orkut.com/Profile.aspx?uid=[:username]',
					'name' => 'Orkut',
					'active' => false,
					'username' => ''
				),
				'qik' => array(
					'url' => 'http://qik.com/[:username]',
					'name' => 'Qik',
					'active' => false,
					'username' => ''
				),
				'slashdot' => array(
					'url' => 'http://[:username].slashdot.org',
					'name' => 'Slashdot',
					'active' => false,
					'username' => ''
				),
				'slideshare' => array(
					'url' => 'http://www.slideshare.net/[:username]',
					'name' => 'Slideshare',
					'active' => false,
					'username' => ''
				),
				'snapjoy' => array(
					'url' => 'https://[:username].snapjoy.com',
					'name' => 'Snapjoy',
					'active' => false,
					'username' => ''
				),
				'soundcloud' => array(
					'url' => 'http://soundcloud.com/[:username]',
					'name' => 'Soundcloud',
					'active' => false,
					'username' => ''
				),
				'skype' => array(
					'url' => 'skype:[:username]?call',
					'name' => 'Skype',
					'active' => false,
					'username' => ''
				),
				'steam' => array(
					'url' => 'http://steamcommunity.com/id/[:username]',
					'name' => 'Steam',
					'active' => false,
					'username' => ''
				),
				'stumbleupon' => array(
					'url' => 'http://stumbleupon.com/stumbler/[:username]',
					'name' => 'Stumbleupon',
					'active' => false,
					'username' => ''
				),
				'tumblr' => array(
					'url' => 'http://[:username].tumblr.com',
					'name' => 'Tumblr',
					'active' => false,
					'username' => ''
				),
				'orkut' => array(
					'url' => 'http://www.orkut.com/Profile.aspx?uid=[:username]',
					'name' => 'Orkut',
					'active' => false,
					'username' => ''
				),
				'twitter' => array(
					'url' => 'http://twitter.com/[:username]',
					'name' => 'Twitter',
					'active' => false,
					'username' => ''
				),
				'vimeo' => array(
					'url' => 'http://vimeo.com/[:username]',
					'name' => 'Vimeo',
					'active' => false,
					'username' => ''
				),
				'youtube' => array(
					'url' => 'http://youtube.com/[:username]',
					'name' => 'Youtube',
					'active' => false,
					'username' => ''
				),
				'yelp' => array(
					'url' => 'http://[:username].yelp.com',
					'name' => 'Yelp',
					'active' => false,
					'username' => ''
				),
				'zerply' => array(
					'url' => 'http://zerp.ly/[:username]',
					'name' => 'Zerply',
					'active' => false,
					'username' => ''
				),
				'zootool' => array(
					'url' => 'http://zootool.com/user/[:username]',
					'name' => 'Zootool',
					'active' => false,
					'username' => ''
				),
				'xing' => array(
					'url' => 'http://www.xing.com/profile/[:username]',
					'name' => 'Xing',
					'active' => false,
					'username' => ''
				),
				'wordpress' => array(
					'url' => 'http://[:username].wordpress.com',
					'name' => 'Wordpress',
					'active' => false,
					'username' => ''
				)
			) // End of stickers
		);
		add_option('social_stickers_settings', $plugin_options);
	
	}

	function update_social_stickers() {
		$options = get_option('social_stickers_settings');
		if(((float) $options['version']) < 1.53) {
			$options['version'] = '1.53';
			
			$options['stickers']['bloglovin'] = array(
					'url' => 'http://www.bloglovin.com/en/blog/[:username]',
					'name' => 'Bloglovin',
					'active' => false,
					'username' => ''
			);
			$options['stickers']['lovelybooks'] = array(
					'url' => 'http://www.lovelybooks.de/mitglied/[:username]',
					'name' => 'Lovelybooks',
					'active' => false,
					'username' => ''
			);
			$options['stickers']['blogconnect'] = array(
					'url' => 'http://blog-connect.com/a?id=[:username]',
					'name' => 'Blogconnect',
					'active' => false,
					'username' => ''
			);
			
			if(!isset($options['stickers']['ravelry'])) {
				$options['stickers']['ravelry'] = array(
					'url' => 'http://www.ravelry.com/people/[:username]',
					'name' => 'Ravelry',
					'active' => false,
					'username' => ''
				);
			}
			if(!isset($options['stickers']['appnet'])) {
				$options['stickers']['appnet'] = array(
					'url' => 'https://alpha.app.net/[:username]',
					'name' => 'app.net',
					'active' => false,
					'username' => ''
				);
			}
			if(!isset($options['stickers']['snapjoy'])) {
				$options['stickers']['snapjoy'] = array(
					'url' => 'https://[:username].snapjoy.com',
					'name' => 'Snapjoy',
					'active' => false,
					'username' => ''
				);
			}
			if(!isset($options['stickers']['coderwall'])) {
				$options['stickers']['coderwall'] = array(
					'url' => 'http://coderwall.com/[:username]',
					'name' => 'Coderwall',
					'active' => false,
					'username' => ''
				);
			}
			if(!isset($options['stickers']['email'])) {
				$options['stickers']['email'] = array(
					'url' => 'mailto:[:username]',
					'name' => 'Email',
					'active' => false,
					'username' => ''				
				);
			}
			if(!isset($options['stickers']['rss'])) {
				$options['stickers']['rss'] = array(
					'url' => '[:username]',
					'name' => 'RSS',
					'active' => false,
					'username' => ''
				);
			}
			if(!isset($options['stickers']['500px'])) {
				$options['stickers']['500px'] = array(
					'url' => 'http://500px.com/[:username]',
					'name' => '500px',
					'active' => false,
					'username' => ''
				);
			}
			if(!isset($options['stickers']['instagram'])) {
				$options['stickers']['instagram'] = array(
					'url' => 'http://instagram.com/[:username]',
					'name' => 'Instagram',
					'active' => false,
					'username' => ''
				);
			}
			if(!isset($options['stickers']['goodreads'])) {
				$options['stickers']['goodreads'] = array(
					'url' => 'http://www.goodreads.com/[:username]',
					'name' => 'Goodreads',
					'active' => false,
					'username' => ''
				);
			}
			$options['show_edit_url'] = (isset($options['show_edit_url'])) ? $options['show_edit_url'] : false;
			$options['stickers']['googleplus']['url'] = "http://plus.google.com/[:username]";
			$options['stickers']['xing']['url'] = "http://www.xing.com/profile/[:username]";
			$options['link_new'] = (isset($options['link_new'])) ? $options['link_new'] : false;
			update_option('social_stickers_settings', $options);
			
		}

	}

	// Create the admin menu
	function social_stickers_admin_menu_create() {
		add_options_page('Social Stickers Settings', 'Social Stickers', 'administrator', __FILE__, 'social_stickers_settings');
	}
	
	// Scan themes directory for themes
	function social_stickers_get_themes() {

		$themes = array();
		$theme_path = plugin_dir_path(__FILE__)."/themes";
		foreach(new DirectoryIterator($theme_path) as $file) {
			if($file->isDot()) continue;
			if(is_dir($theme_path.'/'.$file->getFilename())) {
				$theme_data = array(
					'id' => '',
					'name' => '',
					'author' => '',
					'webpage' => '',
					'description' => ''
				);
				$path = plugin_dir_path(__FILE__).'themes/'.$file->getFilename().'/theme.txt';
				if(file_exists($path)) {
					$contents = file_get_contents($path);
					$author = substr($contents, strpos($contents, "Author: ")+8, strpos($contents, "Webpage: ") - strpos($contents, "Author: ") - 10);
					$name = substr($contents, strpos($contents, "Name: ")+6, strpos($contents, "Author: ") - strpos($contents, "Name: ")-6);
					$webpage = substr($contents, strpos($contents, "Webpage: ")+9, strpos($contents, "Description: ") - 9 - strpos($contents, "Webpage: "));
					$description = substr($contents, strpos($contents, "Description: ")+13, strlen($contents)-1);
					$theme_data['author'] = $author;
					$theme_data['name'] = $name;
					$theme_data['webpage'] = $webpage;
					$theme_data['description'] = $description;;
					$theme_data['id'] = $file->getFilename();
					array_push($themes, $theme_data);
				}
			}
		}

		return $themes;
		
	}

	// The plugin admin page
	function social_stickers_settings() {

		$message = "";

		if(isset($_POST['theme'])) {
			$options = get_option('social_stickers_settings');
			$theme = $_POST['theme'];
			$options['theme'] = $theme;
			$order = $_POST['social_stickers_order'];
			$powered_by = $_POST['powered_by'];
			$mode = $_POST['social_stickers_mode'];
			$prefix = $_POST['prefix'];
			$suffix = $_POST['suffix'];
			$link_new = $_POST['link_new'];
			$show_edit_url = $_POST['show_edit_url'];
						
			$options['powered_by_msg'] = (isset($powered_by)) ? true : false;
			$options['link_new'] = (isset($link_new)) ? true : false;
			$options['mode'] = intval($mode);
			$options['prefix'] = $prefix;
			$options['suffix'] = $suffix;
			$options['show_edit_url'] = (isset($show_edit_url)) ? true : false;
			
			$stickers_order = array();
			
			if(isset($order) && strlen($order) > 0) {
			
				$social_stickers_order_ar = explode("social[]=", $order);
				$order_no = 1;
				foreach($social_stickers_order_ar as $sticker) {
					$sticker = str_replace("&", "", $sticker);
					if(strlen($sticker) > 0 && strlen($_POST[$sticker]) > 0) {
						array_push($stickers_order, $sticker);
					}
				}
				
			}
			
			if(count($stickers_order) == 0) {
				$stickers_order = $options['theme_stickers_order'][$options['theme']];	
			}
			
			if(!is_array($stickers_order)) {
				$stickers_order = array();	
			}
			
			foreach($options['stickers'] as $key => $data) {
				$current_sticker = $_POST[$key];
				if($options['show_edit_url']) {
					$url = $_POST[$key.'_url'];
					if(isset($url)) {
						$options['stickers'][$key]['url'] = $url;						
					}
				}
				if(isset($current_sticker)) {
					$options['stickers'][$key]['username'] = $current_sticker;
					if(strlen($current_sticker) > 0 && !in_array($key, $stickers_order)) {
						array_push($stickers_order, $key);	
					}
				}
			}

			$stickers_final_order = array();
			
			foreach($stickers_order as $sticker) {
				if(strlen($options['stickers'][$sticker]['username']) > 0) {
					array_push($stickers_final_order, $sticker);	
				}
			}

			$options['theme_stickers_order'][$options['theme']] = $stickers_final_order;
			
			update_option('social_stickers_settings', $options);		
			$message = "Plugin options updated.";
			
			$delete = $_POST['delete_data'];
			if(isset($delete)) {
				delete_option('social_stickers_settings');
				$message = "Social Stickers data was deleted from the database.";
			}
		}

		$options = get_option('social_stickers_settings');

		if(!is_array($options)) {
			$message = "You've successfully deleted all Social Stickers data from the database. You can now deactivate the plugin.";	
		}
		
?>

		<div id="icon-options-general" class="icon32"></div><h2>Social Stickers Settings</h2>
<?php

		if(strlen($message) > 0) {
		
?>

			<div id="message" class="updated">
				<p><strong><?php echo $message; ?></strong></p>
			</div>

<?php
			
		}

		if(is_array($options)) {
?>


                <h3>General Settings</h3>
                <form method="post" action="">
                <input id="social_stickers_order" name="social_stickers_order" type="hidden" value="" />
				<table class="form-table">
					<tr>
						<th scope="row"><img src="<?php echo plugin_dir_url(__FILE__).'icon.png'; ?>" height="96px" width="96px" /></th>
						<td>
							<p>Thank you for using this plugin. If you like the plugin, you can <a href="http://gum.co/social-stickers">buy me a cup of coffee</a><script type="text/javascript" src="https://gumroad.com/js/gumroad-button.js"></script><script type="text/javascript" src="https://gumroad.com/js/gumroad.js"></script> :)</p> 
							<p>You can visit the official website and download more themes @ <a href="http://wpplugz.is-leet.com">wpPlugz</a>.</p>
                        </td>
					</tr>
                    <tr>
						<th scope="row"><label for="theme">Pick your theme</label></th>
						<td>
							<select name="theme" id="theme" onchange="document.forms[0].submit()">
<?php

							$theme_string = "";
							$themes = social_stickers_get_themes();
							foreach($themes as $theme) {
?>
								<option value="<?php echo $theme['id']; ?>" <?php if($theme['id'] == $options['theme']) { ?> selected="selected" <?php } ?>><?php echo esc_attr($theme['name']); ?></option>
<?php 							if($theme['id'] == $options['theme']) {
									$theme_string = $theme_string.$theme['name'].' by <a href="'.$theme['webpage'].'">'.$theme['author'].'</a> - '.$theme['description'];								
								}
							}
?>
							</select>
                            <br /><span class="description"><?php echo sprintf("%s", $theme_string); ?></span> 
                        </td>
					</tr>
					<tr>
						<th scope="row">Social stickers order</th>
						<td>
                        	<?php echo display_social_stickers(true); ?>
                            <br /><br /><span class="description">Click on the icon, hold it and move it around to change the order.</span>
                        </td>
					</tr>
					<tr>
						<th scope="row">Social stickers size</th>
						<td>
							<select name="social_stickers_mode" id="social_stickers_mode">
								<option value="0" <?php if($options['mode'] == 0) { ?> selected <?php } ?>>Small (32px)</option>
								<option value="1" <?php if($options['mode'] == 1) { ?> selected <?php } ?>>Medium (64px)</option>
								<option value="2" <?php if($options['mode'] == 2) { ?> selected <?php } ?>>Large (128px)</option>
								<option value="3" <?php if($options['mode'] == 3) { ?> selected <?php } ?>>Icons and text (16px)</option>
							</select>
                            <br /><span class="description">Pick how the social stickers should be shown.</span>
                        </td>
					</tr>
					<tr>
						<th scope="row">Message before (prefix)</th>
						<td>
		                    <textarea rows="3" cols="80" name="prefix" id="prefix" ><?php echo esc_attr(stripslashes($options['prefix'])); ?></textarea>
                            <br /><span class="description">Input text that you want to print before the social stickers are outputed.</span>
                        </td>
					</tr>
					<tr>
						<th scope="row">Message after (suffix)</th>
						<td>
		                    <textarea rows="3" cols="80" name="suffix" id="suffix" ><?php echo esc_attr(stripslashes($options['suffix'])); ?></textarea>
                            <br /><span class="description">Input text that you want to print after the social stickers are outputed.</span>
                        </td>
					</tr>
					<tr>
						<th scope="row">Open links in new window</th>
						<td>
                        	<input name="link_new" id="link_new" type="checkbox" <?php if($options['link_new']) { ?> checked="checked" <?php } ?>/>
                            <br /><span class="description">Check this to open all social links in new tabs.</span>
                        </td>
					</tr>
					<tr>
						<th scope="row">Edit social network URLs (advanced)</th>
						<td>
                        	<input name="show_edit_url" id="show_edit_url" type="checkbox" <?php if($options['show_edit_url']) { ?> checked="checked" <?php } ?>/>
                            <br /><span class="description">Check this box and update to show fields for updating social network URLs (advanced feature).</span>
                        </td>
					</tr>
					<tr>
						<th scope="row">Delete all plugin data</th>
						<td>
                        	<input name="delete_data" id="delete_data" type="checkbox" />
                            <br /><span class="description">If you plan on deleting this plugin, mark this checkbox to delete all the data. Bear in mind that this action is unrecoverable.</span>
                        </td>
					</tr>
					<tr>
						<th scope="row">Show powered by message</th>
						<td>
                        	<input name="powered_by" id="powered_by" type="checkbox" <?php if($options['powered_by_msg']) { ?> checked="checked" <?php } ?>/>
                            <br /><span class="description">Show powered by message, if you decide not to show it, please consider a <a href="http://gum.co/social-stickers">donation</a><script type="text/javascript" src="https://gumroad.com/js/gumroad-button.js"></script><script type="text/javascript" src="https://gumroad.com/js/gumroad.js"></script>.</span>
                        </td>
					</tr>
                 </table>
                
                <?php echo $options['post_request']; ?>
                
   				<br /><h3>Configure your social networks</h3>
                
				<table class="form-table">
<?php

		foreach($options['stickers'] as $name => $data) {
			if(social_icon_exists($name, $options['theme'])) {			
?>				
					<tr>
						<th scope="row"><label for="<?php echo $name; ?>"><?php echo $data['name']; ?></label></th>
						<td>
							<input type="text" name="<?php echo $name; ?>" value="<?php echo esc_attr(stripslashes($data['username'])); ?>" id="<?php echo $name; ?>" size="40"/>
							<br />
            				<span class="description">Your username looks like this: <?php echo str_replace(array('[:', ']'), array('', ''), $data['url']); ?>.</span>
                            <?php if($options['show_edit_url']) { ?>
                            <br />
							<input type="text" name="<?php echo $name.'_url'; ?>" value="<?php echo esc_attr(stripslashes($data['url'])); ?>" id="<?php echo $name.'_url'; ?>" size="40"/>
                            <br />
                            <span class="description">Customize your <?php echo $data['name']; ?> profile URL.</span>
                            <?php } ?>
						</td>
					</tr>
<?php 

			} 
			
		}
?>
				</table>					
				<p><input type="submit" name="Submit" class="button-primary" value="<?php esc_attr_e('Update options') ?>" /></p>
				</form>
	

<?php

		}
		
	}
	
	function social_icon_exists($file, $theme) {
		$path = plugin_dir_path(__FILE__).'themes/'.$theme.'/'.$file.'.png';
		if(file_exists($path)) {
			return true;	
		}
		return false;
	}

	function display_social_stickers($sortable) {
	
		$options = get_option('social_stickers_settings');
		$output = "";
		$is_any_active = false;
		
		if(!$sortable) {
			$output = $output.stripslashes($options['prefix']);	
		}
		
		if($sortable) $output = $output.'<div id="sortable">';
		$stickers_theme_order = $options['theme_stickers_order'][$options['theme']];
		
		$stickers = array();
		
		if(is_array($stickers_theme_order)) {
			foreach($stickers_theme_order as $sticker) {
				array_push($stickers, $sticker);
			}
		}
		else {
			foreach($options['stickers'] as $key => $data) {
				if(strlen($data['username']) > 0) {
					array_push($stickers, $key);
				}
			}
		}
		
		foreach($stickers as $key) {
			$data = $options['stickers'][$key];
			$file = plugin_dir_path(__FILE__).'themes/'.$options['theme'].'/'.$key.'.png';
			$file_url = plugin_dir_url(__FILE__).'themes/'.$options['theme'].'/'.$key.'.png';
			$social_url = str_replace("[:username]", $data['username'], $data['url']);
			if(file_exists($file)) {
				$is_any_active = true;
				if($sortable) $options['mode'] = 0;
				switch($options['mode']) {
					case 0:
						if($sortable) {
							$output = $output.'<div id="social_'.$key.'" style="margin-left: 3px; float: left;"> <a href="'.$social_url.'" title="'.$data['name'].'"><img src="'.$file_url.'" height="32px" width="32px" /></a></div>';
						}
						else {
							if($options['link_new']) {
								$output = $output.' <a href="'.$social_url.'" title="'.$data['name'].'" target="_blank"><img src="'.$file_url.'" height="32px" width="32px" /></a>';
							}
							else {
								$output = $output.' <a href="'.$social_url.'" title="'.$data['name'].'"><img src="'.$file_url.'" height="32px" width="32px" /></a>';
							}							
						}
					break;
					case 1:
						if($options['link_new']) {
							$output = $output.' <a href="'.$social_url.'" title="'.$data['name'].'" target="_blank"><img src="'.$file_url.'" height="64px" width="64px" /></a>';
						}
						else {
							$output = $output.' <a href="'.$social_url.'" title="'.$data['name'].'"><img src="'.$file_url.'" height="64px" width="64px" /></a>';
						}							
					break;
					case 2:
						if($options['link_new']) {
							$output = $output.' <a href="'.$social_url.'" title="'.$data['name'].'" target="_blank"><img src="'.$file_url.'" height="128px" width="128px" /></a>';
						}
						else {
							$output = $output.' <a href="'.$social_url.'" title="'.$data['name'].'"><img src="'.$file_url.'" height="128px" width="128px" /></a>';
						}							
					break;	
					case 3:
						if($options['link_new']) {
							$output = $output.'<img src="'.$file_url.'" height="16px" width="16px" alt="'.$data['name'].'" /> <a href="'.$social_url.'" target="_blank">'.$data['name'].'</a><br />';
						}
						else {
							$output = $output.'<img src="'.$file_url.'" height="16px" width="16px" alt="'.$data['name'].'" /> <a href="'.$social_url.'">'.$data['name'].'</a><br />';
						}							
					break;	
				}
			}
		}
		
		if($sortable) {
			$output = $output."</div>";	
		}
		
		if(!$is_any_active) {
			if($sortable) $output = $output.'<span class="description">Please enter a username for any of the available profiles to see the preview.</span>';
			else $output = $output.'<span class="description">No social profiles are available.</span>';
		}
		
		if(!$sortable && $options['powered_by_msg']) {
			$output = $output.'<br /><br />Powered by <a href="http://wpplugz.is-leet.com">wpPlugz</a>.';	
		}
		
		if(!$sortable) {
			$output = $output.stripslashes($options['suffix']);	
		}

		
		echo $output;
		
	}
	
	// Here, the widget code begins
	class social_stickers_widget extends WP_Widget {
		
		function social_stickers_widget() {
			$widget_ops = array('classname' => 'social_stickers_widget', 'description' => 'Display the social networks you use!' );			
			$this->WP_Widget('social_stickers_widget', 'Social Stickers', $widget_ops);
		}
		
		function widget($args, $instance) {
			
			extract($args);
			$title = apply_filters('widget_title', $instance['title']);
			
			echo $before_widget;

			if($title) {
				echo $before_title . $title . $after_title;
			}
			
			// The widget code and the widgeet output
			
			display_social_stickers(false);
			
			// End of widget output
			
			echo $after_widget;
			
		}
		
	    function update($new_instance, $old_instance) {		
			$instance = $old_instance;
			$instance['title'] = strip_tags($new_instance['title']);
	        return $instance;
    	}
		
		function form($instance) {	

        	$title = esc_attr($instance['title']);
		
?>

			<p>
				<label for="<?php echo $this->get_field_id('title'); ?>">
					<?php _e('Title: '); ?>
	            </label> 
				<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" />
			</p>

<?php 

		}

	}
	
?>
