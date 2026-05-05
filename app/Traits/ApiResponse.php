<?php

namespace App\Traits;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Exceptions\HttpResponseException;

trait ApiResponse
{
    function returnData($data, $message = null, $pagination = null)
    {
        $data = [
            'status' => true,
            'message' => $message,
            'data' => $data,
        ];
        if ($pagination) $data['pagination'] = $pagination;
        if (!$message) $data['message'] = "تم استرجاع البيانات بنجاح";
        return response()->json($data);
    }

    function returnSuccessMessage($message)
    {
        return response()->json([
            'status' => true,
            'message' => $message,
        ]);
    }

    function returnError($message, $status = 200)
    {
        return response()->json([
            'status' => false,
            'message' => $message,
        ], $status);
    }


    function returnValidationError($validator)
    {
        return response()->json([
            'status' => false,
            'message' =>  $validator->errors()->first()
        ]);
    }


    function make_pagination($items)
    {
        $response = [
            'current_page' => $items->currentPage(),
            'last_page' => $items->lastPage(),
            'per_page' => $items->perPage(),
            'from' => $items->firstItem(),
            'to' => $items->lastItem(),
            'total' => $items->total(),
        ];
        return $response;
    }


    public static function rollback($e, $message = "حدث خطأ! لم تكتمل العملية")
    {
        DB::rollBack();
        self::throw($e, $message);
    }

    public static function throw($e, $message = "حدث خطأ! لم تكتمل العملية")
    {
        Log::info($e);
        throw new HttpResponseException(response()->json(["message" => $message], 500));
    }
}
