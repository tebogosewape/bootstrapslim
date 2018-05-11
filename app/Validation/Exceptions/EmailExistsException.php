<?php namespace App\Validation\Exceptions ;


	use Respect\Validation\Exceptions\ValidationException ;

	/**
	 *  EmailExistsException
	 */
	class EmailExistsException extends ValidationException
	{
		
		public static $defaultTemplates = [

			self::MODE_DEFAULT 			=> [

				self::STANDARD 			=> 'Email already taken',

			] 

		] ;

	}