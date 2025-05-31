<?php
namespace Hoggarcrud\Hoggar\Fields;

class AudioUpload
{
    protected string $field;
    protected string $label;
    protected string $type = 'Audio';
    protected array $options = [];
    protected bool $noDatabase = false;
    protected $default = '';
    
    public static function make(string $field): self
    {
        $instance = new self();
        $instance->field = $field;
        $instance->label = ucfirst($field);
        $instance->options['field'] = $field;
        return $instance;
    }

    public function label(string $label): self
    {
        $this->label = $label;
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
        $generator->tabTypes[$this->field] = 'AudioEdit';
   }


}