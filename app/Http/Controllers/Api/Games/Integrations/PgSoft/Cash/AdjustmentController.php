<?php

namespace App\Http\Controllers\Api\Games\Integrations\PgSoft\Cash;

use App\Http\Controllers\Controller;
use App\Http\Requests\Integrations\PgSoft\Cash\AdjustmentRequest;
use App\Models\PgLog;
use Illuminate\Http\Request;

class AdjustmentController extends Controller
{
    public function __invoke(Request $request)
    {
        PgLog::create([
            'name' => 'TransferInOutRequest',
            'request' => $request->all(),
        ]);

        return response()->json([
            'status' => 'OK',
            'message' => 'Adjustment is valid',
        ]);
    }
}
