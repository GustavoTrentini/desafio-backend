<?php

namespace App\Models;

use App\Contracts\TransferInterface;
use App\Dto\Input\TransferInput;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transfer extends Model implements TransferInterface
{
    use HasFactory;

    protected $fillable = [
        'payer',
        'payee',
        'value',
        'description'
    ];

    public function newTransfer(TransferInput $transferInput): ?Transfer{
        return $this->create($transferInput->toArray());
    }

    public function send(int $payer): Collection{
        return $this->with('payer')->with('payee')->where('payer', $payer)->get();
    }

    public function received(int $payee): Collection{
        return $this->with('payer')->with('payee')->where('payee', $payee)->get();
    }

    public function payer(){
        return $this->belongsTo(User::class, 'payer');
    }

    public function payee(){
        return $this->belongsTo(User::class, 'payee');
    }
}
