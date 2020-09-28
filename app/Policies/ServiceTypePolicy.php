<?php

namespace App\Policies;

use App\User;
use App\ServiceType;
use Illuminate\Auth\Access\HandlesAuthorization;

class ServiceTypePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any service types.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
      return $user->hasAnyRole(['admin','manager']);
    }

    /**
     * Determine whether the user can view the service type.
     *
     * @param  \App\User  $user
     * @param  \App\ServiceType  $serviceType
     * @return mixed
     */
    public function view(User $user, ServiceType $serviceType)
    {
      return $user->hasAnyRole(['admin','manager']);
    }

    /**
     * Determine whether the user can create service types.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
      return $user->hasAnyRole(['admin','manager']);
    }

    /**
     * Determine whether the user can update the service type.
     *
     * @param  \App\User  $user
     * @param  \App\ServiceType  $serviceType
     * @return mixed
     */
    public function update(User $user, ServiceType $serviceType)
    {
      return $user->hasAnyRole(['admin','manager']);
    }

    /**
     * Determine whether the user can delete the service type.
     *
     * @param  \App\User  $user
     * @param  \App\ServiceType  $serviceType
     * @return mixed
     */
    public function delete(User $user, ServiceType $serviceType)
    {
      return $user->hasAnyRole(['admin','manager']);
    }

    /**
     * Determine whether the user can restore the service type.
     *
     * @param  \App\User  $user
     * @param  \App\ServiceType  $serviceType
     * @return mixed
     */
    public function restore(User $user, ServiceType $serviceType)
    {
      return $user->hasAnyRole(['admin','manager']);
    }

    /**
     * Determine whether the user can permanently delete the service type.
     *
     * @param  \App\User  $user
     * @param  \App\ServiceType  $serviceType
     * @return mixed
     */
    public function forceDelete(User $user, ServiceType $serviceType)
    {
      return $user->hasAnyRole(['admin','manager']);
    }
}
