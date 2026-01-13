<?php

namespace App\Traits;


trait ApiResponseTrait
{



    public function apiResonseForMobile($status, $message, $data = [])
    {
        return response()->json(
            [
                'status' => $status,
                'message' => $message,
                'data' => $data
            ]
        );
    }



    public function apiPaginationResonseForMobile($status, $message, $data, $pagination_data)
    {
        return response()->json([
            'status' => $status,
            'message' => $message,
            'data' => array_merge($data, [

                // put pagination INSIDE data
                'pagination' => [
                    'total_count' => $pagination_data->total(),
                    'current_page' => $pagination_data->currentPage(),
                    'last_page' => $pagination_data->lastPage(),
                    'per_page' => $pagination_data->perPage(),
                ]

            ])
        ]);
    }
}
