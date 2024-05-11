<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contract extends Model
{
    use HasFactory;
    protected $fillable = [
        'clientType',
        'list',
        'libelle',
        'contractStartDate',
        'contractEndDate',
        'minimumGuaranteed',
        'travelStartDate',
        'travelEndDate',
        'isActive',
        'activateInternetFees',
        'modifyFeesAmount',
        'TKXL',
        'payLater',
        'payLaterTimeLimit',
        'minTimeBeforeFlightCC',
        'minTimeBeforeFlightBalance',
        'stampInvoice',
        'additionalClientFees',
        'discount',
    ];
}
