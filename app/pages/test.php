<?php

$email = module('email');

$email->from_name='John Smith';
$email->from_email='j.smith@example.com';
$email->message='<p>Hey...,</p><p>This is an test message!</p>Best Regards,<br>John Smith</p>';

$email->send('example@example.com'); 

