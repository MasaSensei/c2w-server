<?php

namespace App\Helpers;

class ResponseHelper
{
    public static function success($data, $message = 'Request successful', $code = 200)
    {
        return response()->json([
            'success' => true,
            'data' => $data,
            'message' => $message,
        ], $code);
    }

    public static function error($message, $code = 400, $data = null)
    {
        return response()->json([
            'success' => false,
            'message' => $message,
            'data' => $data
        ], $code);
    }

    public static function created($data, $message = 'Resource created successfully')
    {
        return self::success($data, $message, 201);
    }

    public static function edit($data, $message = 'Resource updated successfully')
    {
        return self::success($data, $message, 200);
    }

    public static function deleted($message = 'Resource deleted successfully')
    {
        return self::success(null, $message, 200);
    }

    public static function notFound($message = 'Resource not found', $code = 404)
    {
        return response()->json([
            'success' => false,
            'message' => $message,
        ], $code);
    }

    public static function unAuthorized($message = 'Unauthorized', $code = 401)
    {
        return response()->json([
            'success' => false,
            'message' => $message,
        ], $code);
    }
}
