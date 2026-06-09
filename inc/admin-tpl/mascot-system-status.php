<?php
// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Cannot access pages directly.' );
}
?>
<?php
Class Shadhin_plugins_Get_System_Status {
	/**
	 * let_to_num function.
	 *
	 * This function transforms the php.ini notation for numbers (like '2M') to an integer.
	 *
	 * @param $size
	 * @return int
	 */
	function convert_let_to_num( $size ) {
		 $l   = substr( $size, -1 );
		 $ret = substr( $size, 0, -1 );
		 switch ( strtoupper( $l ) ) {
			 case 'P':
				 $ret *= 1024;
			 case 'T':
				 $ret *= 1024;
			 case 'G':
				 $ret *= 1024;
			 case 'M':
				 $ret *= 1024;
			 case 'K':
				 $ret *= 1024;
		 }
		 return $ret;
	}

	/**
	 * Get array of environment information. Includes thing like software
	 * versions, and various server settings.
	 *
	 * @return array
	 */
	public function get_environment_info() {
		global $wpdb;

		// Figure out cURL version, if installed.
		$curl_version = '';
		if ( function_exists( 'curl_version' ) ) {
			$curl_version = curl_version();
			$curl_version = $curl_version['version'] . ', ' . $curl_version['ssl_version'];
		}

		// WP memory limit
		$wp_memory_limit = $this->convert_let_to_num( WP_MEMORY_LIMIT );
		if ( function_exists( 'memory_get_usage' ) ) {
			$wp_memory_limit = max( $wp_memory_limit, $this->convert_let_to_num( @ini_get( 'memory_limit' ) ) );
		}

		// Return all environment info. Described by JSON Schema.
		return array(
			'home_url'                  => get_option( 'home' ),
			'site_url'                  => get_option( 'siteurl' ),
			'wp_version'                => get_bloginfo( 'version' ),
			'wp_multisite'              => is_multisite(),
			'wp_memory_limit'           => $wp_memory_limit,
			'wp_debug_mode'             => ( defined( 'WP_DEBUG' ) && WP_DEBUG ),
			'wp_cron'                   => ! ( defined( 'DISABLE_WP_CRON' ) && DISABLE_WP_CRON ),
			'language'                  => get_locale(),
			'server_info'               => $_SERVER['SERVER_SOFTWARE'],
			'php_version'               => phpversion(),
			'php_post_max_size'         => $this->convert_let_to_num( ini_get( 'post_max_size' ) ),
			'php_max_execution_time'    => ini_get( 'max_execution_time' ),
			'php_max_input_vars'        => ini_get( 'max_input_vars' ),
			'curl_version'              => $curl_version,
			'suhosin_installed'         => extension_loaded( 'suhosin' ),
			'max_upload_size'           => wp_max_upload_size(),
			'mysql_version'             => ( ! empty( $wpdb->is_mysql ) ? $wpdb->db_version() : '' ),
			'default_timezone'          => date_default_timezone_get(),
			'fsockopen_or_curl_enabled' => ( function_exists( 'fsockopen' ) || function_exists( 'curl_init' ) ),
			'soapclient_enabled'        => class_exists( 'SoapClient' ),
			'domdocument_enabled'       => class_exists( 'DOMDocument' ),
			'gzip_enabled'              => is_callable( 'gzopen' ),
			'mbstring_enabled'          => extension_loaded( 'mbstring' ),
		);
	}

	/**
	 * Get info on the current active theme, info on parent theme (if presnet)
	 * and a list of template overrides.
	 *
	 * @return array
	 */
	public function get_theme_info() {
		$active_theme = wp_get_theme();

		// Get parent theme info if this theme is a child theme, otherwise
		// pass empty info in the response.
		if ( is_child_theme() ) {
			$parent_theme      = wp_get_theme( $active_theme->Template );
			$parent_theme_info = array(
				'parent_name'           => $parent_theme->Name,
				'parent_version'        => $parent_theme->Version,
				'parent_author_url'     => $parent_theme->{'Author URI'},
			);
		} else {
			$parent_theme_info = array( 'parent_name' => '', 'parent_version' => '', 'parent_author_url' => '' );
		}

		$active_theme_info = array(
			'name'                    => $active_theme->Name,
			'version'                 => $active_theme->Version,
			'author_url'              => esc_url_raw( $active_theme->{'Author URI'} ),
			'is_child_theme'          => is_child_theme(),
			'has_woocommerce_support' => ( current_theme_supports( 'woocommerce' ) || in_array( $active_theme->template, wc_get_core_supported_themes() ) ),
			'has_woocommerce_file'    => ( file_exists( get_stylesheet_directory() . '/woocommerce.php' ) || file_exists( get_template_directory() . '/woocommerce.php' ) ),
		);

		return array_merge( $active_theme_info, $parent_theme_info );
	}


	/**
	 * Get a list of plugins active on the site.
	 *
	 * @return array
	 */
	public function get_active_plugins() {
		require_once( ABSPATH . 'wp-admin/includes/plugin.php' );
		require_once( ABSPATH . 'wp-admin/includes/update.php' );

		if ( ! function_exists( 'get_plugin_updates' ) ) {
			return array();
		}

		// Get both site plugins and network plugins
		$active_plugins = (array) get_option( 'active_plugins', array() );
		if ( is_multisite() ) {
			$network_activated_plugins = array_keys( get_site_option( 'active_sitewide_plugins', array() ) );
			$active_plugins            = array_merge( $active_plugins, $network_activated_plugins );
		}

		$active_plugins_data = array();
		$available_updates   = get_plugin_updates();

		foreach ( $active_plugins as $plugin ) {
			$data           = get_plugin_data( WP_PLUGIN_DIR . '/' . $plugin );
			$dirname        = dirname( $plugin );
			$version_latest = '';
			$slug           = explode( '/', $plugin );
			$slug           = explode( '.', end( $slug ) );
			$slug           = $slug[0];

			if ( 'woocommerce' !== $slug && ( strstr( $data['PluginURI'], 'woothemes.com' ) || strstr( $data['PluginURI'], 'woocommerce.com' ) ) ) {
				if ( false === ( $version_data = get_transient( md5( $plugin ) . '_version_data' ) ) ) {
					$changelog = wp_safe_remote_get( 'http://dzv365zjfbd8v.cloudfront.net/changelogs/' . $dirname . '/changelog.txt' );
					$cl_lines  = explode( "\n", wp_remote_retrieve_body( $changelog ) );
					if ( ! empty( $cl_lines ) ) {
						foreach ( $cl_lines as $line_num => $cl_line ) {
							if ( preg_match( '/^[0-9]/', $cl_line ) ) {
								$date         = str_replace( '.' , '-' , trim( substr( $cl_line , 0 , strpos( $cl_line , '-' ) ) ) );
								$version      = preg_replace( '~[^0-9,.]~' , '' ,stristr( $cl_line , "version" ) );
								$update       = trim( str_replace( "*" , "" , $cl_lines[ $line_num + 1 ] ) );
								$version_data = array( 'date' => $date , 'version' => $version , 'update' => $update , 'changelog' => $changelog );
								set_transient( md5( $plugin ) . '_version_data', $version_data, DAY_IN_SECONDS );
								break;
							}
						}
					}
				}
				$version_latest = $version_data['version'];
			} elseif ( isset( $available_updates[ $plugin ]->update->new_version ) ) {
				$version_latest = $available_updates[ $plugin ]->update->new_version;
			}

			// convert plugin data to json response format.
			$active_plugins_data[] = array(
				'plugin'            => $plugin,
				'name'              => $data['Name'],
				'version'           => $data['Version'],
				'version_latest'    => $version_latest,
				'url'               => $data['PluginURI'],
				'author_name'       => $data['AuthorName'],
				'author_url'        => esc_url_raw( $data['AuthorURI'] ),
				'network_activated' => $data['Network'],
			);
		}

		return $active_plugins_data;
	}
}
$system_status  = new Shadhin_plugins_Get_System_Status;
$environment    = $system_status->get_environment_info();
$active_plugins    = $system_status->get_active_plugins();
$theme    = $system_status->get_theme_info();
?>


	<table class="mascot-status-table widefat" cellspacing="0">
		<thead>
			<tr>
				<th colspan="2" data-export-label="Theme"><?php esc_html_e( 'Theme', 'shadhin-plugins' ); ?></th>
			</tr>
		</thead>
		<tbody>
			<tr>
				<td data-export-label="Name"><?php esc_html_e( 'Name', 'shadhin-plugins' ); ?>:</td>
				<td><?php echo esc_html( $theme['name'] ) ?></td>
			</tr>
			<tr>
				<td data-export-label="Version"><?php esc_html_e( 'Version', 'shadhin-plugins' ); ?>:</td>
				<td><?php
					echo esc_html( $theme['version'] );
				?></td>
			</tr>
			<tr>
				<td data-export-label="Author URL"><?php esc_html_e( 'Author URL', 'shadhin-plugins' ); ?>:</td>
				<td><?php echo esc_html( $theme['author_url'] ) ?></td>
			</tr>
			<tr>
				<td data-export-label="Child Theme"><?php esc_html_e( 'Child theme', 'shadhin-plugins' ); ?>:</td>
				<td><?php
					echo wp_kses_post( $theme['is_child_theme'] ? '<mark class="yes"><span class="dashicons dashicons-yes"></span></mark>' : '<span class="dashicons dashicons-no-alt"></span> &ndash; ' );
				?></td>
			</tr>
			<?php
			if ( $theme['is_child_theme'] ) :
			?>
			<tr>
				<td data-export-label="Parent Theme Name"><?php esc_html_e( 'Parent theme name', 'shadhin-plugins' ); ?>:</td>
				<td><?php echo esc_html( $theme['parent_name'] ); ?></td>
			</tr>
			<tr>
				<td data-export-label="Parent Theme Version"><?php esc_html_e( 'Parent theme version', 'shadhin-plugins' ); ?>:</td>
				<td><?php
					echo esc_html( $theme['parent_version'] );
				?></td>
			</tr>
			<tr>
				<td data-export-label="Parent Theme Author URL"><?php esc_html_e( 'Parent theme author URL', 'shadhin-plugins' ); ?>:</td>
				<td><?php echo esc_html( $theme['parent_author_url'] ) ?></td>
			</tr>
			<?php endif ?>
			<tr>
				<td data-export-label="WooCommerce Support"><?php esc_html_e( 'WooCommerce support', 'shadhin-plugins' ); ?>:</td>
				<td>
					<?php if ( ! $theme['has_woocommerce_support'] ) {
						echo '<mark class="error"><span class="dashicons dashicons-warning"></span> ' . esc_html__( 'Not declared', 'shadhin-plugins' ) . '</mark>';
					} else {
						echo '<mark class="yes"><span class="dashicons dashicons-yes"></span></mark>';
					} ?>
				</td>
			</tr>
		</tbody>
	</table>

	<table class="mascot-status-table widefat" cellspacing="0" id="status">
		<thead>
			<tr>
				<th colspan="2" data-export-label="WordPress Environment"><?php esc_html_e( 'WordPress environment', 'shadhin-plugins' ); ?></th>
			</tr>
		</thead>
		<tbody>
			<tr>
				<td data-export-label="Home URL"><?php esc_html_e( 'Home URL', 'shadhin-plugins' ); ?>:</td>
				<td><?php echo esc_html( $environment['home_url'] ) ?></td>
			</tr>
			<tr>
				<td data-export-label="Site URL"><?php esc_html_e( 'Site URL', 'shadhin-plugins' ); ?>:</td>
				<td><?php echo esc_html( $environment['site_url'] ) ?></td>
			</tr>
			<tr>
				<td data-export-label="WP Version"><?php esc_html_e( 'WP version', 'shadhin-plugins' ); ?>:</td>
				<td><?php echo esc_html( $environment['wp_version'] ) ?></td>
			</tr>
			<tr>
				<td data-export-label="WP Multisite"><?php esc_html_e( 'WP multisite', 'shadhin-plugins' ); ?>:</td>
				<td><?php echo ( $environment['wp_multisite'] ) ? '<span class="dashicons dashicons-yes"></span>' : '&ndash;'; ?></td>
			</tr>
			<tr>
				<td data-export-label="WP Memory Limit"><?php esc_html_e( 'WP memory limit', 'shadhin-plugins' ); ?>:</td>
				<td><?php
					if ( $environment['wp_memory_limit'] < 67108864 ) {
						echo wp_kses_post( '<mark class="error"><span class="dashicons dashicons-warning"></span> ' . sprintf( esc_html__( '%1$s - We recommend setting memory to at least 64MB. See: %2$s', 'shadhin-plugins' ), esc_html( size_format( $environment['wp_memory_limit'] ) ), '<a href="https://codex.wordpress.org/Editing_wp-config.php#Increasing_memory_allocated_to_PHP" target="_blank">' . esc_html__( 'Increasing memory allocated to PHP', 'shadhin-plugins' ) . '</a>' ) . '</mark>' );
					} else {
						echo '<mark class="yes">' . esc_html( size_format( $environment['wp_memory_limit'] ) ) . '</mark>';
					}
				?></td>
			</tr>
			<tr>
				<td data-export-label="WP Debug Mode"><?php esc_html_e( 'WP debug mode', 'shadhin-plugins' ); ?>:</td>
				<td>
					<?php if ( $environment['wp_debug_mode'] ) : ?>
						<mark class="yes"><span class="dashicons dashicons-yes"></span></mark>
					<?php else : ?>
						<mark class="no">&ndash;</mark>
					<?php endif; ?>
				</td>
			</tr>
			<tr>
				<td data-export-label="WP Cron"><?php esc_html_e( 'WP cron', 'shadhin-plugins' ); ?>:</td>
				<td>
					<?php if ( $environment['wp_cron'] ) : ?>
						<mark class="yes"><span class="dashicons dashicons-yes"></span></mark>
					<?php else : ?>
						<mark class="no">&ndash;</mark>
					<?php endif; ?>
				</td>
			</tr>
			<tr>
				<td data-export-label="Language"><?php esc_html_e( 'Language', 'shadhin-plugins' ); ?>:</td>
				<td><?php echo esc_html( $environment['language'] ) ?></td>
			</tr>
		</tbody>
	</table>

	<table class="mascot-status-table widefat" cellspacing="0">
		<thead>
			<tr>
				<th colspan="2" data-export-label="Server Environment"><?php esc_html_e( 'Server environment', 'shadhin-plugins' ); ?></th>
			</tr>
		</thead>
		<tbody>
			<tr>
				<td data-export-label="Server Info"><?php esc_html_e( 'Server info', 'shadhin-plugins' ); ?>:</td>
				<td><?php echo esc_html( $environment['server_info'] ); ?></td>
			</tr>
			<tr>
				<td data-export-label="PHP Version"><?php esc_html_e( 'PHP version', 'shadhin-plugins' ); ?>:</td>
				<td><?php
					if ( version_compare( $environment['php_version'], '5.6', '<' ) ) {
						echo wp_kses_post( '<mark class="error"><span class="dashicons dashicons-warning"></span> ' . sprintf( esc_html__( '%1$s - We recommend a minimum PHP version of 5.6. See: %2$s', 'shadhin-plugins' ), esc_html( $environment['php_version'] ), '<a href="https://docs.woocommerce.com/document/how-to-update-your-php-version/" target="_blank">' . esc_html__( 'How to update your PHP version', 'shadhin-plugins' ) . '</a>' ) . '</mark>' );
					} else {
						echo '<mark class="yes">' . esc_html( $environment['php_version'] ) . '</mark>';
					}
					?></td>
			</tr>
			<?php if ( function_exists( 'ini_get' ) ) : ?>
				<tr>
					<td data-export-label="PHP Post Max Size"><?php esc_html_e( 'PHP post max size', 'shadhin-plugins' ); ?>:</td>
					<td><?php echo esc_html( size_format( $environment['php_post_max_size'] ) ) ?></td>
				</tr>
				<tr>
					<td data-export-label="PHP Time Limit"><?php esc_html_e( 'PHP time limit', 'shadhin-plugins' ); ?>:</td>
					<td><?php echo esc_html( $environment['php_max_execution_time'] ) ?></td>
				</tr>
				<tr>
					<td data-export-label="PHP Max Input Vars"><?php esc_html_e( 'PHP max input vars', 'shadhin-plugins' ); ?>:</td>
					<td><?php echo esc_html( $environment['php_max_input_vars'] ) ?></td>
				</tr>
				<tr>
					<td data-export-label="cURL Version"><?php esc_html_e( 'cURL version', 'shadhin-plugins' ); ?>:</td>
					<td><?php echo esc_html( $environment['curl_version'] ) ?></td>
				</tr>
				<tr>
					<td data-export-label="SUHOSIN Installed"><?php esc_html_e( 'SUHOSIN installed', 'shadhin-plugins' ); ?>:</td>
					<td><?php echo wp_kses_post( $environment['suhosin_installed'] ? '<span class="dashicons dashicons-yes"></span>' : '&ndash;' ); ?></td>
				</tr>
			<?php endif; ?>
			<tr>
				<td data-export-label="Max Upload Size"><?php esc_html_e( 'Max upload size', 'shadhin-plugins' ); ?>:</td>
				<td><?php echo size_format( $environment['max_upload_size'] ) ?></td>
			</tr>
			<tr>
				<td data-export-label="Default Timezone is UTC"><?php esc_html_e( 'Default timezone is UTC', 'shadhin-plugins' ); ?>:</td>
				<td><?php
					if ( 'UTC' !== $environment['default_timezone'] ) {
						echo wp_kses_post( '<mark class="error"><span class="dashicons dashicons-warning"></span> ' . sprintf( esc_html__( 'Default timezone is %s - it should be UTC', 'shadhin-plugins' ), esc_html( $environment['default_timezone'] ) ) . '</mark>' );
					} else {
						echo '<mark class="yes"><span class="dashicons dashicons-yes"></span></mark>';
					} ?>
				</td>
			</tr>
			<tr>
				<td data-export-label="fsockopen/cURL"><?php esc_html_e( 'fsockopen/cURL', 'shadhin-plugins' ); ?>:</td>
				<td><?php
					if ( $environment['fsockopen_or_curl_enabled'] ) {
						echo '<mark class="yes"><span class="dashicons dashicons-yes"></span></mark>';
					} else {
						echo '<mark class="error"><span class="dashicons dashicons-warning"></span> ' . esc_html__( 'Your server does not have fsockopen or cURL enabled - PayPal IPN and other scripts which communicate with other servers will not work. Contact your hosting provider.', 'shadhin-plugins' ) . '</mark>';
					} ?>
				</td>
			</tr>
			<tr>
				<td data-export-label="SoapClient"><?php esc_html_e( 'SoapClient', 'shadhin-plugins' ); ?>:</td>
				<td><?php
					if ( $environment['soapclient_enabled'] ) {
						echo '<mark class="yes"><span class="dashicons dashicons-yes"></span></mark>';
					} else {
						echo wp_kses_post( '<mark class="error"><span class="dashicons dashicons-warning"></span> ' . sprintf( esc_html__( 'Your server does not have the %s class enabled - some gateway plugins which use SOAP may not work as expected.', 'shadhin-plugins' ), '<a href="https://php.net/manual/en/class.soapclient.php">SoapClient</a>' ) . '</mark>' );
					} ?>
				</td>
			</tr>
			<tr>
				<td data-export-label="DOMDocument"><?php esc_html_e( 'DOMDocument', 'shadhin-plugins' ); ?>:</td>
				<td><?php
					if ( $environment['domdocument_enabled'] ) {
						echo '<mark class="yes"><span class="dashicons dashicons-yes"></span></mark>';
					} else {
						echo wp_kses_post( '<mark class="error"><span class="dashicons dashicons-warning"></span> ' . sprintf( esc_html__( 'Your server does not have the %s class enabled - HTML/Multipart emails, and also some extensions, will not work without DOMDocument.', 'shadhin-plugins' ), '<a href="https://php.net/manual/en/class.domdocument.php">DOMDocument</a>' ) . '</mark>' );
					} ?>
				</td>
			</tr>
			<tr>
				<td data-export-label="GZip"><?php esc_html_e( 'GZip', 'shadhin-plugins' ); ?>:</td>
				<td><?php
					if ( $environment['gzip_enabled'] ) {
						echo '<mark class="yes"><span class="dashicons dashicons-yes"></span></mark>';
					} else {
						echo wp_kses_post( '<mark class="error"><span class="dashicons dashicons-warning"></span> ' . sprintf( esc_html__( 'Your server does not support the %s function - this is required to use the GeoIP database from MaxMind.', 'shadhin-plugins' ), '<a href="https://php.net/manual/en/zlib.installation.php">gzopen</a>' ) . '</mark>' );
					} ?>
				</td>
			</tr>
			<tr>
				<td data-export-label="Multibyte String"><?php esc_html_e( 'Multibyte string', 'shadhin-plugins' ); ?>:</td>
				<td><?php
					if ( $environment['mbstring_enabled'] ) {
						echo '<mark class="yes"><span class="dashicons dashicons-yes"></span></mark>';
					} else {
						echo wp_kses_post( '<mark class="error"><span class="dashicons dashicons-warning"></span> ' . sprintf( esc_html__( 'Your server does not support the %s functions - this is required for better character encoding. Some fallbacks will be used instead for it.', 'shadhin-plugins' ), '<a href="https://php.net/manual/en/mbstring.installation.php">mbstring</a>' ) . '</mark>' );
					} ?>
				</td>
			</tr>
		</tbody>
	</table>

	<table class="mascot-status-table widefat" cellspacing="0">
		<thead>
			<tr>
				<th colspan="2" data-export-label="Active Plugins (<?php echo count( $active_plugins ) ?>)"><?php esc_html_e( 'Active plugins', 'shadhin-plugins' ); ?> (<?php echo count( $active_plugins ) ?>)</th>
			</tr>
		</thead>
		<tbody>
			<?php
			foreach ( $active_plugins as $plugin ) {
				if ( ! empty( $plugin['name'] ) ) {
					$dirname = dirname( $plugin['plugin'] );

					// Link the plugin name to the plugin url if available.
					$plugin_name = esc_html( $plugin['name'] );
					if ( ! empty( $plugin['url'] ) ) {
						$plugin_name = '<a href="' . esc_url( $plugin['url'] ) . '" aria-label="' . esc_attr__( 'Visit plugin homepage' , 'shadhin-plugins' ) . '" target="_blank">' . $plugin_name . '</a>';
					}

					$version_string = '';
					$network_string = '';
					if ( strstr( $plugin['url'], 'woothemes.com' ) || strstr( $plugin['url'], 'woocommerce.com' ) ) {
						if ( ! empty( $plugin['version_latest'] ) && version_compare( $plugin['version_latest'], $plugin['version'], '>' ) ) {
							/* translators: %s: plugin latest version */
							$version_string = ' &ndash; <strong style="color:red;">' . sprintf( esc_html__( '%s is available', 'shadhin-plugins' ), esc_html( $plugin['version_latest'] ) ) . '</strong>';
						}

						if ( false != $plugin['network_activated'] ) {
							$network_string = ' &ndash; <strong style="color:black;">' . esc_html__( 'Network enabled', 'shadhin-plugins' ) . '</strong>';
						}
					}
					?>
					<tr>
						<td><?php echo wp_kses_post( $plugin_name ); ?></td>
						<td><?php
							/* translators: %s: plugin author */
							printf( esc_html__( 'by %s', 'shadhin-plugins' ), esc_html( $plugin['author_name'] ) );
							echo ' &ndash; ' . esc_html( $plugin['version'] ) . $version_string . $network_string;
						?></td>
					</tr>
					<?php
				}
			}
			?>
		</tbody>
	</table>
