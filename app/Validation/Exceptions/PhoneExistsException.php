<?php namespace App\Validation\Exceptions ;


	use Respect\Validation\Exceptions\ValidationException ;

	/**
	 *  PhoneExistsException
	 */
	class PhoneExistsException extends ValidationException
	{
		
		public static $defaultTemplates = [

			self::MODE_DEFAULT 			=> [

				self::STANDARD 			=> 'Phone number already taken',

			] 

		] ;

	}