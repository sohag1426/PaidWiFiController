<?php

namespace App\Policies;

use App\Models\master_package;
use App\Models\operator;
use Illuminate\Auth\Access\HandlesAuthorization;

class MasterPackagePolicy
{
    use HandlesAuthorization;


    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\Models\operator  $operator
     * @return mixed
     */
    public function viewAny(operator $operator)
    {
        //
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\operator  $operator
     * @param  \App\Models\master_package  $masterPackage
     * @return mixed
     */
    public function view(operator $operator, master_package $masterPackage)
    {
        //
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\operator  $operator
     * @return mixed
     */
    public function create(operator $operator)
    {
        //
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\operator  $operator
     * @param  \App\Models\master_package  $masterPackage
     * @return mixed
     */
    public function update(operator $operator, master_package $masterPackage)
    {
        if ($operator->id === $masterPackage->mgid) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\operator  $operator
     * @param  \App\Models\master_package  $masterPackage
     * @return mixed
     */
    public function updateName(operator $operator, master_package $masterPackage)
    {
        // Trial is constant
        if ($masterPackage->name == 'Trial') {
            return false;
        }

        if ($operator->id === $masterPackage->mgid) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\operator  $operator
     * @param  \App\Models\master_package  $masterPackage
     * @return mixed
     */
    public function replace(operator $operator, master_package $masterPackage)
    {
        return false;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\operator  $operator
     * @param  \App\Models\master_package  $masterPackage
     * @return mixed
     */
    public function delete(operator $operator, master_package $masterPackage)
    {
        // Trial is constant
        if ($masterPackage->name == 'Trial') {
            return false;
        }

        if ($operator->id !== $masterPackage->mgid) {
            return false;
        }

        if ($masterPackage->customer_count == 0) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\operator  $operator
     * @param  \App\Models\master_package  $masterPackage
     * @return mixed
     */
    public function restore(operator $operator, master_package $masterPackage)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\operator  $operator
     * @param  \App\Models\master_package  $masterPackage
     * @return mixed
     */
    public function forceDelete(operator $operator, master_package $masterPackage)
    {
        //
    }
}
