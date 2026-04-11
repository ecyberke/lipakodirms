<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BankStatementImport extends Model
{
    protected $table = 'bank_statement_imports';
    protected $guarded = [];
    protected $casts = [
        'statement_from' => 'date',
        'statement_to'   => 'date',
        'total_credits'  => 'decimal:2',
    ];

    public function organization()
    {
        return $this->belongsTo(Organization::class, 'org_id');
    }

    public function payments()
    {
        return $this->hasMany(ManagerPayment::class, 'import_id');
    }
}
