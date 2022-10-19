<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Input extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public $name, $type, $label, $multiple, $defaultValue, $form;
    public function __construct(
        $name = 'Input Name',
        $type = 'text',
        $label = 'Input Label',
        $multiple = false,
        $defaultValue = null,
        $form = null
    ) {
        $this->name = $name;
        $this->type = $type;
        $this->label = $label;
        $this->multiple = $multiple;
        $this->defaultValue = $defaultValue;
        $this->form = $form;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.input');
    }
}
