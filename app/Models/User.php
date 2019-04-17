<?php namespace App\Models ;

	use Illuminate\Database\Eloquent\Model ;

	/**
	 * 
	 */
	class User extends Model
	{
		
		protected $fillable = [

			'name', 'surname', 'email', 'phone_number', 'password', 'is_active', 'email_token',

		] ;

	    public function jobs() {

	        return $this->hasMany( User::QueueJob ) ;
	        
	    }

	}