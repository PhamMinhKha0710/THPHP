<?php
class DefaultController
{
    public function index()
    {
        // Redirect to the home page as the default landing page
        header('Location: /THPHP/WebBanHangtuan2/Home');
        exit;
    }
} 