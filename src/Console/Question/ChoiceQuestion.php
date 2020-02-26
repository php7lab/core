<?php

namespace PhpLab\Core\Console\Question;

class ChoiceQuestion extends \Symfony\Component\Console\Question\ChoiceQuestion
{

    public function __construct(string $question, array $choices, $default = null)
    {

        parent::__construct($question, $choices, $default);
        $this->setNormalizer(function ($value) {
            if ($value == 'a') {
                $choices = $this->getChoices();
                unset($choices['a']);
                $value = implode(',', array_keys($choices));
            }
            return $value;
        });
    }

    public function getChoices()
    {
        $choices = parent::getChoices();
        if ($this->isMultiselect()) {
            $choices['a'] = '[All]';
        }
        return $choices;
    }
}