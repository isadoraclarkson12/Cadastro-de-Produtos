<?php
if ( !defined('BASEPATH')) exit('No direct script access allowed');

if (!function_exists('defaultResponse'))
{
    function defaultResponse( $draw, $recordsTotal, $recordsFiltered, $data  )
    {
       return [
            "draw"            => $draw,
            "recordsTotal"    => $recordsTotal,
            "recordsFiltered" => $recordsFiltered,
            "data"            => $data
        ];
    }
}



if (!function_exists('dataTablesResponse'))
{
    function dataTablesResponse ( $draw, $recordsTotal, $recordsFiltered, $data  )
    {
        return [
            "draw"            => $draw,
            "recordsTotal"    => $recordsTotal,
            "recordsFiltered" => $recordsFiltered,
            "data"            => $data
        ];
    }
}