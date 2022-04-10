<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class operator extends Authenticatable implements
    MustVerifyEmail
{
    use HasFactory, Notifiable;

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
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = ['central_connection', 'node_connection', 'pgsql_connection', 'address', 'account_type_alias', 'account_balance', 'credit_balance', 'color', 'role_alias', 'readable_role'];


    /**
     * Get central connection
     *
     * @return bool
     */
    public function getCentralConnectionAttribute()
    {
        return config('database.central', 'mysql');
    }

    /**
     * Get node connection
     *
     * @return bool
     */
    public function getNodeConnectionAttribute()
    {
        return $this->radius_db_connection;
    }

    /**
     * Get credit balance
     *
     * @return bool
     */
    public function getPgsqlConnectionAttribute()
    {
        return $this->radius_db_connection . 'pgsql';
    }

    /**
     * Get address attribute
     *
     * @return bool
     */
    public function getAddressAttribute()
    {
        $address = '';
        $address .=  $this->company . "<br>";
        if (strlen($this->house_no) && strlen($this->road_no)) {
            $address .=  $this->house_no . "," . $this->road_no . "<br>";
        }
        if (strlen($this->district) && strlen($this->postal_code)) {
            $address .=  $this->district . "," . $this->postal_code . "<br>";
        }
        $address .= "Mobile: " . $this->mobile . "<br>";
        // $address .=  "Email: " . $this->email;

        return $address;
    }

    /**
     * Get credit balance
     *
     * @return bool
     */
    public function getAccountTypeAliasAttribute()
    {
        if ($this->account_type == 'debit') {
            return 'Debit/Prepaid';
        } else {
            return 'Credit/Postpaid';
        }
    }

    /**
     * Get Account balance.
     * Will be used for Debit/Prepaid reseller's balance check
     *
     * @return bool
     */
    public function getAccountBalanceAttribute()
    {

        if ($this->account_type !== 'debit') {
            return 100;
        }

        $roles = ['operator', 'sub_operator'];

        if (!in_array($this->role, $roles)) {
            return 'N/A';
        }

        $where = [
            ['account_owner', '=', $this->id],
            ['account_provider', '=', $this->gid],
        ];

        $account = account::where($where)->firstOr(function () {
            return account::make([
                'account_provider' => 0,
                'account_owner' => 0,
                'balance' => 0,
            ]);
        });

        return round($account->balance);
    }

    /**
     * Get credit balance
     * Will be used for Credit/Postpaid reseller's Credit Limit check
     *
     * @return bool
     */
    public function getCreditBalanceAttribute()
    {
        if ($this->account_type !== 'credit') {
            return 100;
        }

        $roles = ['operator', 'sub_operator'];

        if (!in_array($this->role, $roles)) {
            return 'N/A';
        }

        $where = [
            ['account_provider', '=', $this->id],
            ['account_owner', '=', $this->gid],
        ];

        $account_payable = account::where($where)->firstOr(function () {
            return account::make([
                'account_provider' => 0,
                'account_owner' => 0,
                'balance' => 0,
            ]);
        });

        return round($this->credit_limit - $account_payable->balance);
    }

    /**
     * Get color attribute
     *
     * @return bool
     */
    public function getColorAttribute()
    {
        $color = "text-dark";

        if ($this->provisioning_status == 0) {
            $color = "text-danger";
        }

        if ($this->provisioning_status == 1) {
            $color = "text-warning";
        }

        return $color;
    }

    /**
     * Get role alias
     *
     * @return bool
     */
    public function getRoleAliasAttribute()
    {
        if ($this->role === 'operator') {
            if ($this->gid === $this->mgid) {
                return $this->role;
            } else {
                return 'sub_operator';
            }
        }

        return $this->role;
    }

    /**
     * Get readable role
     *
     * @return bool
     */
    public function getReadableRoleAttribute()
    {
        switch ($this->role) {
            case 'super_admin':
                return 'Super Admin';
                break;

            case 'group_admin':
                return 'Group Admin';
                break;

            case 'operator':
                return 'Reseller';
                break;

            case 'sub_operator':
                return 'Sub-Reseller';
                break;

            default:
                return $this->role;
                break;
        }
    }
}
