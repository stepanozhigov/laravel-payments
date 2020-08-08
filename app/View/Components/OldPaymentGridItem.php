<?php

namespace App\View\Components;

use Carbon\Carbon;
use Illuminate\View\Component;

class QwertyPaymentGridItem extends Component
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
        return view('components.old-payment-grid-item',['payment'=>$this->payment]);
    }
}
