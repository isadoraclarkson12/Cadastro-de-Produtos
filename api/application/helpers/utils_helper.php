<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Utils
{
    public static function curlExec($url, $post = NULL, array $header = array())
    {
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        if(count($header) > 0) {
            curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
        }
        if($post !== null) {
            curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($post, '', '&'));
        }

        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        $data = curl_exec($ch);
        curl_close($ch);
        return $data;
    }

    public static function get_ip()
    {
        $ipaddress = '';
        if(isset($_SERVER['HTTP_CLIENT_IP']))
            $ipaddress = $_SERVER['HTTP_CLIENT_IP'];
        else if(isset($_SERVER['HTTP_X_FORWARDED_FOR']))
            $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
        else if(isset($_SERVER['HTTP_X_FORWARDED']))
            $ipaddress = $_SERVER['HTTP_X_FORWARDED'];
        else if(isset($_SERVER['HTTP_FORWARDED_FOR']))
            $ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
        else if(isset($_SERVER['HTTP_FORWARDED']))
            $ipaddress = $_SERVER['HTTP_FORWARDED'];
        else if(isset($_SERVER['REMOTE_ADDR']))
            $ipaddress = $_SERVER['REMOTE_ADDR'];
        else
            $ipaddress = 'UNKNOWN';
        return $ipaddress ;
    }

    public static function getPermissoes($token, $key)
    {
        $payload = JWT::decode($token, $key);
        if($payload->admin == '1')
        {
            return $payload->permissoes;
        }
        else
        {
            return false;
        }
    }

    public static function slugify($text)
    {
        $text = preg_replace('~[^\pL\d]+~u', '-', $text);
        $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);
        $text = preg_replace('~[^-\w]+~', '', $text);
        $text = trim($text, '-');
        $text = preg_replace('~-+~', '-', $text);
        $text = strtolower($text);
        if (empty($text)) {
            return 'n-a';
        }
        return $text;
    }

    public static function generateRandomStrNumber()
    {
        return str_pad(rand(1000, 9999), 4,"0",STR_PAD_LEFT);
    }

    public static function isTokenValid( $token, $key )
    {

        if( trim($token) == '' ) return 0;

        $payload = JWT::decode($token, $key);

        if ( !isset($payload[0]->email, $payload[0]->id) && $payload[0]->email == '' || $payload[0]->id == '' )
        {
            return 0;
        }

        try
        {
            AUTHORIZATION::validateToken($token);
        }
        catch(Exception $e)
        {
            return 0;
        }
        return $payload[0];
    }


    public static function fetchToken( $token, $key )
    {
        if( !isset($token ) )
        {
            return 0;
        }

        if( trim($token) == '' ) return 0;

        $payload = JWT::decode($token, $key);

        if ( !isset($payload->celular, $payload->id) && $payload->celular == '' || $payload->id == '' )
        {
            return 0;
        }

        try
        {
            AUTHORIZATION::validateToken($token);
        }
        catch(Exception $e)
        {
            return 0;
        }
        return $payload;
    }
}