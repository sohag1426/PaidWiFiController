<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class master_package extends Model
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
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = ['customer_count', 'total_octet_limit', 'readable_rate_unit'];


    /**
     * Calculate the total octet limit.
     *
     * @return bool
     */
    public function getCustomerCountAttribute()
    {
        $key = 'master_package_customerCount_' . $this->id;

        $ttl = 300;

        return Cache::remember($key, $ttl, function () {
            $master = operator::find($this->mgid);
            $customer_count = 0;
            foreach ($this->packages as $package) {
                $model = new customer();
                $model->setConnection($master->node_connection);
                $customers = $model->where('package_id', $package->id)->count();
                $customer_count = $customer_count + $customers;
            }
            return $customer_count;
        });
    }

    /**
     * Calculate the total octet limit.
     *
     * @return bool
     */
    public function getTotalOctetLimitAttribute()
    {
        if ($this->volume_unit === 'GB') {
            return $this->volume_limit * 1000 * 1000 * 1000;
        } else {
            return $this->volume_limit * 1000 * 1000;
        }
    }

    /**
     * Calculate the total octet limit.
     *
     * @return bool
     */
    public function getReadableRateUnitAttribute()
    {
        if ($this->rate_unit === 'M') {
            return 'Mbps';
        } else {
            return 'Kbps';
        }
    }

    /**
     * Get the operator's associated with the package
     */
    public function operators()
    {
        return $this->belongsToMany(operator::class, 'packages', 'mpid', 'operator_id', 'id', 'id');
    }

    /**
     * Get the packages that's belongs to this master package
     */
    public function packages()
    {
        return $this->hasMany(package::class, 'mpid', 'id');
    }
}
