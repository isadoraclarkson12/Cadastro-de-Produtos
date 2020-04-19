<?php

class AUTHORIZATION
{
    public static function validateToken($token)
    {
        $CI =& get_instance();
        return JWT::decode($token, $CI->config->item('jwt_key'));
    }

    public static function generateToken($data)
    {
        $CI =& get_instance();
        return JWT::encode($data, $CI->config->item('jwt_key'));
    }

    public static function decode( $token, $key )
    {

        if(trim($token) == '')
        {
            return array('status' => false, 'message' => 'Sem permissao de acesso');
        }
        else
        {

            try
            {
                $payload = JWT::decode($token, $key)[0];

                if ( !isset($payload->id) || trim($payload->id == '' )
                    && !isset($payload->email) || trim($payload->email == '' ) )
                {
                    return array('status' => false, 'message' => 'Sem permissão de acesso', 'data' => []);
                }
                else
                {
                    try
                    {
                        AUTHORIZATION::validateToken($token);
                    }
                    catch(Exception $e)
                    {
                        return array('status' => false, 'message' =>  $e->getMessage(), 'data' => []);
                    }
                    return array('status' => true, 'message' => 'Válido', 'data' => $payload);
                }
                
            }
            catch (Exception $e)
            {
                return array('status' => false, 'message' =>  $e->getMessage(), 'data' => []);
            }
        }
    }
}