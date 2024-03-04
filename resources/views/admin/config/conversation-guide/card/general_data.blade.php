<div class="card mb-4">
    <div class="card-header d-flex justify-content-between  bg-corporate-color-light text-corporate-dark-color fw-bold">
        <span class="">
            <i class="fas fa-book me-1"></i>
            Conversation Guide
        </span>
    </div>
    <div class="card-body">

        <div class="row gx-3 mb-4">

            <div class="col-md-6 col-xl-4">
                @include('common.card_field', ['tag' => 'Name', 'value' => $guide->name, 'valueIsBold' => true])
            </div>

            <div class="col-md-6 col-xl-4">
                @include('common.card_field', ['tag' => 'Origin', 'value' => $guide->origin->name])
            </div>

            <div class="col-md-6 col-xl-4">
                @include('common.card_field', ['tag' => 'Language', 'value' => $guide->language->name])
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <hr>
            </div>
        </div>

        <div class="row gx-3 mb-4">

            <a href="{{route('get.admin.config.conversation_guide.edit', $guide->id)}}"
               class="open-modal w-auto"
               data-modal-reload="yes"
               data-reload-type="parent"
               data-modal-title='Edit conversation guide'
               title="Edit conversation guide">
                <i class="fa fa-edit"></i> Edit
            </a>
        </div>

    </div>
</div>
