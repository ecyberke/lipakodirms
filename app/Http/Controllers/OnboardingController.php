<?php
namespace App\Http\Controllers;

use App\Onboarding;
use App\Tenant;
use App\Landlord;
use App\Invoice;
use App\Traits\FileManager;
use App\Traits\NotifyClient;
use App\Traits\UtilTrait;
use Illuminate\Http\Request;

class OnboardingController extends Controller
{
 
    use NotifyClient;
    use UtilTrait;
    use FileManager;
    
    public function index()
    {
        $entries = Onboarding::latest()->paginate(10);
        return view('onboardings.index', compact('entries'));
    }

  public function store(Request $request)
{
    $request->validate([
        'full_name' => 'required',
        'type' => 'required|in:Tenant,Seeker,Owner',
        'status' => 'nullable|in:Prospect,Onboarded,Dropped,Closed',
        'fee' => 'nullable|in:500,1000,0'
    ]);

    // Save the new prospect
    $prospect = Onboarding::create($request->all());

    // Generate invoice if type is Tenant or Seeker
    if (in_array($request->type, ['Tenant', 'Seeker']) && $request->filled('fee') && (int) $request->fee > 0) {
        $date = now()->format('Y-m-d'); // or your preferred date format

        // Simulate tenant object from the created prospect
        $tenant = (object)[
            'account_number' => 'ACC' . str_pad($prospect->id, 5, '0', STR_PAD_LEFT), // or use actual logic
            'amount' => $request->fee,
            'name' => $prospect->full_name,
            'phone' => $prospect->phone,
            'id' => $prospect->id,
        ];

        $invoice = new Invoice;
        $invoice->tenant_acc = $tenant->account_number;
        $invoice->type = 'House Viewing';
        $invoice->other_bill  = $tenant->amount;
        $invoice->rent_month = $date;
        $invoice->total_payable = $tenant->amount;
        $invoice->balance = $tenant->amount;
        $invoice->tenant_name = $tenant->name;
        $invoice->tenant_phone = $tenant->phone;
        $invoice->save();

        // Check if tenant exists in HouseView for welcome SMS
        $tenant_being_placed = Onboarding::find($tenant->id);
        if ($tenant_being_placed) {
            $smses = [];

            $sms_object = $this->welcomeHouseView([
                'name' => $tenant_being_placed->name,
                'phone' => (int) $tenant_being_placed->phone,
                'account_number' => $tenant_being_placed->account_number,
            ]);

            array_push($smses, $sms_object);

            // Optionally send SMS here
            $this->sendMessage($smses);
        }
    }

    return redirect()->back()->with('success', 'Prospect added successfully!');
}

    
    public function update(Request $request, Onboarding $onboarding)
{
    $onboarding->update($request->all());
    return redirect()->back()->with('success', 'Entry updated!');
}

public function destroy(Onboarding $onboarding)
{
    $onboarding->delete();
    return redirect()->back()->with('success', 'Entry deleted!');
}
public function onboard(Onboarding $onboarding)
{
    if ($onboarding->status === 'Onboarded') {
        return back()->with('error', 'This person has already been onboarded.');
    }

    if ($onboarding->type === 'Tenant' || $onboarding->type === 'Seeker') {
        Tenant::create([
            'full_name' => $onboarding->full_name,
            'phone' => $onboarding->phone,
            'email' => $onboarding->email,
            'physical_address' => $onboarding->location,
            'id_number' => $onboarding->id_number,
            'account_number' => $this->generateUserAccountNumber(),
            'password' => 'N/A',
            'type' => $onboarding->type,
        ]);
        $this->createLog([
            'username' => auth()->user()->username,
            'operation' => 'Created Tenant ' . $onboarding->full_name,
            'more_info' => 'New account number generated and assigned:  ',
            'tenant_id' =>  '200',
            'servicerequest_id' => '0',
            'house_id' => '0',
            'apartment_id' => '0',
            'landlord_id' => '0',
            'bill_id' => '0',
            'invoice_id' => '0',
            'sms_id' => '0',
            'user_id' => '0',
        ]);
    } elseif ($onboarding->type === 'Owner') {
        Landlord::create([
            'full_name' => $onboarding->full_name,
            'id' => $onboarding->phone,
            'email' => $onboarding->email,
            'location' => $onboarding->location,
            'landlordid_number' => $onboarding->id_number,
            'password' => $onboarding->id_number,
            'type' => $onboarding->type,
        ]);
    } else {
        return back()->with('error', 'Only Tenants and Owners can be onboarded.');
    }

    $onboarding->update(['status' => 'Onboarded']);

    return back()->with('success', 'Onboarding Successful!');
}

     private function welcomeHouseView($notificationBody)
    {
        $userData = (object) $notificationBody;
        $account_number = $userData->account_number;

        // $amount = $userData->to_pay;

        $tenant_full_name = $userData->name;
        $arr_names = explode(' ', trim(ucfirst(strtolower($tenant_full_name))));
        $tenant_first_name = $arr_names[0]; // will print Test

        $format = "Dear %s,\nWelcome to Lesa Property Agency.\nYour temporary tenant account number is %d:\nMake the payment via Mpesa using: \nPaybill: 743994 \nAccount: %s";
        $message_text = sprintf($format, $tenant_first_name, $account_number, $account_number);

        $message_text .= "\nFor enquiries call 0797597530.";

        $data = [
            'from' => 'LesaAgency',
            'to' => (int) $userData->phone,
            'text' => $message_text,
        ];

        return $data;

    }
}
