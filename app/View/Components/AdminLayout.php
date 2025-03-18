<?php

namespace App\View\Components;

use Illuminate\View\Component;

class AdminLayout extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct()
    {
        // Anda bisa menambahkan parameter jika diperlukan
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('layouts.admin'); // Pastikan ini sesuai dengan nama file layout admin Anda
    }
}
