<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer2 extends Model
{
    protected $connection = 'sqlsrv';
    protected $table = 'Customer';
    
    use HasFactory;

    protected $fillable = [
        'CompanyID',
      'BAccountID',
      'CustomerClassID',
      'LanguageID',
      'TermsID',
      'DefSOAddressID',
      'DefBillAddressID',
      'DefBillContactID',
      'BaseBillContactID',
      'DefPaymentMethodID',
      'DefPMInstanceID',
      'CuryID',
      'CuryRateTypeID',
      'AllowOverrideCury',
      'AllowOverrideRate',
      'ARAcctID',
      'ARSubID',
      'DiscTakenAcctID',
      'DiscTakenSubID',
      'PrepaymentAcctID',
      'PrepaymentSubID',
      'COGSAcctID',
      'COGSSubID',
      'RetainageApply',
      'RetainagePct',
      'AutoApplyPayments',
      'PrintStatements',
      'PrintCuryStatements',
      'SendStatementByEmail',
      'CreditLimit',
      'CreditRule',
      'CreditDaysPastDue',
      'SharedCreditPolicy',
      'ConsolidateStatements',
      'StatementCustomerID',
      'SharedCreditCustomerID',
      'StatementCycleId',
      'StatementType',
      'StatementLastDate',
      'SmallBalanceAllow',
      'SmallBalanceLimit',
      'FinChargeApply',
      'PayToParent',
      'GroupMask',
      'PrintInvoices',
      'MailInvoices',
      'PrintDunningLetters',
      'MailDunningLetters',
      'CCProcessingID',
      'DeletedDatabaseRecord',
      'LocaleName'
    ];

}
