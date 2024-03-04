{{ Form::model($searchForm->model(),  [
    'class' => 'user',
    'url'=> $searchForm->action(),
    'autocomplete' => 'off',
    'id' =>'university-search-form'
    ]) }}

<div class="row gx-3 mb-3">

    <div class="col-6 col-md-3 col-xl-2">
        <label class="small fw-bold mb-1" for="name">Name</label>
        {{Form::text('name', null, ['class' => 'form-control', 'id' => 'name'])}}
    </div>

    <div class="col-12 col-md-3 col-xl-2">
        <label class="small mb-1 fw-bold @error('country_id') text-danger @enderror" for="country_id">Country</label>
        <div class="form-group row">
            <div class="col-12">
                {{Form::select('country_id', $searchForm->countryOptions(), null,
                    [   'class'=>'form-control form-select ',
                        'placeholder' => 'Select Country',
                        'id' => 'country_id'
                        ])}}
            </div>
        </div>
    </div>

    <div class="col-12 col-md-3 col-lg-2">
        <label class="small mb-1 fw-bold @error('timezone_id') text-danger @enderror" for="timezone_id">Time zone</label>
        <div class="form-group row">
            <div class="col-12">
                {{Form::select('timezone_id', $searchForm->timezoneOptions(), null,
                    [   'class'=>'form-control form-select ',
                        'placeholder' => 'Select Timezone',
                        'id' => 'timezone_id',
                        ])}}
            </div>
        </div>
    </div>

    <div class="col-12 col-md-3 col-lg-2">
        <label class="small mb-1 fw-bold @error('lingro') text-danger @enderror" for="status">Lingro?</label>
        <div class="form-group row">
            <div class="col-12">
                {{Form::select('lingro', $searchForm->lingroOptions(), null,
                    [   'class'=>'form-control form-select ',
                        'placeholder' => 'Show all',
                        'id' => 'lingro',
                        ])}}
            </div>
        </div>
    </div>

    <div class="col-12 col-md-3 col-lg-2">
        <label class="small mb-1 fw-bold @error('status') text-danger @enderror" for="status">Status</label>
        <div class="form-group row">
            <div class="col-12">
                {{Form::select('status', $searchForm->statusOptions(), null,
                    [   'class'=>'form-control form-select ',
                        'placeholder' => 'Show all',
                        'id' => 'status',
                        ])}}
            </div>
        </div>
    </div>
</div>

<input type="hidden" name="action" value="buscar" id="search-action"/>
<div class="row brc-secondary-l2">
    <div class="col-12 text-center justify-content-between d-flex">
        <button type="submit"
                class="btn btn-primary btn-bold form-control-xs px-4"
                value="Filter">
            <i class="fa fa-search"></i> Filter
        </button>

        <button type="button"
                class="btn btn-secondary btn-bold form-control-xs px-4"
                id="btn-clear-universities-form-search">
            <i class="fa fa-undo mr-1"></i> Clean
        </button>
    </div>
</div>
{{Form::close()}}


