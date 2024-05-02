<?php

namespace App\Models;

use App\Dto\Input\TransferInput;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transfer extends Model
{
    use HasFactory;

    protected $fillable = [
        'payer',
        'payee',
        'value',
        'description'
    ];

    public function newTransfer(TransferInput $transferInput): Transfer | null{
        return $this->create($transferInput->toArray());
    }
}
