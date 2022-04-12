<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class package extends Model
{
    use HasFactory;

    /**
     * The model type
     *
     * @var string|null (node|central)
     */
    protected $modelType = 'central';

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
     * Get the operator that owns the package.
     */
    public function operator()
    {
        return $this->belongsTo(operator::class, 'operator_id', 'id');
    }

    /**
     * Get the master package that owns the package.
     */
    public function master_package()
    {
        return $this->belongsTo(master_package::class, 'mpid', 'id');
    }

    /**
     * Get the master package that owns the package.
     */
    public function parent_package()
    {
        return $this->belongsTo(package::class, 'ppid', 'id');
    }


    /**
     * Get the master package that owns the package.
     */
    public function child_packages()
    {
        return $this->hasMany(package::class, 'ppid', 'id');
    }


    /**
     * Get the price.
     *
     * @param  string  $value
     * @return string
     */
    public function getPriceAttribute($value)
    {
        if ($value > 0) {
            return $value;
        } else {
            return 1;
        }
    }

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = ['connection_type', 'customer_count', 'readable_rate_unit', 'rate_limit', 'total_octet_limit', 'validity'];

    /**
     * Get the fair usage policy associated with the package.
     */
    public function getConnectionTypeAttribute()
    {
        if ($this->master_package) {
            return $this->master_package->connection_type;
        } else {
            return 'Hotspot';
        }
    }

    /**
     * Calculate the total customer.
     *
     * @return bool
     */
    public function getCustomerCountAttribute()
    {
        if ($this->master_package) {
            $key = 'package_customerCount_' . $this->id;

            $ttl = 300;

            return Cache::remember($key, $ttl, function () {
                $master = operator::find($this->mgid);
                $customer_count = 0;
                $model = new customer();
                $model->setConnection($master->node_connection);
                $customers = $model->where('package_id', $this->id)->count();
                $customer_count = $customer_count + $customers;
                return $customer_count;
            });
        } else {
            return 0;
        }
    }


    /**
     * Calculate the total octet limit.
     *
     * @return bool
     */
    public function getReadableRateUnitAttribute()
    {
        if ($this->master_package) {
            return $this->master_package->readable_rate_unit;
        } else {
            return 'Mbps';
        }
    }

    /**
     * Calculate the rate_limit.
     *
     * @return bool
     */
    public function getRateLimitAttribute()
    {
        if ($this->master_package) {
            return $this->master_package->rate_limit;
        } else {
            return 0;
        }
    }

    /**
     * Calculate the total octet limit.
     *
     * @return bool
     */
    public function getTotalOctetLimitAttribute()
    {
        if ($this->master_package) {
            return $this->master_package->total_octet_limit;
        } else {
            return 100 * 1000 * 1000;
        }
    }

    /**
     * Get validity.
     *
     * @return bool
     */
    public function getValidityAttribute()
    {
        if ($this->master_package) {
            return $this->master_package->validity;
        } else {
            return 1;
        }
    }
}
