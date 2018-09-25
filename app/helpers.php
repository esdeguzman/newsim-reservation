<?php

namespace App\Helper;

use App\AdministratorRole;
use Carbon\Carbon;

if (! function_exists('trainee')) {
    function trainee()
    {
        return optional(auth()->user())->trainee;
    }
}

if (! function_exists('admin')) {
    function admin()
    {
        return optional(auth()->user())->administrator;
    }
}

if (! function_exists('adminUrl')) {
    function prefixedUrl()
    {
        $url = null;
        if (admin()) $url = url('admin/');
        elseif (trainee()) $url = url('trainee/');

        return $url;
    }
}

if (! function_exists('user')) {
    function user()
    {
        return auth()->user();
    }
}

if (! function_exists('toReadableDate')) {
    function toReadableDate($rawDate)
    {
        return Carbon::parse($rawDate)->toFormattedDateString();
    }
}

if (! function_exists('toReadableExpirationDate')) {
    function toReadableExpirationDate($rawDate)
    {
        return Carbon::parse($rawDate)->addDay(1)->toFormattedDateString();
    }
}

if (! function_exists('toPercentage')) {
    function toPercentage($decimalNumber)
    {
        return $decimalNumber * 100 . '%';
    }
}

if (! function_exists('toReadablePayment')) {
    function toReadablePayment($originalPrice, $discount)
    {
        return number_format($originalPrice -= ($originalPrice * $discount), 2);
    }
}

if (! function_exists('computePayment')) {
    function computePayment($originalPrice, $discount)
    {
        return $originalPrice -= ($originalPrice * $discount);
    }
}

if (! function_exists('addedWalkinApplicants')) {
    function addedWalkinApplicants($batch)
    {
        $walkins = $batch->cor_numbers? explode(',', $batch->cor_numbers) : [];
        return count($walkins);
    }
}

if (! function_exists('adminCan')) {
    function adminCan($action, $admin = null)
    {
        $bool = false;
        if (user()->isDev()) return true;
        if($admin) {
            $bool = AdministratorRole::with('role')
                ->where('administrator_id', $admin->id)
                ->where('revoked_by',null)->get()
                ->pluck('role')->contains('name', '=', $action);
        } else {
            $bool = AdministratorRole::with('role')
                ->where('administrator_id', admin()->id)
                ->where('revoked_by',null)->get()
                ->pluck('role')->contains('name', '=', $action);
        }

        return $bool;
    }
}