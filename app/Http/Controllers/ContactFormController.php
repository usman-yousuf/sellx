<?php

namespace App\Http\Controllers;

use App\Exceptions\Handler;
use App\Models\ContactForm;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;

class ContactFormController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function contact_form(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'e_mail' => 'required|email',
            'type' => 'required|in:bidding,auctioneer,other',
        ]);

        if ($validator->fails()) {

            $data['validation_error'] = $validator->getMessageBag();
            return sendError($validator->errors()->all()[0], $data);
        }

        if(ContactForm::where('email',$request->e_mail)->first()){

            return sendError('already in from',[]);
        }

        try{

            $contact = [
                'uuid' => str::uuid(),
                'name' => $request->name,
                'email' => $request->e_mail,
                'type' => $request->type,
            ];

            $contact = ContactForm::create($contact);

            Mail::send('email_template.contactform', [
                'name' => $request->name,
                'email' => $request->e_mail,
                'message_body' => 'Contact Info'
            ], function ($m) use ($contact) {
                $m->from(config('mail.from.address'), config('mail.from.name'));
                $m->to(config('mail.from.address'))->subject('ContactInformation');
            });

            return sendSuccess('Saved',$contact);
        }
        catch(Exception $ex){

            $data['exception_error'] = $e->getMessage();
            return sendError('There is some problem.', $data);
        }

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ContactForm  $contactForm
     * @return \Illuminate\Http\Response
     */
    public function show(ContactForm $contactForm)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ContactForm  $contactForm
     * @return \Illuminate\Http\Response
     */
    public function edit(ContactForm $contactForm)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ContactForm  $contactForm
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ContactForm $contactForm)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ContactForm  $contactForm
     * @return \Illuminate\Http\Response
     */
    public function destroy(ContactForm $contactForm)
    {
        //
    }
}
