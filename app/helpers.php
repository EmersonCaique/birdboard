<?php


function gravatar_email($email)
{
    $email = md5($email);

    return "https://www.gravatar.com/avatar/{$email}?s=60";
}
