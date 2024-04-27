<?php

namespace App\Observers;

use App\Models\SettingsGateway;

class SettingsGatewayObserver
{
    public function saving(SettingsGateway $settingsGateway)
    {
        if ($settingsGateway->is_active) {
            SettingsGateway::where('gateway_id', $settingsGateway->gateway_id)
                ->where('is_active', true)
                ->update(['is_active' => false]);
        }
    }
}
