<?php
namespace Hoggarcrud\Hoggar\Fields;

class Textarea
{
    protected string $field;
    protected string $label;
    protected string $type = 'Textarea';
    protected array $options = [];
    protected bool $noDatabase = false;
    protected $default = '';
    
    public static function make(string $field): self
    {
        $instance = new self();
        $instance->field = $field;
        $instance->label = ucfirst($field);
        $instance->options['field'] = $field;
        $instance->options['rows'] = 5;
        return $instance;
    }

    public function label(string $label): self
    {
        $this->label = $label;
        return $this;
    }

    public function value($value): self
    {
        $this->default = $value;
        return $this;
    }

    public function rows($value): self
    {
        $this->options['rows'] = $value;
        return $this;
    }

    
    public function notInDatabase(): self
    {
        $this->noDatabase = true;
        return $this;
    }

    public function registerTo($generator): void
    {
        $generator->tabFields[$this->field] = $this->field;
        $generator->tabLabels[$this->field] = $this->label;
        $generator->tabTypes[$this->field] = $this->type;
        $generator->tabOptions[$this->field] = $this->options;
        $generator->tabValues[$this->field] = $this->default;
        $generator->tabDefaultValues[$this->field] = $this->default;

        if ($this->noDatabase) {
            $generator->tabNodatabases[$this->field] = $this->field;
        }
    }


     public function updateTo($generator): void
    {
        $this->registerTo($generator);
   }


   public function repeteurTo($generator,$champs): void
    {
        $b = [];
        $b['type'] = $this->type ;
        $b['field'] = $this->field ;
        $b['label'] = $this->label ;
        $b['value'] = $this->default ;
        $b['rows'] = $this->options['rows'];

        $generator->tabRepeaterFields[$champs][$b['field']] = $b ;
      
  
    }


   public function repeteurToUpdate($generator,$champs): void
    {
      $this->repeteurTo($generator,$champs);
  
    } 

}