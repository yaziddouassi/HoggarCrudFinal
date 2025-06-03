<?php
namespace Hoggarcrud\Hoggar\Filters;

class FilterText
{
    protected string $field;
    protected string $label;
    protected string $type = 'Text';
    
    public static function make(string $field): self
    {
        $instance = new self();
        $instance->field = $field;
        return $instance;
    }

    
    public function registerTo($generator): void
    {
  
        $b = [] ;
        $b['field'] = $this->field ;

        $generator->tabFilterFields[$this->field] =  $this->field;
        $generator->tabFilterLabels[$this->field] = $this->field;
        $generator->tabFilterTypes[$this->field] = $this->type;
        $generator->tabFilterOptions[$this->field] = $b;
    }

    


    


}