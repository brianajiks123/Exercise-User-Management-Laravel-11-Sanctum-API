<?php

namespace App\Helper;

class ResponseHelper
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Function: Common function to display success
     * @param string $status
     * @param string $msg
     * @param array $data
     * @param integer $status_code
     * @return: JSON Response
     */
    public static function success($status = "success", $msg = null, $data = [], $status_code = 200)
    {
        return response()->json([
            "status" => $status,
            "message" => $msg,
            "data" => $data
        ], $status_code);
    }

    /**
     * Function: Common function to display error
     * @param string $status
     * @param string $msg
     * @param integer $status_code
     * @return: JSON Response
     */
    public static function error($status = "error", $msg = null, $status_code = 400)
    {
        return response()->json([
            "status" => $status,
            "error_message" => $msg
        ], $status_code);
    }
}
