<?php

namespace App\View\Components\Forms\Inputs\Floating;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Input extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(
        protected string $type,
        protected string $model,
        protected string $text,
        protected string|null $placeholder = null,
        protected string|null $value = null,
        protected bool $autocomplete = false,
        protected bool $wire = false,
        protected bool $error = false,
        protected bool $required = false,
    ) {
        //
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.forms.inputs.floating.input', [
            'type' => $this->type,
            'model' => $this->model,
            'text' => $this->text,
            'placeholder' => $this->placeholder,
            'value' => $this->value,
            'autocomplete' => $this->autocomplete,
            'wire' => $this->wire,
            'error' => $this->error,
            'required' => $this->required,
        ]);
    }
}
