<?php

use Brian2694\Toastr\Facades\Toastr;

if (!function_exists('ToastrNotification')) {
    function ToastrNotification(array $data)
    {
        switch ($data['type']) {
            case 'success' :
                Toastr::success($data['msg'], $data['title'] ?? 'Hooray', ['options']);
                break;
            case 'error' :
                Toastr::error($data['msg'], $data['title'] ?? 'Oops', ['options']);
                break;
            case 'info' :
                Toastr::info($data['msg'], $data['title'] ?? 'Info', ['options']);
                break;
            case 'warning' :
                Toastr::warning($data['msg'], $data['title'] ?? 'Warning', ['options']);
                break;
            default :
                Toastr::info($data['msg'], $data['title'] ?? 'Info', ['options']);
        }
    }
}
