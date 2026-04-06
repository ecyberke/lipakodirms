<?php
namespace App\Http\Controllers\SuperAdmin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ConnectionController extends SuperAdminController
{
    public function index()
    {
        $settings = DB::table('super_admin_settings')->first();
        return view('super_admin.connections.index', compact('settings'));
    }

    public function update(Request $request)
    {
        $data = $request->only([
            'sms_api_token', 'sms_sender_id', 'sms_admin_phone',
            'mpesa_consumer_key', 'mpesa_consumer_secret',
            'mpesa_shortcode', 'mpesa_passkey', 'mpesa_paybill'
        ]);

        $existing = DB::table('super_admin_settings')->first();
        if ($existing) {
            DB::table('super_admin_settings')->update($data);
        } else {
            DB::table('super_admin_settings')->insert($data);
        }

        return back()->with('success', 'Connection settings saved successfully.');
    }
}
