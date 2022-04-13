<?php

namespace App\Policies;

use App\Models\customer;
use App\Models\operator;
use Illuminate\Auth\Access\HandlesAuthorization;

class CustomerPolicy
{
    use HandlesAuthorization;

     /**
     * Determine whether the user can view Details.
     *
     * @param  \App\Models\operator  $operator
     * @param  \App\Models\Freeradius\customer  $customer
     * @return mixed
     */
    public function viewDetails(operator $operator, customer $customer)
    {

        if ($operator->role === 'manager') {
            return $operator->permissions->contains('view-customer-details');
        }

        if ($customer->gid == $operator->id) {
            return true;
        }

        if ($customer->operator_id == $operator->id) {
            return true;
        }

        return false;
    }


    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\operator  $operator
     * @return mixed
     */
    public function create(operator $operator)
    {

        return true;
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\operator  $operator
     * @param  \App\Models\Freeradius\customer  $customer
     * @return mixed
     */
    public function update(operator $operator, customer $customer)
    {
        return true;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\operator  $operator
     * @param  \App\Models\Freeradius\customer  $customer
     * @return mixed
     */
    public function delete(operator $operator, customer $customer)
    {
        return true;
    }


    /**
     * Determine whether the user can activate the model.
     *
     * @param  \App\Models\operator  $operator
     * @param  \App\Models\Freeradius\customer  $customer
     * @return mixed
     */
    public function activate(operator $operator, customer $customer)
    {
        if ($customer->status === 'active') {
            return false;
        }

        if ($customer->connection_type === 'Hotspot') {
            return false;
        }

        return true;
    }


    /**
     * Determine whether the user can suspend the model.
     *
     * @param  \App\Models\operator  $operator
     * @param  \App\Models\Freeradius\customer  $customer
     * @return mixed
     */
    public function suspend(operator $operator, customer $customer)
    {
        if ($customer->status === 'suspended') {
            return false;
        }

        if ($customer->connection_type === 'Hotspot') {
            return false;
        }

        return true;
    }


    /**
     * Determine whether the user can disable the model.
     *
     * @param  \App\Models\operator  $operator
     * @param  \App\Models\Freeradius\customer  $customer
     * @return mixed
     */
    public function disable(operator $operator, customer $customer)
    {
        if ($customer->status === 'disabled') {
            return false;
        }

        if ($customer->connection_type === 'Hotspot') {
            return false;
        }

        return true;
    }


    /**
     * Determine whether the user can change package.
     *
     * @param  \App\Models\operator  $operator
     * @param  \App\Models\Freeradius\customer  $customer
     * @return mixed
     */
    public function changePackage(operator $operator, customer $customer)
    {
        if ($customer->gid == $operator->id) {
            return true;
        }

        return false;
    }


    /**
     * Determine whether the user can edit speed limit.
     *
     * @param  \App\Models\operator  $operator
     * @param  \App\Models\Freeradius\customer  $customer
     * @return mixed
     */
    public function editSpeedLimit(operator $operator, customer $customer)
    {

        if ($customer->gid == $operator->id) {
            return true;
        }

        return false;
    }


    /**
     * Determine whether the user can generate Bill.
     *
     * @param  \App\Models\operator  $operator
     * @param  \App\Models\Freeradius\customer  $customer
     * @return mixed
     */
    public function generateBill(operator $operator, customer $customer)
    {

        if ($customer->connection_type == 'Hotspot') {
            return false;
        }

        return true;
    }


    /**
     * Determine whether the user can remove Mac Bind.
     *
     * @param  \App\Models\operator  $operator
     * @param  \App\Models\Freeradius\customer  $customer
     * @return mixed
     */
    public function removeMacBind(operator $operator, customer $customer)
    {
        if ($customer->mac_bind == 0) {
            return false;
        }

        return true;
    }


    /**
     * Determine whether the user can send Sms.
     *
     * @param  \App\Models\operator  $operator
     * @param  \App\Models\Freeradius\customer  $customer
     * @return mixed
     */
    public function sendSms(operator $operator, customer $customer)
    {

        return false;
    }

    /**
     * Determine whether the user can send Sms.
     *
     * @param  \App\Models\operator  $operator
     * @param  \App\Models\Freeradius\customer  $customer
     * @return mixed
     */
    public function sendLink(operator $operator, customer $customer)
    {

        return false;
    }


    /**
     * Determine whether the operator can chage operator
     *
     * @param  \App\Models\operator  $operator
     * @param  \App\Models\Freeradius\customer  $customer
     * @return mixed
     */
    public function changeOperator(operator $operator, customer $customer)
    {

        return false;
    }


    /**
     * Determine whether the user can pay advance payment.
     *
     * @param  \App\Models\operator  $operator
     * @param  \App\Models\Freeradius\customer  $customer
     * @return mixed
     */
    public function advancePayment(operator $operator, customer $customer)
    {

        return false;
    }


    /**
     * Determine whether the user can activate the fup.
     *
     * @param  \App\Models\operator  $operator
     * @param  \App\Models\Freeradius\customer  $customer
     * @return mixed
     */
    public function activateFup(operator $operator, customer $customer)
    {
        return false;
    }


    /**
     * Determine whether the user can create custom price.
     *
     * @param  \App\Models\operator  $operator
     * @param  \App\Models\Freeradius\customer  $customer
     * @return mixed
     */
    public function customPrice(operator $operator, customer $customer)
    {

        return false;
    }

    /**
     * Determine whether the operator can edit suspend date
     *
     * @param  \App\Models\operator  $operator
     * @param  \App\Models\Freeradius\customer  $customer
     * @return mixed
     */
    public function editSuspendDate(operator $operator, customer $customer)
    {

        return false;
    }

    /**
     * Determine whether the operator can reschedule Payment Date
     *
     * @param  \App\Models\operator  $operator
     * @param  \App\Models\Freeradius\customer  $customer
     * @return mixed
     */
    public function viewActivateOptions(operator $operator, customer $customer)
    {

        return false;
    }

    /**
     * Determine whether the user can activate the model.
     *
     * @param  \App\Models\operator  $operator
     * @param  \App\Models\Freeradius\customer  $customer
     * @return mixed
     */
    public function editBillingProfile(operator $operator, customer $customer)
    {

        return false;
    }

    /**
     * Determine whether the user can disconnect the model.
     *
     * @param  \App\Models\operator  $operator
     * @param  \App\Models\Freeradius\customer  $customer
     * @return mixed
     */
    public function disconnect(operator $operator, customer $customer)
    {

        return false;
    }
}
