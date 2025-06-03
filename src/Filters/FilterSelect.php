<?php
namespace Hoggarcrud\Hoggar\Filters;

class FilterSelect
{
    protected string $field;
    protected string $label;
    protected string $type = 'Select';
    protected array $options = [];
   
    public static function make(string $field): self
    {
        $instance = new self();
        $instance->field = $field;
        return $instance;
    }

    public function contents(array $contents): self
    {
        $this->options['contents'] = $contents;
        return $this;
    }

    public function labels(array $labels): self
    {
        $this->options['labels'] = $labels;
        return $this;
    }

    public function params(array $params): self
    {
        $this->options['contents'] = $params['contents'];
        $this->options['labels'] = $params['labels'];
        return $this;
    }

    
    public function registerTo($generator): void
    {
  
        $b = [] ;
        $b['field'] = $this->field ;
        $b['contents'] =  $this->options['contents'];
        $b['labels'] =  $this->options['labels'];

        $generator->tabFilterFields[$this->field] =  $this->field;
        $generator->tabFilterLabels[$this->field] = $this->field;
        $generator->tabFilterTypes[$this->field] = $this->type;
        $generator->tabFilterOptions[$this->field] = $b;
    
    }

    


    


}