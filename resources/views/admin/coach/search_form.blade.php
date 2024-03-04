{{ Form::model($searchForm->model(),  [
    'class' => 'user',
    'url'=> $searchForm->action(),
    'autocomplete' => 'off',
    'id' =>'search-form'
    ]) }}
    <div class="row gx-3 mb-3">

        <div class="col-3 col-md-3">
            <label class="small mb-1 fw-bold" for="name">Name</label>
            {{Form::text('name', null, ['class' => 'form-control', 'id' => 'name'])}}
        </div>

        <div class="col-3 col-md-3">
            <label class="small mb-1 fw-bold" for="name">Last Name</label>
            {{Form::text('lastname', null, ['class' => 'form-control', 'id' => 'lastname'])}}
        </div>

        <div class="col-3 col-md-3">
            <label class="small mb-1 fw-bold" for="name">Email</label>
            {{Form::text('email', null, ['class' => 'form-control', 'id' => 'email'])}}
        </div>

        <div class="col-3 col-md-3">
            <label class="small mb-1 fw-bold @error('status') text-danger @enderror" for="status">Status</label>
            <div class="form-group row">
                <div class="col-12">
                    {{Form::select('status', $searchForm->statusOptions(), null,
                    [   'class'=>'form-control form-select',
                        'placeholder' => 'Show all',
                        'id' => 'status',
                        ])}}
                </div>
            </div>
        </div>

    </div>

    <div class="row gx-3 mb-3">
        <div class="col-4 col-md-3">
            <label class="small mb-1 fw-bold @error('timezone_id') text-danger @enderror" for="timezone_id">Time zone</label>
            <div class="form-group row">
                <div class="col-12">
                    {{Form::select('timezone_id', $searchForm->fieldWithOptions('timezoneOptions'), null,
                    [   'class'=>'form-control form-select',
                        'placeholder' => 'Select Timezone',
                        'id' => 'timezone_id',
                        ])}}
                </div>
            </div>
        </div>

        <div class="col-4 col-md-3">
            <label class="small fw-bold mb-1 @error('language_id') text-danger @enderror" for="language_id">Language</label>
            <div class="form-group row">
                <div class="col-12">
                    {{Form::select('language_id', $searchForm->fieldWithOptions('languageOptions'), null,
                    [   'class'=>'form-control form-select',
                        'placeholder' => 'Select Language',
                        'id' => 'language_id'
                        ])}}
                </div>
            </div>
        </div>

        <div class="col-12 col-md-3">
            <label class="small mb-1 fw-bold @error('country_id') text-danger @enderror" for="country_id">Country</label>
            <div class="form-group row">
                <div class="col-12">
                    {{Form::select('country_id', $searchForm->fieldWithOptions('countryOptions'), null,
                    [   'class'=>'form-control form-select',
                        'placeholder' => 'Select Country',
                        'id' => 'country_id'
                        ])}}
                </div>
            </div>
        </div>

        <div class="col-4 col-md-3">
            <label class="small fw-bold mb-1 @error('role_id') text-danger @enderror" for="role_id">Role</label>
            <div class="form-group row">
                <div class="col-12">
                    {{Form::select('role_id', $searchForm->fieldWithOptions('roleOptions'), null,
                    [   'class'=>'form-control form-select',
                        'placeholder' => 'Select Role',
                        'id' => 'role_id'
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
                id="btn-clear-coaches-form-search">
            <i class="fa fa-undo mr-1"></i> Clean
        </button>
    </div>
</div>
