<?php namespace App\Validation\Rules ;

	use Respect\Validation\Rules\AbstractRule ;

	/**
	 *  PhoneExists
	 */
	class PhoneExists extends AbstractRule
	{
		
		public function validate( $input )
		{

			return \App\Models\User::where( 'phone_number', $input )->count() === 0 ;

		}

	}