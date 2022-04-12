<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class customer extends Model
{
    use HasFactory;

    /**
     * The model type
     *
     * @var string|null (node|central)
     */
    protected $modelType = 'node';


    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = ['payments', 'payment_color', 'sms_histories', 'address', 'color', 'role', 'remaining_validity'];


    /**
     * Set connection for Node Model
     *
     * @param  array  $attributes
     * @return void
     */
    public function __construct(array $attributes = [])
    {
        if (Auth::user()) {

            $operator = Auth::user();

            $this->connection = $operator->radius_db_connection;
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
     * Customer Billing Profile.
     *
     * @return bool
     */
    public function getAddressAttribute()
    {
        $address = $this->name . "<br>"
            . "Mobile: " . $this->mobile . "<br>";

        if (strlen($this->house_no)) {
            $address .= "H# " . $this->house_no . "<br>";
        }

        if (strlen($this->road_no)) {
            $address .= "R# " . $this->road_no . "<br>";
        }

        if (strlen($this->thana)) {
            $address .=  $this->thana . "," . $this->district;
        }

        return $address;
    }

    /**
     * Get color attribute
     *
     * @return bool
     */
    public function getColorAttribute()
    {
        $color = "text-dark";

        if ($this->status == 'suspended' || $this->status == 'fup') {
            $color = "text-warning";
        }

        if ($this->status == 'disabled') {
            $color = "text-danger";
        }

        return $color;
    }

    /**
     * Get the payments for the customer.
     */
    public function getPaymentsAttribute()
    {
        $where = [
            ['operator_id', '=', $this->operator_id],
            ['customer_id', '=', $this->id],
        ];

        return customer_payment::where($where)->get();
    }


    /**
     * Get the payments for the customer.
     */
    public function getPaymentColorAttribute()
    {

        if ($this->payment_status == 'billed') {
            return "text-warning";
        } else {
            return "text-success";
        }
    }


    /**
     * Get the sms histories for the customer.
     */
    public function getSmsHistoriesAttribute()
    {
        $where = [
            ['operator_id', '=', $this->operator_id],
            ['customer_id', '=', $this->id],
        ];

        return sms_history::where($where)->get();
    }

    /**
     * Customer Role Name.
     *
     * @return string
     */
    public function getRoleAttribute()
    {
        return "customer";
    }

    /**
     * Customer device Name.
     *
     * @return string
     */
    public function getRemainingValidityAttribute()
    {
        $today = Carbon::now(config('app.timezone'));

        $exp = Carbon::createFromIsoFormat(config('app.expiry_time_format'), $this->package_expired_at);

        if ($exp->lessThan($today)) {
            return 0 . ' Day Left';
        } else {
            $remaining = $today->diffInDays($exp) + 1;

            if ($remaining > 1) {
                return $remaining . ' Days Left';
            } else {
                return $remaining . ' Day Left';
            }
        }
    }

    /**
     * Get the radaccts for the customer.
     */
    public function radaccts()
    {
        return $this->hasMany(radacct::class, 'username', 'username');
    }

    /**
     * Set the user's username.
     *
     * @param  string  $value
     * @return void
     */
    public function setUsernameAttribute($value)
    {
        $this->attributes['username'] = trim($value);
    }

    /**
     * Set the user's password.
     *
     * @param  string  $value
     * @return void
     */
    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = trim($value);
    }
}
