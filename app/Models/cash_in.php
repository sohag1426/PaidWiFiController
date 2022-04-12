<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class cash_in extends Model
{
    use HasFactory;

    /**
     * The model type
     *
     * @var string|null (node|central)
     */
    protected $modelType = 'central';


    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = ['description', 'transaction_type', 'transaction'];


    /**
     * Set connection for Central Model if (host_type === 'node')
     *
     * @param  array  $attributes
     * @return void
     */
    public function __construct(array $attributes = [])
    {
        if (config('local.host_type', 'central') === 'node') {
            if ($this->modelType === 'central') {
                $this->connection = config('database.central', 'mysql');
            }
        }

        parent::__construct($attributes);
    }

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];


    /**
     * Get the description.
     *
     * @return string
     */
    public function getDescriptionAttribute()
    {
        switch ($this->transaction_code) {
            case '1':
                return "Customer Payment";
                break;
            case '2':
                return "Subscription Payment";
                break;
            case '3':
                return "Cash Out";
                break;
            case '4':
                return "Admin Credit";
                break;
            case '5':
                return "Online Recharge";
                break;
            default:
                return "Unknown";
                break;
        }
    }

    /**
     * Get the description.
     *
     * @return string
     */
    public function getTransactionTypeAttribute()
    {
        return "Cash In";
    }


    public function getTransactionAttribute()
    {
        if ($this->transaction_code == 1) {
            return customer_payment::where('id', $this->transaction_id)->first();
        }

        return false;
    }
}
