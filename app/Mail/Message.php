<?php namespace App\Mail;

    class Message {

        protected $mailer;
        
        public function __construct( $mailer ) {

            $this->mailer                   = $mailer;

        }
        
        public function to( $address ) {
            $this->mailer->addAddress( $address ) ;   
        }

        public function subject( $subject ) {

            $this->mailer->Subject          = $subject ;

        }

        public function body( $body ) {

            $this->mailer->Body             = $body ;

        }

        // if you want to add different sender email in mailer call.
        public function from( $from ) {

            $this->mailer->From             = $from ;

        }

        // if you want to add different sender name in mailer call.
        //
        public function fromName( $fromName ) {

            $this->mailer->FromName         = $fromName ;

        }

    }