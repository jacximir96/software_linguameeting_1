{{ Form::model($searchForm->model(),  [
    'class' => 'user',
    'url'=> $searchForm->action(),
    'autocomplete' => 'off',
    'id' =>'university-search-form'
    ]) }}

<div class="row gx-3 mb-3">

    <div class="col-6 col-md-3 col-lg-2">
        <label class="small fw-bold mb-1" for="name">Name</label>
        {{Form::text('name', null, ['class' => 'form-control', 'id' => 'name'])}}
    </div>

    <div class="col-6 col-md-3 col-lg-2">
        <label class="small fw-bold mb-1" for="name">Year</label>
        {{Form::number('year', null, ['class' => 'form-control', 'id' => 'number', 'min' => 2021, 'step' => 1])}}
    </div>

    <div class="col-6 col-md-3 col-lg-2">
        <label class="small fw-bold mb-1" for="name">Start Date</label>
        {{Form::date('start_date', null, ['class' => 'form-control', 'id' => 'start_date'])}}
    </div>

    <div class="col-6 col-md-3 col-lg-2">
        <label class="small fw-bold mb-1" for="name">End Date</label>
        {{Form::date('end_date', null, ['class' => 'form-control', 'id' => 'end_date'])}}
    </div>

    <div class="col-12 col-md-3 col-lg-2">
        <label class="small fw-bold mb-1 @error('status') text-danger @enderror" for="university_id">Status</label>
        <div class="form-group row">
            <div class="col-12">
                {{Form::select('status', $searchForm->fieldWithOptions('statusOptions'), null,
                    [   'class'=>'form-control form-select ',
                        'placeholder' => 'All',
                        'id' => 'status'
                        ])}}
            </div>
        </div>
    </div>

    <div class="col-12 col-md-3 col-lg-2">
        <label class="small mb-1 fw-bold @error('lingro') text-danger @enderror" for="status">Lingro?</label>
        <div class="form-group row">
            <div class="col-12">
                {{Form::select('is_lingro', $searchForm->fieldWithOptions('lingroOptions'), null,
                    [   'class'=>'form-control form-select ',
                        'placeholder' => 'Show all',
                        'id' => 'lingro',
                        ])}}
            </div>
        </div>
    </div>
</div>

<div class="row gx-3 mb-3">
    <div class="col-12 col-md-3">
        <label class="small fw-bold mb-1 @error('university_id') text-danger @enderror" for="university_id">University</label>
        <div class="form-group row">
            <div class="col-12">
                {{Form::select('university_id', $searchForm->fieldWithOptions('universityOptions'), null,
                    [   'class'=>'form-control form-select ',
                        'placeholder' => 'Select University',
                        'id' => 'university_id'
                        ])}}
            </div>
        </div>
    </div>

    <div class="col-12 col-md-3 col-lg-2">
        <label class="small fw-bold mb-1 @error('language_id') text-danger @enderror" for="language_id">Language</label>
        <div class="form-group row">
            <div class="col-12">
                {{Form::select('language_id', $searchForm->fieldWithOptions('languageOptions'), null,
                    [   'class'=>'form-control form-select ',
                        'placeholder' => 'Select Language',
                        'id' => 'language_id'
                        ])}}
            </div>
        </div>
    </div>

    <div class="col-12 col-md-3 col-lg-2">
        <label class="small fw-bold mb-1 @error('semester_id') text-danger @enderror" for="semester_id">Semester</label>
        <div class="form-group row">
            <div class="col-12">
                {{Form::select('semester_id', $searchForm->fieldWithOptions('semesterOptions'), null,
                    [   'class'=>'form-control form-select ',
                        'placeholder' => 'Select Semester',
                        'id' => 'semester_id'
                        ])}}
            </div>
        </div>
    </div>

    <div class="col-12 col-md-3 col-lg-2">
        <label class="small fw-bold mb-1 @error('service_type_id') text-danger @enderror" for="semester_id">Service</label>
        <div class="form-group row">
            <div class="col-12">
                {{Form::select('service_type_id', $searchForm->fieldWithOptions('serviceTypeOptions'), null,
                    [   'class'=>'form-control form-select ',
                        'placeholder' => 'Select Service',
                        'id' => 'service_type_id'
                        ])}}
            </div>
        </div>
    </div>

    <div class="col-12 col-md-3 col-lg-2">
        <label class="small fw-bold mb-1 @error('level_id') text-danger @enderror" for="level_id">Level</label>
        <div class="form-group row">
            <div class="col-12">
                {{Form::select('level_id', $searchForm->fieldWithOptions('levelOptions'), null,
                    [   'class'=>'form-control form-select ',
                        'placeholder' => 'Select Level',
                        'id' => 'level_id'
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
                id="btn-clear-courses-form-search">
            <i class="fa fa-undo mr-1"></i> Clean
        </button>
    </div>
</div>
{{Form::close()}}


