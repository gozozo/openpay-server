<?php

namespace Gozozo\OpenpayServer\Http\Controllers\Api;

use Carbon\Carbon;
use Gozozo\OpenpayServer\Models\OpenpayVerificationWebhookModel;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class WebhookController extends Controller
{
    public function webhook(Request $request){

        if($request->input('type') == 'verification'){
            $webhook = new OpenpayVerificationWebhookModel();
            $webhook->event_date = Carbon::parse($request->input('event_date'));
            $webhook->verification_code = $request->input('verification_code');
            $webhook->save();
        }else {
            $method = config('openpay.webhook.'.$request->input('type'));
            if (isset($method)) {
                call_user_func($method, $request);
            }
        }
        return "ok";
    }
    public function code(Request $request){
        $webhook = OpenpayVerificationWebhookModel::get()->last();
        if ($webhook != null){
            return $webhook->verification_code;
        }else{
            return 'No Active';
        }
    }
}