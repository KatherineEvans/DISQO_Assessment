<?php

namespace App\Traits;

use Illuminate\Pagination\Paginator;
use Illuminate\Pagination\LengthAwarePaginator;

trait PaginatesResponseTrait
{
    public function returnPaginatedResponse($query, $pagination_settings)
    {
        if (!$pagination_settings) {
            $notes = $query->get();

            return response()->json([
                'data' => $notes,
            ]);
        }

        if (gettype($pagination_settings) === 'string') {
            $pagination_settings = json_decode($pagination_settings);
        }

        if (gettype($pagination_settings) === 'array') {
            $pagination_settings = (object) $pagination_settings;
        }

        $column = $pagination_settings->sortColumn ?? 'created_at';
        $order = $pagination_settings->sortOrder ?? 'DESC';
        $size = $pagination_settings->pageSize ?? 10;
        $page = $pagination_settings->page ?? 1;

        $sortable_columns = [
            'title', 
            'created_at',
            'updated_at',
        ];

        if (in_array($column, $sortable_columns)) {

            $collection = $query->get();

            $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);

            if ($order === 'DESC' ) {
                $data = $collection->sortByDesc($column, SORT_NATURAL|SORT_FLAG_CASE)->values();
            } else {
                $data = $collection->sortBy($column, SORT_NATURAL|SORT_FLAG_CASE)->values();
            }

            $length_paginator = new LengthAwarePaginator($data->forPage($page, $size), $data->count(), $size, $page);

            return [
                'current_page' => $length_paginator->currentPage(),
                'data' => $length_paginator->values(),
                'first_page_url' => $length_paginator->url(1),
                'from' => $length_paginator->firstItem(),
                'last_page' => $length_paginator->lastPage(),
                'last_page_url' => $length_paginator->url($length_paginator->lastPage()),
                'next_page_url' => $length_paginator->nextPageUrl(),
                'per_page' => $length_paginator->perPage(),
                'prev_page_url' => $length_paginator->previousPageUrl(),
                'to' => $length_paginator->lastItem(),
                'total' => $length_paginator->total(),
            ];

        } else {
            Paginator::currentPageResolver( function () use ($page) {
                return response()->json([
                    'data' => $page,
                ]);
            });

            $notes = $query->orderBy($column, $order)->paginate($size);

            return response()->json([
                'data' => $notes,
            ]);
        }
    }
}