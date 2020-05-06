<?php

namespace App\Providers;

use App\Models\Order;
use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();
        $this->registerGates();
    }

    /**
     * Register gates.
     *
     * @return void
     */
    protected function registerGates()
    {
        // Base permissions

        Gate::define('admin-permission', function (User $user) {
            return $user->role->id === Role::ADMIN_ID;
        });

        Gate::define('doctor-permission', function (User $user) {
            return $user->role->id === Role::DOCTOR_ID;
        });

        Gate::define('clinic-permission', function (User $user) {
            return $user->role->id === Role::CLINIC_ID;
        });

        // Action permissions

        Gate::define('edit-doctor', function (User $authUser, User $doctor) {
            return
                $authUser->role->id === Role::ADMIN_ID ||
                ($authUser->role->id === Role::DOCTOR_ID && $authUser->id === $doctor->id);
        });

        Gate::define('see-clinic', function (User $authUser, User $clinic) {
            switch ($authUser->role_id) {
                case Role::ADMIN_ID:
                    return true;
                case Role::DOCTOR_ID:
                    if ($authUser->clinics()->find($clinic->id)->count() === 1) {
                        return true;
                    }

                    return false;
                case Role::CLINIC_ID:
                    return $authUser->id === $clinic->id;
                default:
                    return false;
            }
        });

        Gate::define('edit-clinic', function (User $authUser, User $clinic) {
            return
                $authUser->role->id === Role::ADMIN_ID ||
                ($authUser->role->id === Role::CLINIC_ID && $authUser->id === $clinic->id);
        });

        Gate::define('see-order', function (User $authUser, Order $order) {
            switch ($authUser->role_id) {
                case Role::ADMIN_ID:
                    return true;
                case Role::DOCTOR_ID:
                    if ($authUser->clinics()->find($order->clinic->id)->count() === 1) {
                        return true;
                    }

                    return false;
                case Role::CLINIC_ID:
                    return $authUser->id === $order->clinic->id;
                default:
                    return false;
            }
        });

        Gate::define('set-clinic-order', function (User $authUser, User $clinic) {
            switch ($authUser->role_id) {
                case Role::ADMIN_ID:
                    return true;
                case Role::DOCTOR_ID:
                    if ($authUser->clinics()->find($clinic->id)->count() === 1) {
                        return true;
                    }

                    return false;
                case Role::CLINIC_ID:
                    return $authUser->id === $clinic->id;
                default:
                    return false;
            }
        });
    }
}
