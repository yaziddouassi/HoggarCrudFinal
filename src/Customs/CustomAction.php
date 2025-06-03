<?php
namespace Hoggarcrud\Hoggar\Customs;

class CustomAction
{
    protected string $field;
    protected string $urlValidation;
     
    
    public static function make(string $field): self
    {
        $instance = new self();
        $instance->field = $field;
        return $instance;
    }

    public function url($a)
    {
       $this->urlValidation = $a ;
       return $this ;
    }

    
    public function registerTo($generator): void
    {
        $generator->customs[$this->field] =  $this->urlValidation;
       
       
    }

    


    


}