<?php

namespace App\View\Components;

use Illuminate\View\Component;

class QwertyPaymentSingleItem extends Component
{

    public $payment;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($payment)
    {
        $this->payment = $payment;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('components.qwerty-payment-single-item',['payment'=>$this->payment]);
    }
}
