<?php

require_once APP_ROOT . '/app/models/InquiryModel.php';
require_once APP_ROOT . '/app/models/LookupModel.php';

class ContactController extends Controller
{
    public function show(): void
    {
        $this->view('contact/index', ['title' => 'Contact Us — ' . SITE_NAME]);
    }

    public function submit(): void
    {
        csrfCheck();
        $name    = sanitize($this->post('name'));
        $email   = sanitize($this->post('email'));
        $phone   = sanitize($this->post('phone'));
        $subject = sanitize($this->post('subject'));
        $message = sanitize($this->post('message'));
        $errors  = [];

        if (empty($name))          $errors[] = 'Your name is required.';
        if (!validateEmail($email)) $errors[] = 'A valid email address is required.';
        if (empty($message))       $errors[] = 'Please enter your message.';

        if (empty($errors)) {
            (new InquiryModel())->create([
                'listing_type' => 'contact',
                'listing_id'   => null,
                'sender_name'  => $name,
                'sender_phone' => $phone,
                'sender_email' => $email,
                'message'      => ($subject ? "Subject: $subject\n\n" : '') . $message,
            ]);
            $this->flash('success', 'Thank you for contacting us! We will get back to you shortly.');
            $this->redirect(url('contact'));
            return;
        }

        $this->view('contact/index', [
            'title'  => 'Contact Us',
            'errors' => $errors,
            'old'    => compact('name','email','phone','subject','message'),
        ]);
    }

    public function ajaxCities(): void
    {
        $district = $this->get('district');
        $cities   = $district ? (new LookupModel())->getCitiesByDistrict($district) : [];
        $this->json($cities);
    }
}
