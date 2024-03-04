{{ Form::model($searchForm->model(),  [
    'class' => 'user',
    'url'=> $searchForm->action(),
    'autocomplete' => 'off',
    'id' =>'notification-search-form'
    ]) }}

<div class="row gx-2 mb-3">

    <div class="col-3 col-md-3 col-xl-2">
        <label class="small fw-bold mb-1 @error('specific_date') text-danger @enderror" for="specific_date">Start Date</label>
        <div class="form-group row">

            <div class="col-12">
                {{Form::date('start_date', null, ['class' => 'form-control field-date', 'id' => 'start_date'])}}

                @error('start_date')
                <span class="custom-invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
        </div>
    </div>

    <div class="col-3 col-md-3 col-xl-2">
        <label class="small fw-bold mb-1 @error('specific_date') text-danger @enderror" for="specific_date">End Date</label>
        <div class="form-group row">

            <div class="col-12">
                {{Form::date('end_date', null, ['class' => 'form-control field-date', 'id' => 'end_date'])}}

                @error('end_date')
                <span class="custom-invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
        </div>
    </div>

    <div class="col-3 col-md-3 col-xl-2">
        <label class="small fw-bold mb-1 @error('specific_date') text-danger @enderror" for="specific_date">Specific Dates</label>
        <div class="form-group row">

            <div class="col-12">
                {{Form::select('specific_date', $searchForm->fieldWithOptions('specificDatesOptions'), null,
                [   'class'=>'form-control form-select',
                    'id' => 'specific_date',
                    'placeholder' => 'Select Specific Dates',
                    ])}}
            </div>
        </div>
    </div>
</div>

<div class="row gx-3 mb-3 mt-2">
    <div class="col-3 col-md-3 col-xl-2">
        <label class="small fw-bold mb-1 @error('level_id') text-danger @enderror" for="level_id">Level</label>
        <div class="form-group row">
            <div class="col-12">
                {{Form::select('level_id', $searchForm->fieldWithOptions('levelOptions'), null,[
                    'class'=>'form-control form-select load-child-dropdown',
                    'id' => 'level_id',
                    'data-child-dropdown-id' => 'type_id',
                    'data-child-load-url' => route('get.admin.api.options.notification.type_from_level'),
                    'data-child-placeholder' => 'Select Type',
                    'placeholder' => 'Select Level',
                    ])}}
            </div>
        </div>
    </div>

    <div class="col-3 col-md-3 col-xl-2">
        <label class="small fw-bold mb-1 @error('type_id') text-danger @enderror" for="type_id">Type</label>
        <div class="form-group row">
            <div class="col-12">
                {{Form::select('type_id', $searchForm->fieldWithOptions('typeOptions'), null,
                [   'class'=>'form-control form-select',
                    'id' => 'type_id',
                    'placeholder' => 'Select Type',
                    ])}}
            </div>
        </div>
    </div>


    <div class="col-3 col-md-3 col-xl-2">
        <label class="small fw-bold mb-1 @error('read_status') text-danger @enderror" for="read_status">Read Status</label>
        <div class="form-group row">
            <div class="col-12">
                {{Form::select('read_status', $searchForm->fieldWithOptions('readStatusOptions'), null,
                [   'class'=>'form-control form-select',
                    'id' => 'read_status',
                    'placeholder' => 'Select Read Status',
                    ])}}
            </div>
        </div>
    </div>
</div>

<input type="hidden" name="action" value="buscar" id="search-action"/>
<div class="row brc-secondary-l2">
    <div class="col-12 text-center justify-content-between d-flex">

        <button type="submit"
                class="btn btn-primary btn-bold form-control-xs px-4 me-5"
                name="action"
                value="filter">
            <i class="fa fa-search"></i> Filter
        </button>

        <div>
            <button type="submit"
                    class="btn btn-success btn-bold form-control-xs px-4 me-5"
                    name="action"
                    value="mark_read">
                <i class="fa fa-check"></i> Reall All
            </button>

            <button type="submit"
                    class="btn btn-warning btn-bold text-white form-control-xs px-4 me-5"
                    name="action"
                    value="mark_unread">
                <i class="fa fa-check"></i> Unreall All
            </button>
        </div>

        <button type="button"
                class="btn btn-secondary btn-bold form-control-xs px-4"
                id="btn-clear-notification-form-search">
            <i class="fa fa-undo mr-1"></i> Clean
        </button>
    </div>
</div>

{{Form::close()}}
