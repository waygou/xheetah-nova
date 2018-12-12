<?php

namespace Waygou\XheetahNova;

use Laravel\Nova\Nova;
use Laravel\Nova\Tool;
use Waygou\XheetahNova\Resources\Test;
use Waygou\XheetahNova\Resources\User;
use Waygou\XheetahNova\Resources\Client;
use Waygou\XheetahNova\Resources\Address;
use Waygou\XheetahNova\Resources\Courier;
use Waygou\XheetahNova\Resources\Vehicle;
use Waygou\XheetahNova\Resources\Delivery;
use Waygou\XheetahNova\Resources\Employee;
use Waygou\XheetahNova\Resources\MainRole;
use Waygou\XheetahNova\Resources\ClientUser;
use Waygou\XheetahNova\Resources\CostCenter;
use Waygou\XheetahNova\Resources\VehicleType;
use Waygou\XheetahNova\Resources\DeliveryType;
use Waygou\XheetahNova\Resources\DurationType;
use Waygou\XheetahNova\Resources\DeliveryStatus;

class XheetahNova extends Tool
{
    /**
     * Perform any tasks that need to happen when the tool is booted.
     *
     * @return void
     */
    public function boot()
    {
        Nova::resources([
            Client::class,
            CostCenter::class,
            Address::class,
            Courier::class,
            ClientUser::class,
            Employee::class,
            MainRole::class,
            User::class,
            Vehicle::class,
            DurationType::class,
            VehicleType::class,
            DeliveryType::class,
            Delivery::class,
            DeliveryStatus::class,
            Test::class,
        ]);
    }

    /**
     * Build the view that renders the navigation links for the tool.
     *
     * @return \Illuminate\View\View
     */
    public function renderNavigation()
    {
        return view('xheetah-nova::navigation');
    }
}
