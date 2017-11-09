<?php // Blackhole for Bad Bots - Uninstall Remove Options

if (!defined('ABSPATH') && !defined('WP_UNINSTALL_PLUGIN')) exit();

delete_option('bbb_options');
delete_option('bbb_badbots');
