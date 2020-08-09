<?php

namespace App\View\Components;

use Illuminate\View\Component;

class OldPaymentMessage extends Component
{
    public $message, $type, $signature;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($message, $type, $signature)
    {
        $this->message = $message;
        $this->type = $type;
        $this->signature = $signature;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('components.qwerty-payment-message',[
            'message'=>$this->message,
            'type'=>$this->type,
            'signature'=>$this->signature
        ]);
    }
}
