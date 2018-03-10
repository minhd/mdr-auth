<?php

/**
 * returns an array of paginatable reponse
 * page + per_page -> limit & offset
 * per_page is defaulted to 10
 *
 * @param \Illuminate\Http\Request|Request $request
 * @return array
 */
function getPaginationFilters(\Illuminate\Http\Request $request)
{
    $filters = [
        'limit' => 10,
        'offset' => 0
    ];
    $filters['limit'] = $request->input('per_page') ?: $filters['limit'];
    $page = $request->input('page') ?: 1;
    $filters['offset'] = ($page - 1) * $filters['limit'];

    return $filters;
}

/**
 * get Link formatted for use in HTTP Header
 *
 * @param \Illuminate\Contracts\Pagination\LengthAwarePaginator $paginator
 * @return array|string
 */
function getPaginatedLinksForHeader(\Illuminate\Contracts\Pagination\LengthAwarePaginator $paginator)
{
    $pagination = $paginator->toArray();
    $links = [];

    if ($pagination['prev_page_url']) {
        $prev = "<{$pagination['prev_page_url']}>; rel=\"prev\"";
        $links[] = $prev;
    }

    if ($paginator->hasMorePages()) {
        $links[] = "<{$pagination['next_page_url']}>; rel=\"next\"";
    }

    $links[] = "<{$pagination['first_page_url']}>; rel=\"first\"";
    $links[] = "<{$pagination['last_page_url']}>; rel=\"last\"";

    $links = implode(", ", $links);

    return $links;
}

if (!function_exists('base_path')) {
    function schema_path($path)
    {
        return base_path('schemas') . ($path ? DIRECTORY_SEPARATOR . $path : $path);
    }
}