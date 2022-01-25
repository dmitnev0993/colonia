<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function home() {

        return view('home');
    }

    public function aboutUs() {
        return view('about-us');
    }

    public function privacyPolicy() {
        return view('privacy-policy');
    }

    public function visionValues() {

        return view('vision-values');
    }

    public function colonial() {

        return view('colonial');
    }

    public function terms() {

        return view('terms');
    }

    public function financial() {

        return view('financial');
    }

    public function contactUs(Request  $request) {

        if($request->isMethod('post')) {

            $form_state = $request->all();
            $success = true;


            if ($success && empty($_COOKIE['message_sent'])) {
                $name = empty($form_state['name']) ? '' : $form_state['name'];
                $phone = empty($form_state['phone']) ? '' : $form_state['phone'];
                $email = empty($form_state['email']) ? '' : $form_state['email'];
                $state = empty($form_state['state']) ? '' : $form_state['state'];
                $message = empty($form_state['message']) ? '' : $form_state['message'];
                $ip =  $_SERVER['REMOTE_ADDR'];
                $mail = array();
                $mail['message'] = '
			<p>Name - ' . $name . '</p>
			<p>Phone Number - ' . $phone . '</p>
			<p>E-mail - ' . $email . '</p>
			<p>State - ' . $state . '</p>
			<p>Message - ' . $message . '</p>
			<p>ip - ' . $ip . '</p>';
                $mail['subject'] = 'Callback request';
                $mail['address'] = array('support@colonialinsurance.com.au');
                easyMail($mail);
                setcookie('message_sent', '1', (time() + 300));
                $form_state['rebuild'] = true;
            } else {
                $form_state['rebuild'] = false;
                setcookie('message_sent', '1', (time() - 300));
            }


            return redirect()->back()->with('success', 1);
        }

        return view('contact-us');
    }

    public function residential() {

        return view('residential');
    }

    public function commercial() {

        return view('commercial');
    }
}
