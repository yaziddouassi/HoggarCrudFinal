<?php

namespace Hoggarcrud\Hoggar\Fields;

class Repeater
{
    protected string $field;
    protected bool $noDatabase = false;
    protected int $numberOflines = 1;
    protected int $grille = 1;
    protected int $minLine = 0;
    protected string|int $maxLine = 'infinite';
    protected string $dragger = 'yes';
    protected string $ajoutLine = 'yes';
    protected string $suppLine = 'yes';
    protected $generation = null;
    protected array $nestedFields = [];

    public static function make(string $field): self
    {
        $instance = new self();
        $instance->field = $field;
        return $instance;
    }

    public function lines(int $line): self
    {
        $this->numberOflines = $line;
        return $this;
    }

    public function grid(int $grille): self
    {
        $this->grille = $grille;
        return $this;
    }

    public function min(int $minLine): self
    {
        $this->minLine = $minLine;
        return $this;
    }

    public function max(int $maxLine): self
    {
        $this->maxLine = $maxLine;
        return $this;
    }

    public function draggable(bool $dragger): self
    {
        $this->dragger = $dragger ? 'yes' : 'no';
        return $this;
    }

    public function addLine(bool $ajoutLine): self
    {
        $this->ajoutLine = $ajoutLine ? 'yes' : 'no';
        return $this;
    }

    public function removeLine(bool $suppLine): self
    {
        $this->suppLine = $suppLine ? 'yes' : 'no';
        return $this;
    }

    public function notInDatabase(): self
    {
        $this->noDatabase = true;
        return $this;
    }

    // ✅ méthode `form()` qui stocke simplement les champs internes
    public function form(array $fields): self
    {
        $this->nestedFields = $fields;
        return $this;
    }

    public function registerTo($generator): void
    {
        $a = [
            'field' => $this->field,
            'numberOflines' => $this->numberOflines,
            'grid' => $this->grille,
            'minLine' => $this->minLine,
            'maxLine' => $this->maxLine,
            'draggable' => $this->dragger,
            'addLine' => $this->ajoutLine,
            'removeLine' => $this->suppLine,
        ];

        $generator->tabFields[$this->field] = $a['field'];
        $generator->tabLabels[$this->field] = ucfirst($a['field']);
        $generator->tabTypes[$this->field] = 'Repeater';
        $generator->tabOptions[$this->field] = $a;
        $generator->tabRepeaters[$this->field] = $a;

        if ($this->noDatabase) {
            $generator->tabNodatabases[$this->field] = $this->field;
        }

        $this->generation = $generator;


        // ✅ Enregistrement des champs internes du repeater au bon moment
        foreach ($this->nestedFields as $field) {
            $field->repeteurTo($this->generation, $this->field);
        }
    }


    
     public function updateTo($generator): void
    {
        $a = [
            'field' => $this->field,
            'numberOflines' => $this->numberOflines,
            'grid' => $this->grille,
            'minLine' => $this->minLine,
            'maxLine' => $this->maxLine,
            'draggable' => $this->dragger,
            'addLine' => $this->ajoutLine,
            'removeLine' => $this->suppLine,
        ];

        $generator->tabFields[$this->field] = $a['field'];
        $generator->tabLabels[$this->field] = ucfirst($a['field']);
        $generator->tabTypes[$this->field] = 'Repeater';
        $generator->tabOptions[$this->field] = $a;
        $generator->tabRepeaters[$this->field] = $a;

        if ($this->noDatabase) {
            $generator->tabNodatabases[$this->field] = $this->field;
        }

        $this->generation = $generator;

        // ✅ Enregistrement des champs internes du repeater au bon moment
        foreach ($this->nestedFields as $field) {
            $field->repeteurToUpdate($this->generation, $this->field);
        }
   }


}