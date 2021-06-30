<?php

namespace App\Http\Controllers;

use App\Exceptions\Handler;
use App\Models\ContactForm;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
// Response

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
            'email' => 'required|email',
            'type' => 'required|in:bidder,auctioneer,other',
        ]);

        if ($validator->fails()) {
            return Response::json(['errors' => $validator->errors()]);
        }

        try{

            // $contact = [
            //     'uuid' => str::uuid(),
            //     'name' => $request->name,
            //     'email' => $request->email,
            //     'type' => $request->type,
            // ];

            // $contact = ContactForm::create($contact);
         
            Mail::send('email_template.contactform', [
                'name' => $request->name,
                'email' => $request->email,
                'message_body' => 'Contact Info'
            ], function ($m) use ($contact) {
                $m->from(config('mail.from.address'), config('mail.from.name'));
                $m->to('info@sellx.ae')->subject('Contact Information');
            });

            return Response::json(['success' => '1']);
        }
        catch(Exception $ex){

            return Response::json(['success' => $e->getMessage()]);
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
