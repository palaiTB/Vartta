<?php

/**
 * HybridAuth
 * http://hybridauth.sourceforge.net | http://github.com/hybridauth/hybridauth
 * (c) 2009-2015, HybridAuth authors | http://hybridauth.sourceforge.net/licenses.html
 */
// ----------------------------------------------------------------------------------------
//	HybridAuth Config file: http://hybridauth.sourceforge.net/userguide/Configuration.html
// ----------------------------------------------------------------------------------------

return
		array(
			"base_url" => "https://www.batoisandbox.com/od2/osf/lib/hybridauth/",
			"providers" => array(
				// openid providers
				"OpenID" => array(
					"enabled" => true
				),
				"Yahoo" => array(
					"enabled" => true,
					"keys" => array("key" => "dj0yJmk9cm5MRjRjWjhSaGk1JmQ9WVdrOWQxSmlZa1JsTlRJbWNHbzlNQS0tJnM9Y29uc3VtZXJzZWNyZXQmeD0zYQ--", "secret" => "6055e58fc1148d1dcc1039720b740434d80cb812"),
				),
				"Google" => array(
					"enabled" => true,
					"keys" => array("id" => "698884002182-od12kq574oeq05pdv4nbk9ltrj7i9ofk.apps.googleusercontent.com", "secret" => "53D8UYCnO4GMhQl5_wJnHwu4"),
				),
				"Facebook" => array(
					"enabled" => true,
					"keys" => array("id" => "", "secret" => ""),
					"trustForwarded" => false
				),
				"Twitter" => array(
					"enabled" => true,
					"keys" => array("key" => "CyWKgktWmnWquu5JTnFt68PAO", "secret" => "9oWLhHwjkdz2e26WsSLWkLFUH1T7AaP8SSluOHGGK3Stlbr1oO"),
					"includeEmail" => false
				),
				// windows live
				"Live" => array(
					"enabled" => true,
					"keys" => array("id" => "", "secret" => "")
				),
			),
			// If you want to enable logging, set 'debug_mode' to true.
			// You can also set it to
			// - "error" To log only error messages. Useful in production
			// - "info" To log info and error messages (ignore debug messages)
			"debug_mode" => false,
			// Path to file writable by the web server. Required if 'debug_mode' is not false
			"debug_file" => "",
);
?>