<div class="container-fluid mt-0">
    <div class="row">
        <div class="col-12 shadow-sm rounded" style="border-bottom: 1px solid #35b4b4;">
            <div class=" mt-2 p-2">
                <nav class="" aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 d-none d-md-flex">
                        @foreach ($breadcrumb->all() as $item)

                            @if ($item->isLink())
                                <li class="breadcrumb-item">
                                    <a href="{{$item->link()->url()}}" class="text-corporate-color fw-bold" title="{{$item->link()->title()}}">{{$item->link()->text()}}</a>
                                </li>
                            @else
                                <li class="breadcrumb-item active  fst-italic text-corporate-color fw-bold" aria-current="page">
                                     {{$item->write()}}
                                </li>
                            @endif

                        @endforeach
                    </ol>

                    <div class="row d-block d-md-none">

                        @foreach ($breadcrumb->all() as $item)

                            @if ($item->isLink())
                                <div class="col-12 abreadcrumb-item">
                                    <i class="fa fa-chevron-right text-corporate-color small"></i> <a href="{{$item->link()->url()}}" class="text-corporate-color " title="Go to dashboard">{{$item->link()->text()}}</a>
                                </div>
                            @else
                                <div class="col-12  fst-italic text-corporate-color fw-bold" aria-current="page">
                                    <i class="fa fa-chevron-right text-corporate-color small"></i> {{$item->write()}}
                                </div>
                            @endif

                        @endforeach

                    </div>

                </nav>
            </div>
        </div>
    </div>
</div>
