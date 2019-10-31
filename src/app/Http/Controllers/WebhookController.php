<?php

namespace Gozozo\OpenpayServer\Http\Controllers;

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
            return 'The verification was saved';
        }
        $type = $request->input('type');

        $method = config('openpay.webhook.'.$type);
        if (isset($method)) {
            $response = call_user_func($method, $request);
            return $response == null ? 'ok' : $response;
        }
        return 'Method '.$type.' is not configured';
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