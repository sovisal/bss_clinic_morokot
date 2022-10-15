<?php

namespace App\View\Components;

use App\Models\Patient;
use Illuminate\View\Component;

class ReportFilter extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
		$data['patient'] = Patient::orderBy('name_en', 'asc')->get();
        return view('components.para-clinic.report-filter', $data);
    }
}
