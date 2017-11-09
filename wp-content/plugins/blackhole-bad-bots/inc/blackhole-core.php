<?php // Blackhole for Bad Bots - Blackhole Core

if (!defined('ABSPATH')) exit;

function blackhole_trigger() {
	
	$nonce = wp_create_nonce('blackhole_trigger');
	$href  = site_url('/?blackhole='. $nonce);
	$title = esc_attr__('Blackhole for Bad Bots', 'blackhole-bad-bots');
	$text  = esc_html__('Do NOT follow this link or you will be banned from the site!', 'blackhole-bad-bots');
	$link  = '<a rel="nofollow" style="display:none;" href="'. $href .'" title="'. $title .'">'. $text .'</a>' . "\n";
	
	echo apply_filters('blackhole_trigger', $link, $text, $title, $href, $nonce);
	
}

function blackhole_whitelist() {
	
	global $bbb_options;
	
	$vars = blackhole_get_vars();
	
	list ($ip_address, $request_uri, $query_string, $user_agent, $referrer, $protocol, $method) = $vars;
	
	// bots
	
	$whitelist_bots = isset($bbb_options['bot_whitelist']) ? $bbb_options['bot_whitelist'] : '';
	$whitelist_bots = array_filter(array_map('trim', explode(',', $whitelist_bots)));
	$whitelist_bots = implode('|', $whitelist_bots);
	
	if (!empty($whitelist_bots) && preg_match("/(".  $whitelist_bots .")/i",  $user_agent, $matches)) {
		
		return true;
	
	}
	
	// ips
	
	$whitelist_ips = isset($bbb_options['ip_whitelist']) ? $bbb_options['ip_whitelist'] : '';
	$whitelist_ips = array_filter(array_map('trim', explode(',', $whitelist_ips)));
	
	foreach ($whitelist_ips as $ip) {
		
		if (strpos($ip, '/') === false) {
			
			if (substr($ip_address, 0, strlen($ip)) === $ip) {
				
				return true;
				
			}
			
		} else {
			
			if (blackhole_ip_in_range($ip_address, $ip)) {
				
				return true;
				
			}
			
		}
		
	}
	
	return false;
	
}

function blackhole_ip_in_range($ip, $range) {

	list($range, $netmask) = explode('/', $range, 2);
	
	$range_decimal = ip2long($range);
	
	$ip_decimal = ip2long($ip);
	
	$wildcard_decimal = pow(2, (32 - $netmask)) - 1;
	
	$netmask_decimal = ~ $wildcard_decimal;
	
	return (($ip_decimal & $netmask_decimal) == ($range_decimal & $netmask_decimal));
	
}

function blackhole_get_vars() {
	
	$ip_address = blackhole_get_ip();
	
	$request_uri  = isset($_SERVER['REQUEST_URI'])     ? sanitize_text_field($_SERVER['REQUEST_URI'])     : '';
	$query_string = isset($_SERVER['QUERY_STRING'])    ? sanitize_text_field($_SERVER['QUERY_STRING'])    : '';
	$user_agent   = isset($_SERVER['HTTP_USER_AGENT']) ? sanitize_text_field($_SERVER['HTTP_USER_AGENT']) : '';
	$referrer     = isset($_SERVER['HTTP_REFERER'])    ? sanitize_text_field($_SERVER['HTTP_REFERER'])    : '';
	$protocol     = isset($_SERVER['SERVER_PROTOCOL']) ? sanitize_text_field($_SERVER['SERVER_PROTOCOL']) : '';
	$method       = isset($_SERVER['REQUEST_METHOD'])  ? sanitize_text_field($_SERVER['REQUEST_METHOD'])  : '';
	
	$date  = date('Y/m/d @ h:i:s a', current_time('timestamp'));
	
	$vars = array($ip_address, $request_uri, $query_string, $user_agent, $referrer, $protocol, $method, $date);
	
	return apply_filters('blackhole_vars', $vars);
	
}

function blackhole_get_ip() {
	
	$ip = blackhole_evaluate_ip();
	
	if (preg_match('/(\d{1,3}\.\d{1,3}\.\d{1,3}\.\d{1,3})/', $ip, $ip_match)) {
		
		$ip = $ip_match[1];
		
	}
	
	return sanitize_text_field($ip);
	
}

function blackhole_evaluate_ip() {
	 
	$ip_keys = array('HTTP_CF_CONNECTING_IP', 'HTTP_CLIENT_IP', 'HTTP_X_FORWARDED_FOR', 'HTTP_X_FORWARDED', 'HTTP_X_CLUSTER_CLIENT_IP', 'HTTP_X_REAL_IP', 'HTTP_X_COMING_FROM', 'HTTP_PROXY_CONNECTION', 'HTTP_FORWARDED_FOR', 'HTTP_FORWARDED', 'HTTP_COMING_FROM', 'HTTP_VIA', 'REMOTE_ADDR');
	
	$ip_keys = apply_filters('blackhole_ip_keys', $ip_keys);
	
	foreach ($ip_keys as $key) {
		
		if (array_key_exists($key, $_SERVER) === true) {
			
			foreach (explode(',', $_SERVER[$key]) as $ip) {
				
				$ip = trim($ip);
				
				$ip = blackhole_normalize_ip($ip);
				
				if (blackhole_validate_ip($ip)) {
					
					return $ip;
					
				}
				
			}
			
		}
		
	}
	
	return esc_html__('Error: Invalid Address', 'blackhole-bad-bots');
	
}

function blackhole_normalize_ip($ip) {
	
	if (strpos($ip, ':') !== false && substr_count($ip, '.') == 3 && strpos($ip, '[') === false) {
		
		// IPv4 with port (e.g., 123.123.123:80)
		$ip = explode(':', $ip);
		$ip = $ip[0];
		
	} else {
		
		// IPv6 with port (e.g., [::1]:80)
		$ip = explode(']', $ip);
		$ip = ltrim($ip[0], '[');
		
	}
	
	return $ip;
	
}
	
function blackhole_validate_ip($ip) {
	
	$options  = FILTER_FLAG_IPV4 | FILTER_FLAG_IPV6 | FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE;
	
	$options  = apply_filters('blackhole_ip_filter', $options);
	
	$filtered = filter_var($ip, FILTER_VALIDATE_IP, $options);
	
	 if (!$filtered || empty($filtered)) {
		
		
		if (preg_match("/^(([1-9]?[0-9]|1[0-9]{2}|2[0-4][0-9]|25[0-5]).){3}([1-9]?[0-9]|1[0-9]{2}|2[0-4][0-9]|25[0-5])$/", $ip)) {
			
			return $ip; // IPv4
			
		} elseif (preg_match("/^\s*((([0-9A-Fa-f]{1,4}:){7}([0-9A-Fa-f]{1,4}|:))|(([0-9A-Fa-f]{1,4}:){6}(:[0-9A-Fa-f]{1,4}|((25[0-5]|2[0-4]\d|1\d\d|[1-9]?\d)(\.(25[0-5]|2[0-4]\d|1\d\d|[1-9]?\d)){3})|:))|(([0-9A-Fa-f]{1,4}:){5}(((:[0-9A-Fa-f]{1,4}){1,2})|:((25[0-5]|2[0-4]\d|1\d\d|[1-9]?\d)(\.(25[0-5]|2[0-4]\d|1\d\d|[1-9]?\d)){3})|:))|(([0-9A-Fa-f]{1,4}:){4}(((:[0-9A-Fa-f]{1,4}){1,3})|((:[0-9A-Fa-f]{1,4})?:((25[0-5]|2[0-4]\d|1\d\d|[1-9]?\d)(\.(25[0-5]|2[0-4]\d|1\d\d|[1-9]?\d)){3}))|:))|(([0-9A-Fa-f]{1,4}:){3}(((:[0-9A-Fa-f]{1,4}){1,4})|((:[0-9A-Fa-f]{1,4}){0,2}:((25[0-5]|2[0-4]\d|1\d\d|[1-9]?\d)(\.(25[0-5]|2[0-4]\d|1\d\d|[1-9]?\d)){3}))|:))|(([0-9A-Fa-f]{1,4}:){2}(((:[0-9A-Fa-f]{1,4}){1,5})|((:[0-9A-Fa-f]{1,4}){0,3}:((25[0-5]|2[0-4]\d|1\d\d|[1-9]?\d)(\.(25[0-5]|2[0-4]\d|1\d\d|[1-9]?\d)){3}))|:))|(([0-9A-Fa-f]{1,4}:){1}(((:[0-9A-Fa-f]{1,4}){1,6})|((:[0-9A-Fa-f]{1,4}){0,4}:((25[0-5]|2[0-4]\d|1\d\d|[1-9]?\d)(\.(25[0-5]|2[0-4]\d|1\d\d|[1-9]?\d)){3}))|:))|(:(((:[0-9A-Fa-f]{1,4}){1,7})|((:[0-9A-Fa-f]{1,4}){0,5}:((25[0-5]|2[0-4]\d|1\d\d|[1-9]?\d)(\.(25[0-5]|2[0-4]\d|1\d\d|[1-9]?\d)){3}))|:)))(%.+)?\s*$/", $ip)) { 
			
			return $ip; // IPv6
			
		}
		
		error_log('Invalid IP Address: '. $ip);
		
		return false;
		
	}
	
	return $filtered;
	
}

function blackhole_send_email($whois) {
	
	global $bbb_options;
	
	if (isset($bbb_options['email_alerts']) && !$bbb_options['email_alerts']) return false;
	
	$vars = blackhole_get_vars();
	
	list ($ip_address, $request_uri, $query_string, $user_agent, $referrer, $protocol, $method, $date) = $vars;
	
	require_once 'blackhole-lookup.php';
	
	$whois = htmlspecialchars_decode($whois, ENT_QUOTES);
	
	$name  = apply_filters('blackhole_alert_name', get_option('blogname'));
	
	$email = isset($bbb_options['email_address']) ? $bbb_options['email_address'] : get_option('admin_email');
	
	$from = (isset($bbb_options['email_from']) && !empty($bbb_options['email_from'])) ? $bbb_options['email_from'] : $email;

	$subject = apply_filters('blackhole_alert_subject', __('Bad Bot Alert at ', 'blackhole-bad-bots') . $name);
	
	$message   = $date . "\n\n";
	$message  .= __('Request URI: ',  'blackhole-bad-bots') . $request_uri    . "\n";
	$message  .= __('IP Address: ',   'blackhole-bad-bots') . $ip_address     . "\n";
	$message  .= __('User Agent: ',   'blackhole-bad-bots') . $user_agent     . "\n\n";
	$message  .= __('Whois Lookup: ', 'blackhole-bad-bots') . "\n\n" . $whois . "\n\n";
	
	$message = apply_filters('blackhole_alert_message', $message, $vars);
	
	$headers  = 'X-Mailer: Blackhole for Bad Bots'. "\n";
	$headers .= 'From: '. $name .' <'. $from .'>'. "\n";
	$headers .= 'Content-Type: text/plain; charset='. get_option('blog_charset', 'UTF-8') . "\n";
	
	$headers = apply_filters('blackhole_alert_headers', $headers, $vars);
	
	$alert = wp_mail($email, $subject, $message, $headers);
	
	return $alert;
		
}

function blackhole_log_bot() {
	
	global $bbb_badbots;
	
	$bbb_badbots = (array) $bbb_badbots;
	
	if (blackhole_check_log()) return false;
	
	$vars = blackhole_get_vars();
	
	list ($ip_address, $request_uri, $query_string, $user_agent, $referrer, $protocol, $method, $date) = $vars;
	
	$log = array(
		array(
			'ip_address'   => $ip_address,
			'request_uri'  => $request_uri,
			'query_string' => $query_string,
			'user_agent'   => $user_agent,
			'referrer'     => $referrer,
			'protocol'     => $protocol,
			'method'       => $method,
			'date'         => $date,
		)
	);
	
	$log = apply_filters('blackhole_log', $log, $vars);
	
	$bbb_badbots = array_merge($bbb_badbots, $log);
	
	$update = update_option('bbb_badbots', $bbb_badbots, true);
	
	return $update;
	
}

function blackhole_check_log() {
	
	global $bbb_badbots;
	
	$bbb_badbots = (array) $bbb_badbots;
	
	$vars = blackhole_get_vars();
	
	list ($ip_address, $request_uri, $query_string, $user_agent, $referrer, $protocol, $method, $date) = $vars;
	
	$needle = apply_filters('blackhole_needle', 'ip_address', $vars, $bbb_badbots);
	
	if (!isset($bbb_badbots) || empty($bbb_badbots)) return false;
	
	if (!isset($needle) || empty($needle)) return false;
	
	foreach ($bbb_badbots as $bot) {
		
		$bot = (array) $bot;
		
		$haystack = isset($bot[$needle]) ? $bot[$needle] : '';
		
		$find = stripos($haystack, ${$needle});
		
		if ($find !== false) return true;
		
	}
	
	return false;
	
}

function blackhole_message_default() {
	
	$message  = '<h1>'. esc_html__('You have been banned from this site.', 'blackhole-bad-bots') .'</h1>';
	$message .= '<p>'. esc_html__('If you think there has been a mistake, please contact the administrator via proxy server.', 'blackhole-bad-bots') .'</p>';
	
	return apply_filters('blackhole_message_default', $message);
	
}

function blackhole_message_custom(){
	
	global $bbb_options;
	
	$message = isset($bbb_options['message_custom']) ? $bbb_options['message_custom'] : blackhole_default_message();
	
	return apply_filters('blackhole_message_custom', $message);
		
}

function blackhole_message_nothing() {
	
	$message = '<style type="text/css">html, body { background-color: black; }</style>';
	
	return apply_filters('blackhole_message_nothing', $message);
	
}

function blackhole_is_login() {
	
	return in_array($GLOBALS['pagenow'], array('wp-login.php', 'wp-register.php'));
	
}

function blackhole_is_tty() {
	
	if (function_exists('posix_isatty')) {
		
		if (defined('STDOUT')) {
			
			if (posix_isatty(STDOUT)) return true;
			
		}
		
	}
	
	return false;
	
}

function blackhole_abort() {
	
	$ignore_loggedin = apply_filters('blackhole_ignore_loggedin', false);
	$ignore_backend  = apply_filters('blackhole_ignore_backend',  true);
	$ignore_login    = apply_filters('blackhole_ignore_login',    true);
	
	if (
		
		($ignore_loggedin && is_user_logged_in()) || 
		($ignore_backend  && is_admin()) || 
		($ignore_login    && blackhole_is_login()) || 
		
		(defined('DOING_CRON') && DOING_CRON) || 
		(blackhole_whitelist()) || 
		(blackhole_is_tty())
		
	) return true;
	
	return false;
	
}

function blackhole_display_message() {
	
	global $bbb_options;
	
	$message_display = isset($bbb_options['message_display']) ? $bbb_options['message_display'] : 'default';
	
	if     ($message_display === 'custom')  $message = blackhole_message_custom();
	elseif ($message_display === 'nothing') $message = blackhole_message_nothing();
	else                                    $message = blackhole_message_default();
	
	$block_status     = apply_filters('blackhole_block_status',     '403');
	$block_protocol   = apply_filters('blackhole_block_protocol',   'HTTP/1.1');
	$block_connection = apply_filters('blackhole_block_connection', 'Connection: Close');
	
	header($block_protocol .' '. $block_status);
	header($block_connection);
	exit($message);
	
}

function blackhole_get_deps() {
	
	require_once 'blackhole-lookup.php';
	
	$default = BBB_DIR .'/inc/blackhole-template.php';
	$custom  = get_stylesheet_directory() .'/blackhole-template.php';
	
	if (file_exists($custom)) require_once $custom;
	else                      require_once $default;
	
}

function blackhole_display_warning() {
	
	blackhole_get_deps();
	
	$vars = blackhole_get_vars();
	
	list ($ip_address, $request_uri, $query_string, $user_agent, $referrer, $protocol, $method, $date) = $vars;
	
	$whois = blackhole_whois($ip_address);
	
	blackhole_template($ip_address, $date, $whois, $vars);
	
	if (blackhole_log_bot()) blackhole_send_email($whois);
	
	exit;
	
}

function blackhole_scanner() {
	
	if (blackhole_abort()) return false;
	
	if (isset($_GET['blackhole']) && wp_verify_nonce($_GET['blackhole'], 'blackhole_trigger')) {
		
		if (blackhole_check_log()) {
			
			blackhole_display_message();
			
		} else {
			
			blackhole_display_warning();
			
		}
		
	} else {
		
		if (blackhole_check_log()) {
			
			blackhole_display_message();
			
		}
		
	}
	
	return false;
	
}
