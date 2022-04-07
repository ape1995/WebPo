<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CSAnswer extends Model
{
    protected $connection = 'sqlsrv';
    protected $table = 'CSAnswers';
    
    use HasFactory;

    protected $fillable = [
        'CompanyID',
        'RefNoteID',
        'AttributeID',
        'Value',
        'PseudonymizationStatus',
        'NoteID',
    ];

}
