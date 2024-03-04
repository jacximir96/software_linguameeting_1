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
        <div class="col-3 col-md-3">
            <label class="small fw-bold mb-1 @error('university_id') text-danger @enderror" for="university_id">University</label>
            <div class="form-group row">
                <div class="col-12">
                    {{Form::select('university_id[]', $searchForm->fieldWithOptions('universitiesOptions'), null,
                    [   'class'=>'form-control form-select selectpicker load-child-dropdown-multiple__',
                        'data-child-dropdown-id' => 'course_id',
                        'id' => 'university_id',
                        'data-live-search' => 'true',
                        'data-child-load-url' => route('post.admin.api.options.course.from_multiple_university'),
                        'data-child-placeholder' => 'Select a course',
                        'multiple'
                        ])}}
                </div>
            </div>
        </div>

        <div class="col-3 col-md-3">
            <label class="small fw-bold mb-1 @error('course_id') text-danger @enderror" for="course_id">Course</label>
            <div class="form-group row">
                <div class="col-12">
                    {{Form::select('course_id[]', $searchForm->fieldWithOptions('courseOptions'), null,
                   [   'class'=>'form-control form-select selectpicker',
                       'data-child-dropdown-id' => 'course_id',
                       'data-live-search' => 'true',
                       'id' => 'course_id',
                       'multiple'
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

        <div class="col-12 col-md-3 col-lg-2">
            <label class="small mb-1 fw-bold" for="class_code">Class ID</label>
            {{Form::text('class_code', null, ['class' => 'form-control', 'id' => 'class_code'])}}
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
                    id="btn-clear-students-form-search">
                <i class="fa fa-undo mr-1"></i> Clean
            </button>
        </div>
    </div>

{{Form::close()}}
