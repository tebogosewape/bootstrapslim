<?php

	return [
		
		'host' 				=> getenv( 'EMAIL_HOST' ),
		'debug' 			=> getenv( 'EMAIL_DEBUG' ),
		'port' 				=> getenv( 'EMAIL_PORT' ),
		'secure' 			=> getenv( 'EMAIL_SECURE' ),
		'auth' 				=> getenv( 'EMAIL_AUTH' ),
		'username' 			=> getenv( 'EMAIL_USER' ),
		'password' 			=> getenv( 'EMAIL_PASSWORD' ),

	] ;