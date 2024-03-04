@php
    $parametrosUri = request()->except(['_token']) ;
    $parametrosOrden = ['sortBy' => $field, 'sortDirection' => $orderListing->nextDirection($field)];

    $uriParameters = array_merge ($parametrosUri, $parametrosOrden);
@endphp

<a href="{{route($path, $uriParameters) }}" title="Change order to {{$orderListing->nextDirectionIsAsc($field) ? 'asc' : 'desc'}}">{{$tag}}</a>

@if ($orderListing->searchByField($field))

    @if ($orderListing->isAsc())
        <span class="text-muted fst-italic small">asc</span>
    @else
        <span class="text-muted fst-italic small">desc</span>
    @endif
@endif
