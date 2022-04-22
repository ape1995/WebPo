<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class UserExport implements FromView, ShouldAutoSize
{

    protected $users;

    public function __construct($users)
    {
        $this->users = $users;
    }

    public function view(): View
    {       
        $users = $this->users;

        return view('exports.user',compact('users'));
    }

}
