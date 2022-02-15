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
        <p class="mb-0 pb-0"><span><b>END USER LICENSE AGREEMENT</b></span></p>
        <p><span>Last updated January 01, 2022</span></p>
        <p><span>&nbsp;</span></p>
        <p><span>Sellx&nbsp;</span><span>is licensed to You (End-User) by&nbsp;</span><span>ALMUSTAQBAL INFORMATION TECHNOLOGY</span><span>, located and registered at&nbsp;</span><span>Hamdan Incubator</span><span>,&nbsp;</span><span>Dubai</span><span>,&nbsp;</span><span>Dubai __________</span><span>,&nbsp;</span><span>United Arab Emirates&nbsp;</span><span>(hereinafter: Licensor), for use only under the terms of this License Agreement. By downloading the Application from the Apple AppStore, and any update thereto (as permitted by this License Agreement), You indicate that You agree to be bound by all of the terms and conditions of this License Agreement, and that You accept this License Agreement.</span></p>
        <p><span>&nbsp;</span></p>
        <p><span>The parties of this License Agreement acknowledge that Apple is not a Party to this License Agreement and is not bound by any provisions or obligations with regard to the Application, such as warranty, liability, maintenance and support thereof.&nbsp;</span><span>ALMUSTAQBAL INFORMATION TECHNOLOGY</span><span>, not Apple, is solely responsible for the licensed Application and the content thereof.</span></p>
        <p><span>This License Agreement may not provide for usage rules for the Application that are in conflict with the latest&nbsp;</span><span style="font-size:14px;font-family:__s‘˛;color:#3030F2;">App Store Terms of Service</span><span>. ALMUSTAQBAL INFORMATION TECHNOLOGY acknowledges that it had the opportunity to review said terms and this License Agreement is not conflicting with them. All rights not expressly granted to You are reserved.</span></p>
        <p><span>&nbsp;</span></p>
        <p><span>1. THE APPLICATION</span></p>
        <p><span>Sellx&nbsp;</span><span>(hereinafter: Application) is a piece of software created to&nbsp;</span><span>An online Platform that connects auction houses &amp; bidders and bring them in one place&nbsp;</span><span>- and customized for Apple mobile devices. It is used to&nbsp;</span><span>Buy and Sell goods via auction</span><span>.&nbsp;</span><span>The Application is not tailored to comply with industry-specific regulations (Health Insurance Portability and Accountability Act (HIPAA), Federal Information Security Management Act (FISMA), etc.), so if your interactions would be subjected to such laws, you may not use this Application. You may not use the Application in a way that would violate the Gramm-Leach-Bliley Act (GLBA).</span></p>
        <p><span>&nbsp;</span></p>
        <p><span>2. SCOPE OF LICENSE</span></p>
        <p><span>2.1 You are given a non-transferable, non-exclusive, non-sublicensable license to install and use the Licensed Application on any Apple-branded Products that You (End-User) own or control and as permitted by the Usage Rules set forth in this section and the App Store Terms of Service, with the exception that such licensed Application may be accessed and used by other accounts associated with You (End-User, The Purchaser) via Family Sharing or volume purchasing.</span></p>
        <p><span>2.2 This license will also govern any updates of the Application provided by Licensor that replace, repair, and/or supplement the</span></p>
        <p><span>first Application, unless a separate license is provided for such update in which case the terms of that new license will govern.</span></p>
        <p><span>2.3 You may not share or make the Application available to third parties (unless to the degree allowed by the Apple Terms and Conditions, and with&nbsp;</span><span>ALMUSTAQBAL INFORMATION TECHNOLOGY</span><span>&apos;s prior written consent), sell, rent, lend, lease or otherwise redistribute the Application.</span></p>
        <p><span>2.4 You may not reverse engineer, translate, disassemble, integrate, decompile, integrate, remove, modify, combine, create derivative works or updates of, adapt, or attempt to derive the source code of the Application, or any part thereof (except with ALMUSTAQBAL INFORMATION TECHNOLOGY&apos;s prior written consent).</span></p>
        <p><span>2.5 You may not copy (excluding when expressly authorized by this license and the Usage Rules) or alter the Application or portions thereof. You may create and store copies only on devices that You own or control for backup keeping under the terms of this license, the App Store Terms of Service, and any other terms and conditions that apply to the device or software used. You may not remove any intellectual property notices. You acknowledge that no unauthorized third parties may gain access to these copies at any time.</span></p>
        <p><span>2.6 Violations of the obligations mentioned above, as well as the attempt of such infringement, may be subject to prosecution and damages.</span></p>
        <p><span>2.7 Licensor reserves the right to modify the terms and conditions of licensing.</span></p>
        <p><span>2.8 Nothing in this license should be interpreted to restrict third-party terms. When using the Application, You must ensure that You comply with applicable third-party terms and conditions.</span></p>
        <p><span>&nbsp;</span></p>
        <p><span>3. TECHNICAL REQUIREMENTS</span></p>
        <p><span>3.1 The Application requires a firmware version 1.0.0 or higher. Licensor recommends using the latest version of the firmware.</span></p>
        <p><span>3.2 Licensor attempts to keep the Application updated so that it complies with modified/new versions of the firmware and new hardware. You are not granted rights to claim such an update.</span></p>
        <p><span>3.3 You acknowledge that it is Your responsibility to confirm and determine that the app end-user device on which You intend to use the Application satisfies the technical specifications mentioned above.</span></p>
        <p><span>3.4 Licensor reserves the right to modify the technical specifications as it sees appropriate at any time.</span></p>
        <p><span>&nbsp;</span></p>
        <p><span>4. MAINTENANCE AND SUPPORT</span></p>
        <p><span>4.1 The Licensor is solely responsible for providing any maintenance and support services for this licensed Application. You can reach the Licensor at the email address listed in the App Store Overview for this licensed Application.</span></p>
        <p><span>4.2&nbsp;</span><span>ALMUSTAQBAL INFORMATION TECHNOLOGY&nbsp;</span><span>and the End-User acknowledge that Apple has no obligation whatsoever to furnish any maintenance and support services with respect to the licensed Application.</span></p>
        <p><span>&nbsp;</span></p>
        <p><span>5. USE OF DATA</span></p>
        <p><span>You acknowledge that Licensor will be able to access and adjust Your downloaded licensed Application content and Your personal information, and that Licensor&apos;s use of such material and information is subject to Your legal agreements with Licensor and Licensor&apos;s privacy policy:&nbsp;</span><span style="font-size:14px;font-family:__s‘˛;color:#3030F2;">http://sellx.ae/privacypolicy</span><span>.</span></p>
        <p><span>&nbsp;</span></p>
        <p><span>6. USER GENERATED CONTRIBUTIONS</span></p>
        <p><span>The Application may invite you to chat, contribute to, or participate in blogs, message boards, online forums, and other functionality, and may provide you with the opportunity to create, submit, post, display, transmit, perform, publish, distribute, or broadcast content and materials to us or in the Application, including but not limited to text, writings, video, audio, photographs, graphics, comments, suggestions, or personal information or other material (collectively, &quot;Contributions&quot;). Contributions may be viewable by other users of the Application and through third-party websites or applications. As such, any Contributions you transmit may be treated as non-confidential and non-proprietary. When you create or make available any Contributions, you thereby represent and warrant that:</span></p>
        <p><span>1. The creation, distribution, transmission, public display, or performance, and the accessing, downloading, or copying of your Contributions do not and will not infringe the proprietary rights, including but not limited to the copyright, patent, trademark, trade secret, or moral rights of any third party.</span></p>
        <p><span>2. You are the creator and owner of or have the necessary licenses, rights, consents, releases, and permissions to use and to authorize us, the Application, and other users of the Application to use your Contributions in any manner contemplated by the Application and these Terms of Use.</span></p>
        <p><span>3. You have the written consent, release, and/or permission of each and every identifiable individual person in your Contributions to use the name or likeness or each and every such identifiable individual person to enable inclusion and use of your Contributions in any manner contemplated by the Application and these Terms of Use.</span></p>
        <p><span>4. Your Contributions are not false, inaccurate, or misleading.</span></p>
        <p><span>5. Your Contributions are not unsolicited or unauthorized advertising, promotional materials, pyramid schemes, chain letters, spam, mass mailings, or other forms of solicitation.</span></p>
        <p><span>6. Your Contributions are not obscene, lewd, lascivious, filthy, violent, harassing, libelous, slanderous, or otherwise objectionable (as determined by us).</span></p>
        <p><span>7. Your Contributions do not ridicule, mock, disparage, intimidate, or abuse anyone.</span></p>
        <p><span>8. Your Contributions are not used to harass or threaten (in the legal sense of those terms) any other person and to promote violence against a specific person or class of people.</span></p>
        <p><span>9. Your Contributions do not violate any applicable law, regulation, or rule.</span></p>
        <p><span>10. Your Contributions do not violate the privacy or publicity rights of any third party.</span></p>
        <p><span>11. Your Contributions do not violate any applicable law concerning child pornography, or otherwise intended to protect the health or well-being of minors.</span></p>
        <p><span>12. Your Contributions do not include any offensive comments that are connected to race, national origin, gender, sexual preference, or physical handicap.</span></p>
        <p><span>13. Your Contributions do not otherwise violate, or link to material that violates, any provision of these Terms of Use, or any applicable law or regulation.</span></p>
        <p><span>Any use of the Application in violation of the foregoing violates these Terms of Use and may result in, among other things, termination or suspension of your rights to use the Application.</span></p>
        <p><span>&nbsp;</span></p>
        <p><span>7. CONTRIBUTION LICENSE</span></p>
        <p><span>By posting your Contributions to any part of the Application or making Contributions accessible to the Application by linking your account from the Application to any of your social networking accounts, you automatically grant, and you represent and warrant that you have the right to grant, to us an unrestricted, unlimited, irrevocable, perpetual, nonexclusive, transferable, royalty-free, fully-paid, worldwide right, and license to host, use copy, reproduce, disclose, sell, resell, publish, broad cast, retitle, archive, store, cache, publicly display, reformat, translate, transmit, excerpt (in whole or in part), and distribute such Contributions (including, without limitation, your image and voice) for any purpose, commercial advertising, or otherwise, and to prepare derivative works of, or incorporate in other works, such as Contributions, and grant and authorize sublicenses of the foregoing. The use and distribution may occur in any media formats and through any media channels.</span></p>
        <p><span>This license will apply to any form, media, or technology now known or hereafter developed, and includes our use of your name, company name, and franchise name, as applicable, and any of the trademarks, service marks, trade names, logos, and personal and commercial images you provide. You waive all moral rights in your Contributions, and you warrant that moral rights have not otherwise been asserted in your Contributions.</span></p>
        <p><span>We do not assert any ownership over your Contributions. You retain full ownership of all of your Contributions and any intellectual property rights or other proprietary rights associated with your Contributions. We are not liable for any statements or representations in your Contributions provided by you in any area in the Application. You are solely responsible for your Contributions to the Application and you expressly agree to exonerate us from any and all responsibility and to refrain from any legal action against us regarding your Contributions.</span></p>
        <p><span>We have the right, in our sole and absolute discretion, (1) to edit, redact, or otherwise change any Contributions; (2) to re-categorize any Contributions to place them in more appropriate locations in the Application; and (3) to pre-screen or delete any Contributions at any time and for any reason, without notice. We have no obligation to monitor your Contributions.</span></p>
        <p><span>&nbsp;</span></p>
        <p><span>8. LIABILITY</span></p>
        <p><span>8.1 Licensor&apos;s responsibility in the case of violation of obligations and tort shall be limited to intent and gross negligence. Only in case of a breach of essential contractual duties (cardinal obligations), Licensor shall also be liable in case of slight negligence. In any case, liability shall be limited to the foreseeable, contractually typical damages. The limitation mentioned above does not apply to injuries to life, limb, or health.</span></p>
        <p><span>8.2 Licensor takes no accountability or responsibility for any damages caused due to a breach of duties according to Section 2 of this Agreement. To avoid data loss, You are required to make use of backup functions of the Application to the extent allowed by applicable third-party terms and conditions of use. You are aware that in case of alterations or manipulations of the Application, You will not have access to licensed Application.</span></p>
        <p><span>&nbsp;</span></p>
        <p><span>9. WARRANTY</span></p>
        <p><span>9.1 Licensor warrants that the Application is free of spyware, trojan horses, viruses, or any other malware at the time of Your download. Licensor warrants that the Application works as described in the user documentation.</span></p>
        <p><span>9.2 No warranty is provided for the Application that is not executable on the device, that has been unauthorizedly modified, handled inappropriately or culpably, combined or installed with inappropriate hardware or software, used with inappropriate accessories, regardless if by Yourself or by third parties, or if there are any other reasons outside of ALMUSTAQBAL INFORMATION TECHNOLOGY&apos;s sphere of influence that affect the executability of the Application.</span></p>
        <p><span>9.3 You are required to inspect the Application immediately after installing it and notify ALMUSTAQBAL INFORMATION TECHNOLOGY about issues discovered without delay by e-mail provided in Product Claims. The defect report will be taken into consideration and further investigated if it has been mailed within a period of thirty (30) days after discovery.</span></p>
        <p><span>9.4 If we confirm that the Application is defective, ALMUSTAQBAL INFORMATION TECHNOLOGY reserves a choice to remedy the situation either by means of solving the defect or substitute delivery.</span></p>
        <p><span>9.5&nbsp;</span><span>In the event of any failure of the Application to conform to any applicable warranty, You may notify the App-Store-Operator, and Your Application purchase price will be refunded to You. To the maximum extent permitted by applicable law, the App-Store-Operator will have no other warranty obligation whatsoever with respect to the App, and any other losses, claims, damages, liabilities, expenses and costs attributable to any negligence to adhere to any warranty.</span></p>
        <p><span>9.6&nbsp;</span><span>If the user is an entrepreneur, any claim based on faults expires after a statutory period of limitation amounting to twelve (12) months after the Application was made available to the user. The statutory periods of limitation given by law apply for users who are consumers.</span></p>
        <p><span>&nbsp;</span></p>
        <p><span>10. PRODUCT CLAIMS</span></p>
        <p><span>ALMUSTAQBAL INFORMATION TECHNOLOGY and the End-User acknow</span><span>ledge that&nbsp;</span><span>ALMUSTAQBAL INFORMATION TECHNOLOGY</span><span>, and not Apple, is responsible for addressing any claims of the End-User or any third party relating to the licensed Application or the End-User&rsquo;s possession and/or use of that licensed Application, including, but not limited to:</span></p>
        <p><span>(i) product liability claims;</span></p>
        <p><span>(ii) any claim that the licensed Application fails to conform to any applicable legal or regulatory requirement; and</span></p>
        <p><span>(iii) claims arising under consumer protection, privacy, or similar legislation, including in connection with&nbsp;</span></p>
        <p><span>&nbsp;</span></p>
        <p><span>11. LEGAL COMPLIANCE</span></p>
        <p><span>You represent and warrant that You are not located in a country that is subject to a U.S. Government embargo, or that has been designated by the U.S. Government as a &quot;terrorist supporting&quot; country; and that You are not listed on any U.S. Government list of prohibited or restricted parties.</span></p>
        <p><span>&nbsp;</span></p>
        <p><span>12. CONTACT INFORMATION</span></p>
        <p><span>For general inquiries, complaints, questions or claims concerning the licensed Application, please contact:</span></p>
        <p><span>Sellx</span></p>
        <p><span>Hamdan Incubator</span></p>
        <p><span>Dubai</span><span>,&nbsp;</span><span>Dubai __________</span></p>
        <p><span>United Arab Emirates</span></p>
        <p><span>info@sellx.ae</span></p>
        <p><span>&nbsp;</span></p>
        <p><span>&nbsp;</span></p>
        <p><span>13. TERMINATION</span></p>
        <p><span>The license is valid until terminated by&nbsp;</span><span>ALMUSTAQBAL INFORMATION TECHNOLOGY&nbsp;</span><span>or by You. Your rights under this license will terminate automatically and without notice from&nbsp;</span><span>ALMUSTAQBAL INFORMATION TECHNOLOGY&nbsp;</span><span>if You fail to adhere to any term(s) of this license. Upon License termination, You shall stop all use of the Application, and destroy all copies, full or partial, of the Application.</span></p>
        <p><span>&nbsp;</span></p>
        <p><span>&nbsp;</span></p>
        <p><span>14. THIRD-PARTY TERMS OF AGREEMENTS AND BENEFICIARY</span></p>
        <p><span>ALMUSTAQBAL INFORMATION TECHNOLOGY&nbsp;</span><span>represents and warrants that&nbsp;</span><span>ALMUSTAQBAL INFORMATION</span></p>
        <p><span>TECHNOLOGY&nbsp;</span><span>will comply with applicable third-party terms of agreement when using licensed Application.&nbsp;</span></p>
        <p><span>In Accordance with Section 9 of the &quot;Instructions for Minimum Terms of Developer&apos;s End-User License Agreement,&quot; Apple and Apple&apos;s subsidiaries shall be third-party beneficiaries of this End User License Agreement and - upon Your acceptance of the terms and conditions of this license agreement, Apple will have the right (and will be deemed to have accepted the right) to enforce this End User License Agreement against You as a third-party beneficiary thereof.</span></p>
        <p><span>&nbsp;</span></p>
        <p><span>15. INTELLECTUAL PROPERTY RIGHTS</span></p>
        <p><span>ALMUSTAQBAL INFORMATION TECHNOLOGY&nbsp;</span><span>and the End-User acknowledge that, in the event of any third-party claim that the licensed Application or the End-User&apos;s possession and use of that licensed Application infringes on the third party&apos;s intellectual property rights,&nbsp;</span><span>ALMUSTAQBAL INFORMATION TECHNOLOGY</span><span>, and not Apple, will be solely responsible for the investigation, defense, settlement and discharge or any such intellectual property infringement claims.</span></p>
        <p><span>&nbsp;</span></p>
        <p><span>16. APPLICABLE LAW</span></p>
        <p><span>This license agreement is governed by the laws of the&nbsp;</span><span>United Arab Emirates&nbsp;</span><span>excluding its conflicts of law rules.</span></p>
        <p><span>&nbsp;</span></p>
        <p><span>17. MISCELLANEOUS</span></p>
        <p><span>&nbsp;</span></p>
        <p><span>17.1&nbsp;</span><span>If any of the terms of this agreement should be or become invalid, the validity of the remaining provisions shall not be affected. Invalid terms will be replaced by valid ones formulated in a way that will achieve the primary purpose.</span></p>
        <p><span>&nbsp;</span></p>
        <p><span>17.2&nbsp;</span><span>Collateral agreements, changes and amendments are only valid if laid down in writing. The preceding clause can only be waived in writing.</span></p>
        </div>
    </div>
</div>
@endsection
