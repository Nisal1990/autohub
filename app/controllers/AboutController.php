<?php

class AboutController extends Controller
{
    public function index(): void
    {
        $this->view('about/index', ['title' => 'About Us — ' . SITE_NAME]);
    }
}
