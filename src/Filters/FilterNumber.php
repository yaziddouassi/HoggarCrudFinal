<?php
namespace Hoggarcrud\Hoggar\Filters;

class FilterNumber
{
    protected string $field;
    protected string $label;
    protected string $type = 'Number';
    protected array $options = [];
   
    public static function make(string $field): self
    {
        $instance = new self();
        $instance->field = $field;
        $instance->options['min'] = 'infinite';
        $instance->options['max'] = 'infinite';
        $instance->options['step'] = 1;
        return $instance;
    }

    public function min(float $min): self
    {
        $this->options['min'] = $min;
        return $this;
    }

    public function max(float $max): self
    {
        $this->options['max'] = $max;
        return $this;
    }

    public function step(float $step): self
    {
        $this->options['step'] = $step;
        return $this;
    }

    
    public function registerTo($generator): void
    {
  
        $b = [] ;
        $b['field'] = $this->field ;
        $b['min'] =  $this->options['min'];
        $b['max'] =  $this->options['max'];
        $b['step'] =  $this->options['step'];

        $generator->tabFilterFields[$this->field] =  $this->field;
        $generator->tabFilterLabels[$this->field] = $this->field;
        $generator->tabFilterTypes[$this->field] = $this->type;
        $generator->tabFilterOptions[$this->field] = $b;
    
    }

    


    


}