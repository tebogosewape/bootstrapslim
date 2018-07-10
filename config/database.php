<?php

	return [
		
			'db'					=> [

				'driver'			=> getenv( 'DB_DRIVER' ),
				'host'				=> getenv( 'DB_HOST' ),
				'database'			=> getenv( 'DB_NAME' ),
				'username'			=> getenv( 'DB_USER' ),
				'password'			=> getenv( 'DB_PASSWORD' ),
				'charset'			=> 'utf8',
				'collation'			=> 'utf8_unicode_ci',
				'prefix' 			=> '',

			],

	] ;