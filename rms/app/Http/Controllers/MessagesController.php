<?php

namespace App\Http\Controllers;

use App\Apartment;
use App\House;
use App\Http\Requests\UpdateMessageRequest;
use App\Http\Requests\MessageRequest;
use App\Http\Requests\RepliesRequest;
use App\Http\Requests\UpdateRepliesRequest;
use App\User;
use App\Message;
use App\Replies;
use App\Traits\FileManager;
use App\Traits\NotifyClient;
use App\Traits\UtilTrait;
use Hash;
use DB;
use Auth;
use Carbon\Carbon as CarbonCarbon;

class MessagesController extends Controller
{
    use NotifyClient;
    use UtilTrait;
    use FileManager;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {
          $user = User::where('id','!=', Auth::user()->id)->get();
        $emails = Message::where('receiver_id', Auth::user()->id)->where('status','!=',null)->get();
        $sent = Message::where('user_id', Auth::user()->id)->where('status','!=',null)->get();
        $email = Message::where('important', '!=', 0)->where('status','!=', null)->where('receiver_id', Auth::user()->id)->get();
        
        // dd($email->count());
        return view('chats.email-inbox', compact('user', 'emails', 'email', 'sent'));
    
    }
    public function count_messages()
    {
      
        $emails = Message::where('receiver_id', Auth::user()->id)->where('status','!=',null)->count();
        
        // dd($email->count());
        return view('layouts.header', compact('emails'));
    
    }
    public function sent()
    {
         $user = User::where('id','!=', Auth::user()->id)->get();
         $emails = Message::where('receiver_id', Auth::user()->id)->where('status','!=',null)->get();
        $sent = Message::where('user_id', Auth::user()->id)->where('status','!=',null)->get();
        $email = Message::where('important', '!=', 0)->where('status','!=', null)->where('receiver_id', Auth::user()->id)->get();
        
        return view('chats.email-sent', compact('user', 'emails', 'email', 'sent'));
      
    }
    public function important()
    {
         $user = User::where('id','!=', Auth::user()->id)->get();
       $emails = Message::where('receiver_id', Auth::user()->id)->where('status','!=',null)->get();
        $sent = Message::where('user_id', Auth::user()->id)->where('status','!=',null)->get();
        $email = Message::where('important', '!=', 0)->where('status','!=', null)->where('receiver_id', Auth::user()->id)->get();
        
        return view('chats.email-important', compact('user', 'emails', 'email', 'sent'));
      
    }
    public function create()
    {
        $user = User::where('id','!=', Auth::user()->id)->where('id','!=', 1)->get();
         $emails = Message::where('receiver_id', Auth::user()->id)->where('status','!=',null)->get();
        $sent = Message::where('user_id', Auth::user()->id)->where('status','!=',null)->get();
        $email = Message::where('important', '!=', 0)->where('status','!=', null)->where('receiver_id', Auth::user()->id)->get();
        
        return view('chats.email-compose', compact('user', 'emails', 'email', 'sent'));
    }
    public function store(MessageRequest $request)
    {
 try{
        $var = CarbonCarbon::now()->format('M-Y');
        
      
                   $emails = new Message;
        $emails->id = $request->id;
        $emails->user_id = $request->user_id;
        $emails->receiver_id = $request->receiver_id;
        $emails->subject = $request->subject;
        $emails->important = $request->important;
        $emails->message = $request->message;
        $emails->status = '2';
        
        
        $emails->save();
            
      
    

        $this->createLog([
            'username' => auth()->user()->username,
            'operation' => 'Email Sent',
            'more_info' => 'Email Sent by ' . auth()->user()->name,
            'tenant_id' => '0',
                    'house_id' => '0',
                    'apartment_id' => '0',
                    'landlord_id' => '0',
                    'bill_id' => '0',
                    'invoice_id' => '0',
                    'sms_id' => '0',
                    'user_id' =>  $emails->user_id,
                    'servicerequest_id' => '0',
        ]);

        

        return back()->with('success', 'Email successfully sent');
        }
         catch (\Exception $e) {
         DB::rollback();
         return back()->with('error', 'System error sending email, please contact the system administrator.');
}

    }
    public function storereply(RepliesRequest $request)
    {
//  try{
        
        
                   $emails = new Replies;
        $emails->id = $request->id;
        $emails->user_id = $request->user_id;
        $emails->message_id = $request->message_id;
        
        $emails->reply = $request->reply;
        
        
        $emails->save();
            
        

       if($emails->message->user_id == auth()->user()->id){
        $emails->message->update(['status' => null,]);  
       }
       else
      {
      $emails->message->update(['status' => '1',]);
      }

        $this->createLog([
            'username' => auth()->user()->username,
            'operation' => 'Email Replied',
            'more_info' => 'Reply Sent by ' . auth()->user()->name,
            'tenant_id' => '0',
                    'house_id' => '0',
                    'apartment_id' => '0',
                    'landlord_id' => '0',
                    'bill_id' => '0',
                    'invoice_id' => '0',
                    'sms_id' => '0',
                    'user_id' =>  '1',
                    'servicerequest_id' => '0',
        ]);

        
         return redirect()->route('email.show', [$emails->message_id])
            ->with('success', 'Tenant details has been updated');
        return back()->with('success', 'Reply successfully sent');
//         }
//          catch (\Exception $e) {
//          DB::rollback();
//          return back()->with('error', 'System error sending reply, please contact the system administrator.');
// }

    }
  

    public function show($id)
    {
      
        $emails = Message::findorfail($id);
        $reply = Replies::where('message_id', $id)->get();
        $user = User::pluck('id','name','email');
        $numba = $emails->receiver_id;
        $show = User::where('id', $numba)->first();
        //dd($show->name);
        // $inbox = Message::where('receiver_id', Auth::user()->id)->get();
         $inbox = Message::where('receiver_id', Auth::user()->id)->where('status','!=',null)->get();
        $sent = Message::where('user_id', Auth::user()->id)->where('status','!=',null)->get();
        $email = Message::where('important', '!=', 0)->where('status','!=', null)->where('receiver_id', Auth::user()->id)->get();
        
        // dd($emails->user->name);
       
        return view('chats.email-read', compact('emails',  'user', 'sent', 'email', 'inbox', 'show', 'reply'));

    }
     public function showsent($id)
    {
      
        $emails = Message::findorfail($id);
        $reply = Replies::where('message_id', $id)->get();
        $user = User::pluck('id','name','email');
        
        $numba = $emails->receiver_id;
        $show = User::where('id', $numba)->first();
        //dd($show->name);
         $inbox = Message::where('receiver_id', Auth::user()->id)->where('status','!=',null)->get();
        $sent = Message::where('user_id', Auth::user()->id)->where('status','!=',null)->get();
        $email = Message::where('important', '!=', 0)->where('status','!=', null)->where('receiver_id', Auth::user()->id)->get();
        // dd($emails->user->name);
       
        return view('chats.email-read-sent', compact('emails',  'user', 'sent', 'email', 'inbox', 'show', 'reply'));

    }
    
    public function showreply($id)
    {
      
        $emails = Message::findorfail($id);
        $reply = Replies::where('message_id', $id)->get();
        $numba = $emails->receiver_id;
        // dd($reply->user->id);
        $show = User::where('id', $numba)->first();
        $sender = User::pluck('id','name', 'email');
        
         $inbox = Message::where('receiver_id', Auth::user()->id)->where('status','!=',null)->get();
        $sent = Message::where('user_id', Auth::user()->id)->where('status','!=',null)->get();
        $email = Message::where('important', '!=', 0)->where('status','!=', null)->where('receiver_id', Auth::user()->id)->get();
        // dd($emails->user->name);
       
        return view('chats.email-read-reply', compact('emails',  'reply', 'sent', 'email', 'inbox', 'show','sender'));

    }

    public function edit($id)
    {
        // $landlord = Landlord::findOrFail($id);
        // return view('chats.edit', compact('landlord'));

    }
    public function update(UpdateMessageRequest $request, $id)
    {
//         try{
//         $landlord = Landlord::findOrFail($id);

//         $landlord->id = $request->id;
//         $landlord->full_name = $request->full_name;
//         //$landlord->other_names = $request->other_names;
//         $landlord->email = $request->email;
//         $landlord->landlordid_number = $request->landlordid_number;
//         //$landlord->phone_no = $request->phone_no;
//         $landlord->address = $request->address;
        
//         $files = $request->filenames;
//         if ($files) {
//             $response = $this->uploadFile($files, 'landlordContracts', $landlord->id);
//         }
//         $this->createLog([
//             'username' => auth()->user()->username,
//             'operation' => 'Edited Owner ' . $landlord->full_name,
//             'more_info' => 'Edited Owner with phone:  +' . $landlord->id,
//             'tenant_id' =>  '0',
//             'servicerequest_id' => '0',
//             'house_id' => '0',
//             'apartment_id' => '0',
//             'landlord_id' => $landlord->id,
//             'bill_id' => '0',
//             'invoice_id' => '0',
//             'sms_id' => '0',
//             'user_id' => '0',
//         ]);
//         $landlord->save();

//         return redirect()->route('landlord.show', [$landlord])->with('success', 'Property Owner Details have been updated');
//         }
//         catch (\Exception $e) {
//          DB::rollback();
//          return back()->with('error', 'System error editing owner, please contact the developer.');
// }


    }

   

    public function delete($id)
    {
        // $landlord=Landlord::findOrFail($id);

        // $landlord->delete();

        // return back()->with('success','Property Owner has been deleted from system');
    }
}
