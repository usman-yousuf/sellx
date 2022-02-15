@extends('noauthapp')

@section('content')
<div class="for_overflow">
  <div class="container">
      <div class="row for_about_main_row">
          <div class="col-lg-3 col-md-4 col-sm-12 for_col_afterr right_border order-lg-1 order-md-1 order-2">
            <a href="{{ route('termsandcondition') }}">{{ __('Terms and Conditions') }}</a>
            <br>
            <a href="{{ route('privacypolicy') }}">{{ __('Privacy & Data Policy')}}</a>
            <br>
            <a href="{{ route('refundandcancelation') }}">{{ __('Refunds and Cancellations') }}</a>
            <br>
            <a href="{{ route('servicedeliverypolicy') }}">{{ __('Service Delivery Policy')}}</a>
            <br>
            <a href="{{ route('servicepricing') }}">{{ __('Service Pricing') }}</a>
            <br>
            <a href="{{ route('partnersterms') }}" class="">{{ __('Partners Terms')}}</a>
          <br>
          <hr class="for_partners_bottom">

          <div>
              <a href="{{route('contact')}}" class="">{{ __('Contact us') }}</a>
            

              {{-- <a href="{{route('contact')}}" class="">{{ __('Comming Soon') }}</a> --}}
              <br>
              {{-- <a href="{{route('about')}}" class="">{{ __('Comming Soon') }}</a> --}}
          </div>
      </div>
        <div class="col-lg-9 col-md-8 col-sm-12 order-lg-2 order-md-2 order-1">
          <p><strong><span>PRIVACY NOTICE&nbsp;</span></strong></p>
          <p><strong><span>Last updated January 01, 2022&nbsp;</span></strong></p>
          <p><span>Thank you for choosing to be part of our community at ALMUSTAQBAL INFORMATION TECHNOLOGY, doing business as SELLX (&quot;<strong>SELLX</strong>,&quot; &quot;<strong>we</strong>,&quot; &quot;<strong>us</strong>,&quot; or &quot;<strong>our</strong>&quot;). We are committed to protecting your personal information and your right to privacy. If you have any questions or concerns about this privacy notice or our practices with regard to your personal information, please contact us at info@sellx.ae.&nbsp;</span></p>
          <p><span>This privacy notice describes how we might use your information if you:&nbsp;</span></p>
          <p><span>Visit our website at http://www.sellx.ae&nbsp;</span></p>
          <p><span>&nbsp;</span></p>
          <p><span>Download and use our mobile application &mdash; Sellx&nbsp;</span></p>
          <p><span>&nbsp;</span></p>
          <p><span>Engage with us in other related ways ― including any sales, marketing, or events&nbsp;</span></p>
          <p><span>&nbsp;</span></p>
          <p><span>In this privacy notice, if we refer to:&nbsp;</span></p>
          <p><span>&quot;<strong>Website</strong>,&quot; we are referring to any website of ours that references or links to this policy&nbsp;</span></p>
          <p><span>&nbsp;</span></p>
          <p><span>&quot;<strong>App</strong>,&quot; we are referring to any application of ours that references or links to this policy, including any listed above&nbsp;</span></p>
          <p>&nbsp;</p>
          <p>&nbsp;</p>
          <p><span>&quot;<strong>Services</strong>,&quot; we are referring to our Website, App, and other related services, including any sales, marketing, or events</span></p>
          <p><span>&nbsp;</span></p>
          <p><span>The purpose of this privacy notice is to explain to you in the clearest way possible what information we collect, how we use it, and what rights you have in relation to it.If there are any terms in this privacy notice that you do not agree with, please discontinue use of our Services immediately.</span></p>
          <p><strong><span>Please read this privacy notice carefully, as it will help you understand what we do with the information that we collect.</span></strong></p>
          <p><strong><span style="font-size:15px;">TABLE OF CONTENTS</span></strong></p>
          <p><span>1. WHAT INFORMATION DO WE COLLECT?</span></p>
          <p><span>2. HOW DO WE USE YOUR INFORMATION?</span></p>
          <p><span>3. WILL YOUR INFORMATION BE SHARED WITH ANYONE?</span></p>
          <p><span>4. DO WE USE COOKIES AND OTHER TRACKING TECHNOLOGIES?</span></p>
          <p><span>5. HOW DO WE HANDLE YOUR SOCIAL LOGINS?</span></p>
          <p><span>6. HOW LONG DO WE KEEP YOUR INFORMATION?</span></p>
          <p><span>7. HOW DO WE KEEP YOUR INFORMATION SAFE?</span></p>
          <p><span>8. WHAT ARE YOUR PRIVACY RIGHTS?</span></p>
          <p><span>9. CONTROLS FOR DO-NOT-TRACK FEATURES</span></p>
          <p><span>10. DO CALIFORNIA RESIDENTS HAVE SPECIFIC PRIVACY RIGHTS?</span></p>
          <p><span>11. DO WE MAKE UPDATES TO THIS NOTICE?</span></p>
          <p><span>12. HOW CAN YOU CONTACT US ABOUT THIS NOTICE?</span></p>
          <p><span>13. HOW CAN YOU REVIEW, UPDATE OR DELETE THE DATA WE COLLECTFROM YOU?</span></p>
          <p><span>&nbsp;</span></p>
          <p><strong><span style="font-size:15px;">1. WHAT INFORMATION DO WE COLLECT?</span></strong></p>
          <p><strong><span style="font-size:14px;">Personal information you disclose to us</span></strong></p>
          <p><strong><em><span>In Short:&nbsp;</span></em></strong><em><span>We collect personal information that you provide to us.</span></em></p>
          <p><span>We collect personal information that you voluntarily provide to us when you register on the Services, express an interest in obtaining information about us or our products and Services, when you participate in activities on the Services (such as by posting messages in our online forums or entering competitions, contests or giveaways) or otherwise when you contact us.</span></p>
          <p style='margin:0cm;margin-bottom:.0001pt;font-size:16px;font-family:"Calibri",sans-serif;'><span>The personal information that we collect depends on the context of your interactions with us and the Services, the choices you make and the products and features you use. The personal information we collect may include the following:</span></p>
          <p>&nbsp;</p>
          <p>&nbsp;</p>
          <p><strong><span>Personal Information Provided by You.&nbsp;</span></strong><span>We collect names; phone numbers; email addresses; mailing addresses; usernames; passwords; billing addresses; debit/credit card numbers; and other similar information.</span></p>
          <p><strong><span>Payment Data.&nbsp;</span></strong><span>We may collect data necessary to process your payment if you make purchases, such as your payment instrument number (such as a credit card number), and the security code associated with your payment instrument. All payment data is stored by Stripe. You may find their privacy notice link(s) here: http://www.stripe.com.</span></p>
          <p><strong><span>Social Media Login Data.&nbsp;</span></strong><span>We may provide you with the option to register with us using your existing social media account details, like your Facebook, Twitter or other social media account. If you choose to register in this way, we will collect the information described in the section called &quot;HOW DO WE HANDLE YOUR SOCIALLOGINS?&quot; below.</span></p>
          <p><span>All personal information that you provide to us must be true, complete and accurate, and you must notify us of any changes to such personal information.</span></p>
          <p><strong><span style="font-size:14px;">Information automatically collected</span></strong></p>
          <p><strong><em><span>In Short:&nbsp;</span></em></strong><em><span>Some information &mdash; such as your Internet Protocol (IP) address and/or browser and device characteristics &mdash; is collected automatically when you visit our Services.</span></em></p>
          <p><span>We automatically collect certain information when you visit, use or navigate the Services. This information does not reveal your specific identity (like your name or contact information) but may include device and usage information, such as your iPad dress, browser and device characteristics, operating system, language preferences, referring URLs, device name, country, location, information about how and when you use our Services and other technical information. This information is primarily needed to maintain the security and operation of our Services, and for our internal analytics and reporting purposes.</span></p>
          <p><span>Like many businesses, we also collect information through cookies and similar technologies.</span></p>
          <p><span>The information we collect includes:</span></p>
          <p><em><span>Log and Usage Data.&nbsp;</span></em><span>Log and usage data are service-related, diagnostic, usage and performance information our servers automatically collect when you access or use our Services and which we record in log files. Depending on how you interact with us, this log data may include your IP address, device information, browser type and settings and information about your activity in the Services (such as the date/time stamps associated with your usage, pages and files viewed, searches and other actions you take such as which features you use), device event information (such as system activity, error reports(sometimes called &apos;crash dumps&apos;) and hardware settings).</span></p>
          <p><span>&nbsp;</span></p>
          <p><em><span>Device Data.&nbsp;</span></em><span>We collect device data such as information about your computer, phone, tablet or other device you use to access the Services. Depending on the device used, this device data may include information such as your iPad dress (or proxy server), device and application identification numbers, location, browser type, hardware model Internet service provider and/or mobile carrier, operating system and system configuration information.</span></p>
          <p><span>&nbsp;</span></p>
          <p><strong><span style="font-size:14px;">Information collected through our App</span></strong></p>
          <p><strong><em><span>In Short:&nbsp;</span></em></strong><em><span>We collect information regarding your mobile device, push notifications, when you use our App.&nbsp;</span></em><span>If you use our App, we also collect the following information:</span></p>
          <p><em><span>Mobile Device Access.&nbsp;</span></em><span>We may request access or permission to certain features from your mobile device, including your mobile device&apos;s camera, contacts, microphone, SMS messages, and other features. If you wish to change our access or permissions, you may do so in your device&apos;s settings.</span></p>
          <p><span>&nbsp;</span></p>
          <p><em><span>Push Notifications.&nbsp;</span></em><span>We may request to send you push notifications regarding your account or certain features of the App. If you wish to opt-out from receiving these types of communications, you may turn them off in your device&rsquo;s settings.</span></p>
          <p><span>&nbsp;</span></p>
          <p><span>This information is primarily needed to maintain the security and operation of outraps, for troubleshooting and for our internal analytics and reporting purposes.</span></p>
          <p><span>&nbsp;</span></p>
          <p><strong><span style="font-size:15px;">2. HOW DO WE USE YOUR INFORMATION?</span></strong></p>
          <p><strong><em><span>In Short:&nbsp;</span></em></strong><em><span>We process your information for purposes based on legitimate business interests, the fulfillment of our contract with you, compliance with our legal obligations, and/or your consent.</span></em></p>
          <p><span>We use personal information collected via our Services for a variety of business purposes described below. We process your personal information for this purpose sin reliance on our legitimate business interests, in order to enter into or perform a contract with you, with your consent, and/or for compliance with our legal obligations. We indicate the specific processing grounds we rely on next to each purpose listed below.</span></p>
          <p><span>We use the information we collect or receive:</span>&nbsp;</p>
          <p>&nbsp;</p>
          <p><strong><span>To facilitate account creation and logon process.&nbsp;</span></strong><span>If you choose to link your account with us to a third-party account (such as your Google or Facebook account), we use the information you allowed us to collect from those third parties to facilitate account creation and logon process for the performance of the contract. See the section below headed &quot;HOW DO WE HANDLE YOURSOCIAL LOGINS?&quot; for further information.</span></p>
          <p><span>&nbsp;</span></p>
          <p><strong><span>To post testimonials.&nbsp;</span></strong><span>We post testimonials on our Services that may contain personal information. Prior to posting a testimonial, we will obtain your consent to use your name and the content of the testimonial. If you wish to update, or delete your testimonial, please contact us at info@sellx.ae and be sure to include your name, testimonial location, and contact information.</span></p>
          <p><span>&nbsp;</span></p>
          <p><strong><span>Request feedback.&nbsp;</span></strong><span>We may use your information to request feedback and to contact you about your use of our Services.</span></p>
          <p><span>&nbsp;</span></p>
          <p><strong><span>To enable user-to-user communications.&nbsp;</span></strong><span>We may use your information in order to enable user-to-user communications with each user&apos;s consent.</span></p>
          <p><span>&nbsp;</span></p>
          <p><strong><span>To manage user accounts.&nbsp;</span></strong><span>We may use your information for the purposes of managing our account and keeping it in working order.</span></p>
          <p><span>&nbsp;</span></p>
          <p><strong><span>To send administrative information to you.&nbsp;</span></strong><span>We may use your personal information to send you product, service and new feature information and/or information about changes to our terms, conditions, and policies.</span></p>
          <p><span>&nbsp;</span></p>
          <p><strong><span>To protect our Services.&nbsp;</span></strong><span>We may use your information as part of our efforts to keep our Services safe and secure (for example, for fraud monitoring and prevention).</span></p>
          <p><span>&nbsp;</span></p>
          <p><strong><span>To enforce our terms, conditions and policies for business purposes, to comply with legal and regulatory requirements or in connection with our contract.</span></strong></p>
          <p><span>&nbsp;</span></p>
          <p><strong><span>To respond to legal requests and prevent harm.&nbsp;</span></strong><span>If we receive a subpoena or other legal request, we may need to inspect the data we hold to determine how to respond.</span></p>
          <p><span>&nbsp;</span></p>
          <p><strong><span>To send you marketing and promotional communications.&nbsp;</span></strong><span>We and/or our third-party marketing partners may use the personal information you send to us for our marketing purposes, if this is in accordance with your marketing preferences. For example, when expressing an interest in obtaining information about us or our Services, subscribing to marketing or otherwise contacting us, we will collect personal information from you. You can opt-out of our marketing emails at any time (see the &quot;WHAT ARE YOUR PRIVACYRIGHTS?&quot; below).</span></p>
          <p>&nbsp;</p>
          <p><strong><span>Deliver targeted advertising to you.&nbsp;</span></strong><span>We may use your information to develop and display personalized content and advertising (and work with third parties who do so) tailored to your interests and/or location and to measure its effectiveness.</span></p>
          <p><span>&nbsp;</span></p>
          <p><span>&nbsp;</span></p>
          <p><strong><span style="font-size:15px;">3. WILL YOUR INFORMATION BE SHARED WITHANYONE?</span></strong></p>
          <p><strong><em><span>In Short:&nbsp;</span></em></strong><em><span>We only share information with your consent, to comply with laws, to provide you with services, to protect your rights, or to fulfill business obligations.</span></em></p>
          <p><span>We may process or share your data that we hold based on the following legal basis:</span></p>
          <p><strong><span>Consent:&nbsp;</span></strong><span>We may process your data if you have given us specific consent tousle your personal information for a specific purpose.</span></p>
          <p><span>&nbsp;</span></p>
          <p><strong><span>Legitimate Interests:&nbsp;</span></strong><span>We may process your data when it is reasonably necessary to achieve our legitimate business interests.</span></p>
          <p><span>&nbsp;</span></p>
          <p><strong><span>Performance of a Contract:&nbsp;</span></strong><span>Where we have entered into a contract with you, we may process your personal information to fulfill the terms of our contract.</span></p>
          <p><span>&nbsp;</span></p>
          <p><strong><span>Legal Obligations:&nbsp;</span></strong><span>We may disclose your information where we are legally required to do so in order to comply with applicable law, governmental requests, a judicial proceeding, court order, or legal process, such as in response to a court order or a subpoena (including in response to public authorities to meet national security or law enforcement requirements).</span></p>
          <p><span>&nbsp;</span></p>
          <p><strong><span>Vital Interests:&nbsp;</span></strong><span>We may disclose your information where we believe it is necessary to investigate, prevent, or take action regarding potential violations of our policies, suspected fraud, situations involving potential threats to the safety of any person and illegal activities, or as evidence in litigation in which we are involved.</span></p>
          <p><span>&nbsp;</span></p>
          <p><span>More specifically, we may need to process your data or share your personal information in the following situations:</span></p>
          <p><strong><span>Business Transfers.&nbsp;</span></strong><span>We may share or transfer your information in connection with, or during negotiations of, any merger, sale of company assets, financing, or acquisition of all or a portion of our business to another company.</span></p>
          <p><span>&nbsp;</span></p>
          <p><strong><span>Business Partners.&nbsp;</span></strong><span>We may share your information with our business partners to offer you certain products, services or promotions.</span></p>
          <p>&nbsp;</p>
          <p><strong><span style="font-size:15px;">4. DO WE USE COOKIES AND OTHER TRACKINGTECHNOLOGIES?</span></strong></p>
          <p><strong><em><span>In Short:&nbsp;</span></em></strong><em><span>We may use cookies and other tracking technologies to collect and store your information.</span></em></p>
          <p><span>We may use cookies and similar tracking technologies (like web beacons and pixels) to access or store information. Specific information about how we use such technologies and how you can refuse certain cookies is set out in our Cookie Notice.</span></p>
          <p><span>&nbsp;</span></p>
          <p><strong><span style="font-size:15px;">5. HOW DO WE HANDLE YOUR SOCIAL LOGINS?&nbsp;</span></strong></p>
          <p><strong><em><span>In Short:&nbsp;</span></em></strong><em><span>If you choose to register or log in to our services using a social media account, we may have access to certain information about you.</span></em></p>
          <p><span>Our Services offers you the ability to register and login using your third-party social media account details (like your Facebook or Twitter logins). Where you choose to do this, we will receive certain profile information about you from your social media provider. The profile information we receive may vary depending on the social media provider concerned, but will often include your name, email address, friends list, profile picture as well as other information you choose to make public on such social media platform.</span></p>
          <p><span>We will use the information we receive only for the purposes that are described in this privacy notice or that are otherwise made clear to you on the relevant Services. Please note that we do not control, and are not responsible for, other uses of your personal information by your third-party social media provider. We recommend that you review their privacy notice to understand how they collect, use and share your personal information, and how you can set your privacy preferences on their site sand apps.</span></p>
          <p><span>&nbsp;</span></p>
          <p><strong><span style="font-size:15px;">6. HOW LONG DO WE KEEP YOUR INFORMATION?</span></strong></p>
          <p><strong><em><span>In Short:&nbsp;</span></em></strong><em><span>We keep your information for as long as necessary to fulfill the purposes outlined in this privacy notice unless otherwise required by law.</span></em></p>
          <p style='margin:0cm;margin-bottom:.0001pt;font-size:16px;font-family:"Calibri",sans-serif;'><span>We will only keep your personal information for as long as it is necessary for the purposes set out in this privacy notice, unless a longer retention period is required or permitted by law (such as tax, accounting or other legal requirements). No purpose in this notice will require us keeping your personal information for longer than the period of time in which users have an account with us.</span></p>
          <p><span>When we have no ongoing legitimate business need to process your personal information, we will either delete or anonymize such information, or, if this is not possible (for example, because your personal information has been stored in backup archives), then we will securely store your personal information and isolate it from any further processing until deletion is possible.</span></p>
          <p><span>&nbsp;</span></p>
          <p><strong><span style="font-size:15px;">7. HOW DO WE KEEP YOUR INFORMATION SAFE?</span></strong></p>
          <p><strong><em><span>In Short:&nbsp;</span></em></strong><em><span>We aim to protect your personal information through a system of organizational and technical security measures.</span></em></p>
          <p><span>We have implemented appropriate technical and organizational security measures designed to protect the security of any personal information we process. However, despite our safeguards and efforts to secure your information, no electronic transmission over the Internet or information storage technology can be guaranteed to be 100% secure, so we cannot promise or guarantee that hackers, cybercriminals, or other unauthorized third parties will not be able to defeat our security, and improperly collect, access, steal, or modify your information. Although we will do our best to protect your personal information, transmission of personal information to and from our Services is at your own risk. You should only access the Services within a secure environment.</span></p>
          <p><span>&nbsp;</span></p>
          <p><strong><span style="font-size:15px;">8. WHAT ARE YOUR PRIVACY RIGHTS?</span></strong></p>
          <p><strong><em><span>In Short:&nbsp;</span></em></strong><em><span>In some regions, such as the European Economic Area (EEA) and United Kingdom (UK), you have rights that allow you greater access to and control over your personal information. You may review, change, or terminate your account at any time.</span></em></p>
          <p><span>In some regions (like the EEA and UK), you have certain rights under applicable data protection laws. These may include the right (i) to request access and obtain a copy of your personal information, (ii) to request rectification or erasure; (iii) to restrict the processing of your personal information; and (iv) if applicable, to data portability. In certain circumstances, you may also have the right to object to the processing of your personal information. To make such a request, please use the contact details provided below. We will consider and act upon any request in accordance with applicable data protection laws.</span></p>
          <p style='margin:0cm;margin-bottom:.0001pt;font-size:16px;font-family:"Calibri",sans-serif;'><span>If we are relying on your consent to process your personal information, you have the right to withdraw your consent at any time. Please note however that this will not affect the lawfulness of the processing before its withdrawal, nor will it affect the processing of your personal information conducted in reliance on lawful processing grounds other than consent.</span></p>
          <p>&nbsp;</p>
          <p><span>If you are a resident in the EEA or UK and you believe we are unlawfully processing your personal information, you also have the right to complain to your local data protection supervisory authority. You can find their contact details here: https://ec.europa.eu/justice/data-protection/bodies/authorities/index_en.htm.</span></p>
          <p><span>If you are a resident in Switzerland, the contact details for the data protection authorities are available here: https://www.edoeb.admin.ch/edoeb/en/home.html.</span></p>
          <p><span>If you have questions or comments about your privacy rights, you may email us atinfo@sellx.ae.</span></p>
          <p><strong><span style="font-size:14px;">Account Information</span></strong></p>
          <p><span>If you would at any time like to review or change the information in your account or terminate your account, you can:</span></p>
          <p><span>Contact us using the contact information provided.</span></p>
          <p><span>&nbsp;</span></p>
          <p><span>Upon your request to terminate your account, we will deactivate or delete your account and information from our active databases. However, we may retain some information in our files to prevent fraud, troubleshoot problems, assist with any investigations, enforce our Terms of Use and/or comply with applicable legal requirements.</span></p>
          <p><strong><span>Cookies and similar technologies:&nbsp;</span></strong><span>Most Web browsers are set to accept cookies by default. If you prefer, you can usually choose to set your browser to remove cookies and to reject cookies. If you choose to remove cookies or reject cookies, this could affect certain features or services of our Services. To opt-out of interest-based advertising by advertisers on our Services visit http://www.aboutads.info/choices/.</span></p>
          <p><strong><span>Opting out of email marketing:&nbsp;</span></strong><span>You can unsubscribe from our marketing email list at any time by clicking on the unsubscribe link in the emails that we send or by contacting us using the details provided below. You will then be removed from the marketing email list &mdash; however, we may still communicate with you, for example to send you service-related emails that are necessary for the administration and use of your account, to respond to service requests, or for other non-marketing purposes. To otherwise opt-out, you may:</span></p>
          <p><span>Contact us using the contact information provided.</span></p>
          <p><span>&nbsp;</span></p>
          <p><span>Access your account settings and update your preferences.</span></p>
          <p><span>&nbsp;</span></p>
          <p><span>&nbsp;</span></p>
          <p style='margin:0cm;margin-bottom:.0001pt;font-size:16px;font-family:"Calibri",sans-serif;'><strong><span style="font-size:15px;">9. CONTROLS FOR DO-NOT-TRACK FEATURES</span></strong></p>
          <p>&nbsp;</p>
          <p><span>Most web browsers and some mobile operating systems and mobile applications include a Do-Not-Track (&quot;DNT&quot;) feature or setting you can activate to signal your privacy preference not to have data about your online browsing activities monitored and collected. At this stage no uniform technology standard for recognizing and implementing DNT signals has been finalized. As such, we do not currently respond to DNT browser signals or any other mechanism that automatically communicates your choice not to be tracked online. If a standard for online tracking is adopted that we must follow in the future, we will inform you about that practice in a revised version of this privacy notice.&nbsp;</span></p>
          <p><span>&nbsp;</span></p>
          <p><strong><span style="font-size:15px;">10. DO CALIFORNIA RESIDENTS HAVE SPECIFICPRIVACY RIGHTS?</span></strong></p>
          <p><strong><em><span>In Short:&nbsp;</span></em></strong><em><span>Yes, if you are a resident of California, you are granted specific rights regarding access to your personal information.</span></em></p>
          <p><span>California Civil Code Section 1798.83, also known as the &quot;Shine The Light&quot; law, permits our users who are California residents to request and obtain from us, once a year and free of charge, information about categories of personal information (if any)we disclosed to third parties for direct marketing purposes and the names and addresses of all third parties with which we shared personal information in the immediately preceding calendar year. If you are a California resident and would like to make such a request, please submit your request in writing to us using the contact information provided below.</span></p>
          <p><span>If you are under 18 years of age, reside in California, and have a registered account with a Service, you have the right to request removal of unwanted data that you publicly post on the Services. To request removal of such data, please contact us using the contact information provided below, and include the email address associated with your account and a statement that you reside in California. We will make sure the data is not publicly displayed on the Services, but please be aware that the data may not be completely or comprehensively removed from all our systems (e.g. backups, etc.).</span></p>
          <p><strong><span style="font-size:14px;">CCPA Privacy Notice</span></strong></p>
          <p><span>The California Code of Regulations defines a &quot;resident&quot; as:</span></p>
          <p><span>(1) every individual who is in the State of California for other than a temporary or transitory purpose and</span></p>
          <p style='margin:0cm;margin-bottom:.0001pt;font-size:16px;font-family:"Calibri",sans-serif;'><span>(2) every individual who is domiciled in the State of California who is outside testate of California for a temporary or transitory purpose</span></p>
          <p>&nbsp;</p>
          <p><span>All other individuals are defined as &quot;non-residents.&quot;</span></p>
          <p><span>If this definition of &quot;resident&quot; applies to you, we must adhere to certain rights and obligations regarding your personal information.</span></p>
          <p><strong><span>What categories of personal information do we collect?</span></strong></p>
          <table style="margin-left:-5.4pt;border-collapse:collapse;border:none;">
              <tbody>
                  <tr>
                      <td colspan="2" style="width: 180.9pt;border: 1pt solid windowtext;padding: 0cm 5.4pt;height: 6pt;vertical-align: top;">
                          <p><span>We have collected the following categories of personal information in the past twelve(12) months:<strong>&nbsp;Category</strong></span></p>
                      </td>
                      <td colspan="2" style="width: 247.5pt;border-top: 1pt solid windowtext;border-right: 1pt solid windowtext;border-bottom: 1pt solid windowtext;border-image: initial;border-left: none;padding: 0cm 5.4pt;height: 6pt;vertical-align: top;">
                          <p><strong><span>Examples</span></strong></p>
                      </td>
                      <td colspan="2" style="width: 67.5pt;border-top: 1pt solid windowtext;border-right: 1pt solid windowtext;border-bottom: 1pt solid windowtext;border-image: initial;border-left: none;padding: 0cm 5.4pt;height: 6pt;vertical-align: top;">
                          <p><strong><span>Collected</span></strong></p>
                      </td>
                      <td style="border:none;padding:0cm 0cm 0cm 0cm;">
                          <p style='margin:0cm;margin-bottom:.0001pt;font-size:16px;font-family:"Calibri",sans-serif;'>&nbsp;</p>
                      </td>
                  </tr>
                  <tr>
                      <td colspan="2" style="width: 180.9pt;border-right: 1pt solid windowtext;border-bottom: 1pt solid windowtext;border-left: 1pt solid windowtext;border-image: initial;border-top: none;padding: 0cm 5.4pt;height: 33.6pt;vertical-align: top;">
                          <p><span>A. Identifiers</span></p>
                      </td>
                      <td colspan="2" style="width: 247.5pt;border-top: none;border-left: none;border-bottom: 1pt solid windowtext;border-right: 1pt solid windowtext;padding: 0cm 5.4pt;height: 33.6pt;vertical-align: top;">
                          <p><span>Contact details, such as real name, alias, postal address, telephone or mobile contact number, unique personal identifier, online identifier, Internet Protocol address, email address and account name</span></p>
                      </td>
                      <td colspan="2" style="width: 67.5pt;border-top: none;border-left: none;border-bottom: 1pt solid windowtext;border-right: 1pt solid windowtext;padding: 0cm 5.4pt;height: 33.6pt;vertical-align: top;">
                          <p><span>NO</span></p>
                      </td>
                      <td style="border:none;padding:0cm 0cm 0cm 0cm;">
                          <p style='margin:0cm;margin-bottom:.0001pt;font-size:16px;font-family:"Calibri",sans-serif;'>&nbsp;</p>
                      </td>
                  </tr>
                  <tr>
                      <td colspan="2" style="width: 180.9pt;border-right: 1pt solid windowtext;border-bottom: 1pt solid windowtext;border-left: 1pt solid windowtext;border-image: initial;border-top: none;padding: 0cm 5.4pt;height: 26.8pt;vertical-align: top;">
                          <p><span>B. Personal information categories listed in the California Customer Records statute</span></p>
                      </td>
                      <td colspan="2" style="width: 247.5pt;border-top: none;border-left: none;border-bottom: 1pt solid windowtext;border-right: 1pt solid windowtext;padding: 0cm 5.4pt;height: 26.8pt;vertical-align: top;">
                          <p><span>Name, contact information, education, employment, employment history and financial information</span></p>
                      </td>
                      <td colspan="2" style="width: 67.5pt;border-top: none;border-left: none;border-bottom: 1pt solid windowtext;border-right: 1pt solid windowtext;padding: 0cm 5.4pt;height: 26.8pt;vertical-align: top;">
                          <p><span>YES</span></p>
                      </td>
                      <td style="border:none;padding:0cm 0cm 0cm 0cm;">
                          <p style='margin:0cm;margin-bottom:.0001pt;font-size:16px;font-family:"Calibri",sans-serif;'>&nbsp;</p>
                      </td>
                  </tr>
                  <tr>
                      <td colspan="2" style="width: 180.9pt;border-right: 1pt solid windowtext;border-bottom: 1pt solid windowtext;border-left: 1pt solid windowtext;border-image: initial;border-top: none;padding: 0cm 5.4pt;height: 19.65pt;vertical-align: top;">
                          <p><span>C. Protected classification characteristics under California or federal law</span></p>
                      </td>
                      <td colspan="2" style="width: 247.5pt;border-top: none;border-left: none;border-bottom: 1pt solid windowtext;border-right: 1pt solid windowtext;padding: 0cm 5.4pt;height: 19.65pt;vertical-align: top;">
                          <p><span>Gender and date of birth</span></p>
                      </td>
                      <td colspan="2" style="width: 67.5pt;border-top: none;border-left: none;border-bottom: 1pt solid windowtext;border-right: 1pt solid windowtext;padding: 0cm 5.4pt;height: 19.65pt;vertical-align: top;">
                          <p><span>NO</span></p>
                      </td>
                      <td style="border:none;padding:0cm 0cm 0cm 0cm;">
                          <p style='margin:0cm;margin-bottom:.0001pt;font-size:16px;font-family:"Calibri",sans-serif;'>&nbsp;</p>
                      </td>
                  </tr>
                  <tr>
                      <td colspan="2" style="width: 180.9pt;border-right: 1pt solid windowtext;border-bottom: 1pt solid windowtext;border-left: 1pt solid windowtext;border-image: initial;border-top: none;padding: 0cm 5.4pt;height: 12.85pt;vertical-align: top;">
                          <p><span>D. Commercial information</span></p>
                      </td>
                      <td colspan="2" style="width: 247.5pt;border-top: none;border-left: none;border-bottom: 1pt solid windowtext;border-right: 1pt solid windowtext;padding: 0cm 5.4pt;height: 12.85pt;vertical-align: top;">
                          <p><span>Transaction information, purchase history, financial details and payment information</span></p>
                      </td>
                      <td colspan="2" style="width: 67.5pt;border-top: none;border-left: none;border-bottom: 1pt solid windowtext;border-right: 1pt solid windowtext;padding: 0cm 5.4pt;height: 12.85pt;vertical-align: top;">
                          <p><span>YES</span></p>
                      </td>
                      <td style="border:none;padding:0cm 0cm 0cm 0cm;">
                          <p style='margin:0cm;margin-bottom:.0001pt;font-size:16px;font-family:"Calibri",sans-serif;'>&nbsp;</p>
                      </td>
                  </tr>
                  <tr>
                      <td colspan="2" style="width: 180.9pt;border-right: 1pt solid windowtext;border-bottom: 1pt solid windowtext;border-left: 1pt solid windowtext;border-image: initial;border-top: none;padding: 0cm 5.4pt;height: 5.75pt;vertical-align: top;">
                          <p><span>E. Biometric information</span></p>
                      </td>
                      <td colspan="2" style="width: 247.5pt;border-top: none;border-left: none;border-bottom: 1pt solid windowtext;border-right: 1pt solid windowtext;padding: 0cm 5.4pt;height: 5.75pt;vertical-align: top;">
                          <p><span>Fingerprints and voiceprints</span></p>
                      </td>
                      <td colspan="2" style="width: 67.5pt;border-top: none;border-left: none;border-bottom: 1pt solid windowtext;border-right: 1pt solid windowtext;padding: 0cm 5.4pt;height: 5.75pt;vertical-align: top;">
                          <p><span>NO</span></p>
                      </td>
                      <td style="border:none;padding:0cm 0cm 0cm 0cm;">
                          <p style='margin:0cm;margin-bottom:.0001pt;font-size:16px;font-family:"Calibri",sans-serif;'>&nbsp;</p>
                      </td>
                  </tr>
                  <tr>
                      <td colspan="2" style="width: 180.9pt;border-right: 1pt solid windowtext;border-bottom: 1pt solid windowtext;border-left: 1pt solid windowtext;border-image: initial;border-top: none;padding: 0cm 5.4pt;height: 26.8pt;vertical-align: top;">
                          <p><span>F. Internet or another similar network activity</span></p>
                      </td>
                      <td colspan="2" style="width: 247.5pt;border-top: none;border-left: none;border-bottom: 1pt solid windowtext;border-right: 1pt solid windowtext;padding: 0cm 5.4pt;height: 26.8pt;vertical-align: top;">
                          <p><span>Browsing history, search history, online behavior, interest data, and interactions with our and other websites, applications, systems and advertisements</span></p>
                      </td>
                      <td colspan="2" style="width: 67.5pt;border-top: none;border-left: none;border-bottom: 1pt solid windowtext;border-right: 1pt solid windowtext;padding: 0cm 5.4pt;height: 26.8pt;vertical-align: top;">
                          <p><span>NO</span></p>
                      </td>
                      <td style="border:none;padding:0cm 0cm 0cm 0cm;">
                          <p style='margin:0cm;margin-bottom:.0001pt;font-size:16px;font-family:"Calibri",sans-serif;'>&nbsp;</p>
                      </td>
                  </tr>
                  <tr>
                      <td colspan="2" style="width: 180.9pt;border-right: 1pt solid windowtext;border-bottom: 1pt solid windowtext;border-left: 1pt solid windowtext;border-image: initial;border-top: none;padding: 0cm 5.4pt;height: 5.75pt;vertical-align: top;">
                          <p><span>G. Geolocation data</span></p>
                      </td>
                      <td colspan="2" style="width: 247.5pt;border-top: none;border-left: none;border-bottom: 1pt solid windowtext;border-right: 1pt solid windowtext;padding: 0cm 5.4pt;height: 5.75pt;vertical-align: top;">
                          <p><span>Device location</span></p>
                      </td>
                      <td colspan="2" style="width: 67.5pt;border-top: none;border-left: none;border-bottom: 1pt solid windowtext;border-right: 1pt solid windowtext;padding: 0cm 5.4pt;height: 5.75pt;vertical-align: top;">
                          <p><span>YES</span></p>
                      </td>
                      <td style="border:none;padding:0cm 0cm 0cm 0cm;">
                          <p style='margin:0cm;margin-bottom:.0001pt;font-size:16px;font-family:"Calibri",sans-serif;'>&nbsp;</p>
                      </td>
                  </tr>
                  <tr>
                      <td colspan="2" style="width: 180.9pt;border-right: 1pt solid windowtext;border-bottom: 1pt solid windowtext;border-left: 1pt solid windowtext;border-image: initial;border-top: none;padding: 0cm 5.4pt;height: 19.65pt;vertical-align: top;">
                          <p><span>H. Audio, electronic, visual, thermal, olfactory, or similar information</span></p>
                      </td>
                      <td colspan="2" style="width: 247.5pt;border-top: none;border-left: none;border-bottom: 1pt solid windowtext;border-right: 1pt solid windowtext;padding: 0cm 5.4pt;height: 19.65pt;vertical-align: top;">
                          <p><span>Images and audio, video or call recordings created in connection with our business activities</span></p>
                      </td>
                      <td colspan="2" style="width: 67.5pt;border-top: none;border-left: none;border-bottom: 1pt solid windowtext;border-right: 1pt solid windowtext;padding: 0cm 5.4pt;height: 19.65pt;vertical-align: top;">
                          <p><span>NO</span></p>
                      </td>
                      <td style="border:none;padding:0cm 0cm 0cm 0cm;">
                          <p style='margin:0cm;margin-bottom:.0001pt;font-size:16px;font-family:"Calibri",sans-serif;'>&nbsp;</p>
                      </td>
                  </tr>
                  <tr>
                      <td colspan="2" style="width: 180.9pt;border-right: 1pt solid windowtext;border-bottom: 1pt solid windowtext;border-left: 1pt solid windowtext;border-image: initial;border-top: none;padding: 0cm 5.4pt;height: 19.65pt;vertical-align: top;">
                          <p><span>I. Professional or employment-related information</span></p>
                      </td>
                      <td colspan="2" style="width: 247.5pt;border-top: none;border-left: none;border-bottom: 1pt solid windowtext;border-right: 1pt solid windowtext;padding: 0cm 5.4pt;height: 19.65pt;vertical-align: top;">
                          <p><span>Business contact details in order to provide you our services at a business level, job title as well as work history and&nbsp;</span></p>
                          <table style="border-collapse:collapse;border:none;">
                              <tbody>
                                  <tr>
                                      <td style="width: 213.05pt;border: none;padding: 0cm 5.4pt;height: 12.85pt;vertical-align: top;">
                                          <p><span>professional qualifications if you apply fora job with us</span></p>
                                      </td>
                                  </tr>
                              </tbody>
                          </table>
                          <p><br></p>
                      </td>
                      <td colspan="2" style="width: 67.5pt;border-top: none;border-left: none;border-bottom: 1pt solid windowtext;border-right: 1pt solid windowtext;padding: 0cm 5.4pt;height: 19.65pt;vertical-align: top;">
                          <p><span>NO</span></p>
                      </td>
                      <td style="border:none;border-bottom:solid windowtext 1.0pt;">
                          <p style='margin:0cm;margin-bottom:.0001pt;font-size:16px;font-family:"Calibri",sans-serif;'>&nbsp;</p>
                      </td>
                  </tr>
                  <tr>
                      <td style="border:none;padding:0cm 0cm 0cm 0cm;">
                          <p style='margin:0cm;margin-bottom:.0001pt;font-size:16px;font-family:"Calibri",sans-serif;'>&nbsp;</p>
                      </td>
                      <td colspan="2" style="width: 180.9pt;border-right: 1pt solid windowtext;border-bottom: 1pt solid windowtext;border-left: 1pt solid windowtext;border-image: initial;border-top: none;padding: 0cm 5.4pt;height: 19.65pt;vertical-align: top;">
                          <p><span>J. Education Information</span></p>
                      </td>
                      <td colspan="2" style="width: 247.5pt;border-top: none;border-left: none;border-bottom: 1pt solid windowtext;border-right: 1pt solid windowtext;padding: 0cm 5.4pt;height: 19.65pt;vertical-align: top;">
                          <p><span>Student records and directory information</span></p>
                      </td>
                      <td colspan="2" style="width: 67.5pt;border-top: none;border-left: none;border-bottom: 1pt solid windowtext;border-right: 1pt solid windowtext;padding: 0cm 5.4pt;height: 19.65pt;vertical-align: top;">
                          <p><span>NO</span></p>
                      </td>
                  </tr>
                  <tr>
                      <td style="border:none;padding:0cm 0cm 0cm 0cm;">
                          <p style='margin:0cm;margin-bottom:.0001pt;font-size:16px;font-family:"Calibri",sans-serif;'>&nbsp;</p>
                      </td>
                      <td colspan="2" style="width: 180.9pt;border-right: 1pt solid windowtext;border-bottom: 1pt solid windowtext;border-left: 1pt solid windowtext;border-image: initial;border-top: none;padding: 0cm 5.4pt;height: 19.65pt;vertical-align: top;">
                          <p><span>K. Inferences drawn from other personal information</span></p>
                      </td>
                      <td colspan="2" style="width: 247.5pt;border-top: none;border-left: none;border-bottom: 1pt solid windowtext;border-right: 1pt solid windowtext;padding: 0cm 5.4pt;height: 19.65pt;vertical-align: top;">
                          <p><span>Inferences drawn from any of the collected personal information listed above to create profile or summary about, for example, an individual&rsquo;s preferences and characteristics</span></p>
                      </td>
                      <td colspan="2" style="width: 67.5pt;border-top: none;border-left: none;border-bottom: 1pt solid windowtext;border-right: 1pt solid windowtext;padding: 0cm 5.4pt;height: 19.65pt;vertical-align: top;">
                          <p><span>NO</span></p>
                      </td>
                  </tr>
                  <tr>
                      <td style="border:none;"><br></td>
                      <td style="border:none;"><br></td>
                      <td style="border:none;"><br></td>
                      <td style="border:none;"><br></td>
                      <td style="border:none;"><br></td>
                      <td style="border:none;"><br></td>
                      <td style="border:none;"><br></td>
                  </tr>
              </tbody>
          </table>
          <p>&nbsp;</p>
          <p>&nbsp;</p>
          <p><span>We may also collect other personal information outside of these categories instances where you interact with us in-person, online, or by phone or mail in the context of:</span></p>
          <p><span>Receiving help through our customer support channels;</span></p>
          <p><span>&nbsp;</span></p>
          <p><span>Participation in customer surveys or contests; and</span></p>
          <p><span>&nbsp;</span></p>
          <p><span>Facilitation in the delivery of our Services and to respond to your inquiries.</span></p>
          <p><span>&nbsp;</span></p>
          <p><strong><span>How do we use and share your personal information?</span></strong></p>
          <p><span>More information about our data collection and sharing practices can be found in this privacy notice</span><span style="font-size:11px;font-family:Roboto;">.</span></p>
          <p><span>You may contact us by email at info@sellx.ae, by visiting http://sellx.ae/contactus, or by referring to the contact details at the bottom of this document.</span></p>
          <p><span>If you are using an authorized agent to exercise your right to opt-out we may deny a request if the authorized agent does not submit proof that they have been validly authorized to act on your behalf.</span></p>
          <p><strong><span>Will your information be shared with anyone else?</span></strong></p>
          <p><span>We may disclose your personal information with our service providers pursuant to a written contract between us and each service provider. Each service provider is a for-profit entity that processes the information on our behalf.</span></p>
          <p><span>We may use your personal information for our own business purposes, such as for undertaking internal research for technological development and demonstration. Thesis not considered to be &quot;selling&quot; of your personal data.</span></p>
          <p style='margin:0cm;margin-bottom:.0001pt;font-size:16px;font-family:"Calibri",sans-serif;'><span>ALMUSTAQBAL INFORMATION TECHNOLOGY has not disclosed or sold any personal information to third parties for a business or commercial purpose in the preceding 12 months. ALMUSTAQBAL INFORMATION TECHNOLOGY will not sell personal information in the future belonging to website visitors, users and other consumers.</span></p>
          <p><strong><span>Your rights with respect to your personal data</span></strong></p>
          <p><span>Right to request deletion of the data - Request to delete</span></p>
          <p><span>You can ask for the deletion of your personal information. If you ask us to delete your personal information, we will respect your request and delete your personal information, subject to certain exceptions provided by law, such as (but not limited to)the exercise by another consumer of his or her right to free speech, our compliance requirements resulting from a legal obligation or any processing that may be required to protect against illegal activities.</span></p>
          <p><span>Right to be informed - Request to know</span></p>
          <p><span>Depending on the circumstances, you have a right to know:</span></p>
          <p><span>whether we collect and use your personal information;</span></p>
          <p><span>&nbsp;</span></p>
          <p><span>the categories of personal information that we collect;</span></p>
          <p><span>&nbsp;</span></p>
          <p><span>the purposes for which the collected personal information is used;</span></p>
          <p><span>&nbsp;</span></p>
          <p><span>whether we sell your personal information to third parties;</span></p>
          <p><span>&nbsp;</span></p>
          <p><span>the categories of personal information that we sold or disclosed for a business purpose;</span></p>
          <p><span>&nbsp;</span></p>
          <p><span>the categories of third parties to whom the personal information was sold or disclosed for a business purpose; and</span></p>
          <p><span>&nbsp;</span></p>
          <p><span>the business or commercial purpose for collecting or selling personal information.</span></p>
          <p><span>&nbsp;</span></p>
          <p><span>In accordance with applicable law, we are not obligated to provide or delete consumer information that is de-identified in response to a consumer request or to re-identify individual data to verify a consumer request.</span></p>
          <p><span>Right to Non-Discrimination for the Exercise of a Consumer&rsquo;s Privacy Rights</span></p>
          <p><span>We will not discriminate against you if you exercise your privacy rights.</span></p>
          <p><span>Verification process</span></p>
          <p><span>Upon receiving your request, we will need to verify your identity to determine you are the same person about whom we have the information in our system. These verification efforts require us to ask you to provide information so that we can match it with information you have previously provided us. For instance, depending on the type of request you submit, we may ask you to provide certain information so that we can match the information you provide with the information we already have on file, or we may contact you through a communication method (e.g. phone or email) that you have previously provided to us. We may also use other verification methods as the circumstances dictate.</span></p>
          <p><span>We will only use personal information provided in your request to verify your identity or authority to make the request. To the extent possible, we will avoid requesting additional information from you for the purposes of verification. If, however, we cannot verify your identity from the information already maintained by us, we may request that you provide additional information for the purposes of verifying your identity, and for security or fraud-prevention purposes. We will delete such additionally provided information as soon as we finish verifying you.</span></p>
          <p><span>Other privacy rights</span></p>
          <p><span>you may object to the processing of your personal data.</span></p>
          <p><span>&nbsp;</span></p>
          <p><span>you may request correction of your personal data if it is incorrect or no longer relevant, or ask to restrict the processing of the data.</span></p>
          <p><span>&nbsp;</span></p>
          <p><span>you can designate an authorized agent to make a request under the CCPA on your behalf. We may deny a request from an authorized agent that does not submit proof that they have been validly authorized to act on your behalf in accordance with the CCPA.</span></p>
          <p><span>&nbsp;</span></p>
          <p><span>you may request to opt-out from future selling of your personal information to third parties. Upon receiving a request to opt-out, we will act upon the requests soon as feasibly possible, but no later than 15 days from the date of the request submission.</span></p>
          <p><span>&nbsp;</span></p>
          <p><span>To exercise these rights, you can contact us by email at info@sellx.ae, by visitinghttp://sellx.ae/contactus, or by referring to the contact details at the bottom of this document. If you have a complaint about how we handle your data, we would like to hear from you.&nbsp;</span></p>
          <p><span>&nbsp;</span></p>
          <p><strong><span style="font-size:15px;">11. DO WE MAKE UPDATES TO THIS NOTICE?&nbsp;</span></strong></p>
          <p><strong><em><span>In Short:&nbsp;</span></em></strong><em><span>Yes, we will update this notice as necessary to stay compliant with relevant laws.</span></em></p>
          <p><span>We may update this privacy notice from time to time. The updated version will be indicated by an updated &quot;Revised&quot; date and the updated version will be effective as</span> <span>soon as it is accessible. If we make material changes to this privacy notice, we may notify you either by prominently posting a notice of such changes or by directly sending you a notification. We encourage you to review this privacy notice frequently to be informed of how we are protecting your information.</span></p>
          <p><span>&nbsp;</span></p>
          <p><strong><span style="font-size:15px;">12. HOW CAN YOU CONTACT US ABOUT THIS NOTICE?&nbsp;</span></strong></p>
          <p><span>If you have questions or comments about this notice, you may email us atinfo@sellx.ae or by post to:</span></p>
          <p><span>ALMUSTAQBAL INFORMATION TECHNOLOGY</span></p>
          <p><span>Hamdan Incubator</span></p>
          <p><span>Dubai, Dubai</span></p>
          <p><span>United Arab Emirates</span></p>
          <p><span>&nbsp;</span></p>
          <p><strong><span style="font-size:15px;">13. HOW CAN YOU REVIEW, UPDATE, OR DELETE THEDATA WE COLLECT FROM YOU?&nbsp;</span></strong></p>
          <p style='margin:0cm;margin-bottom:.0001pt;font-size:16px;font-family:"Calibri",sans-serif;'><span>Based on the applicable laws of your country, you may have the right to request access to the personal information we collect from you, change that information, or delete it in some circumstances. To request to review, update, or delete your personal information, please visit: http://sellx.ae/contactus.</span></p>

        </div>
  </div>
</div>
@endsection
