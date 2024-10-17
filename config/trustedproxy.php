<?php

return [

    'proxies' => '*', // Confia em todas as proxies, altere conforme necessário

    'headers' => [
        Illuminate\Http\Request::HEADER_FORWARDED => 'FORWARDED',
        Illuminate\Http\Request::HEADER_X_FORWARDED_FOR => 'X_FORWARDED_FOR',
        Illuminate\Http\Request::HEADER_X_FORWARDED_HOST => 'X_FORWARDED_HOST',
        Illuminate\Http\Request::HEADER_X_FORWARDED_PORT => 'X_FORWARDED_PORT',
        Illuminate\Http\Request::HEADER_X_FORWARDED_PROTO => 'X_FORWARDED_PROTO',
        Illuminate\Http\Request::HEADER_X_FORWARDED_AWS_ELB => null,
    ],
];
