<?php

namespace App\Http\Controllers;

use DateTime;
use Illuminate\Http\Request;

class HelperController extends Controller
{
    public function isValidEmail($email): bool
    {
        $pattern = '/^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/';
        return preg_match($pattern, $email);
    }

    public function calculateDatetimeDifference($datetime1, $datetime2): string
    {
        $datetime1 = new DateTime($datetime1);
        $datetime2 = new DateTime($datetime2);
        $interval = $datetime1->diff($datetime2);

        return $interval->d . ' days ' . $interval->h . ' hours ' . $interval->i . ' minutes ' . $interval->s . ' seconds';
    }
}
