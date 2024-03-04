{{ Form::model($searchForm->model(),  [
    'class' => 'user',
    'url'=> $searchForm->action(),
    'autocomplete' => 'off',
    'id' =>'search-form'
    ]) }}
    <div class="row gx-3 mb-3">

        <div class="col-3 col-md-3 col-xl-2">
            <label class="small mb-1 fw-bold" for="name">Student</label>
            {{Form::text('student', null, ['class' => 'form-control', 'id' => 'student'])}}
        </div>

        <div class="col-3 col-md-3 col-xl-2">
            <label class="small mb-1 fw-bold" for="name">Coach</label>
            {{Form::text('coach', null, ['class' => 'form-control', 'id' => 'coach'])}}
        </div>

        <div class="col-4 col-md-3">
            <label class="small mb-1 fw-bold @error('university_id') text-danger @enderror" for="university_id">University</label>
            <div class="form-group row">
                <div class="col-12">
                    {{Form::select('university_id', $searchForm->fieldWithOptions('universityOptions'), null,
                    [   'class'=>'form-control form-select',
                        'placeholder' => 'Select University',
                        'id' => 'university_id',
                        ])}}
                </div>
            </div>
        </div>

        <div class="col-4 col-md-3">
            <label class="small mb-1 fw-bold @error('review_option_id') text-danger @enderror" for="review_option_id">Review Option</label>
            <div class="form-group row">
                <div class="col-12">
                    {{Form::select('review_option_id', $searchForm->fieldWithOptions('reviewOptions'), null,
                    [   'class'=>'form-control form-select',
                        'placeholder' => 'Select Option',
                        'id' => 'review_option_id',
                        ])}}
                </div>
            </div>
        </div>

        <div class="col-4 col-md-3 col-xl-2">
            <label class="small mb-1 fw-bold @error('review_option_id') text-danger @enderror" for="review_option_id">Stars</label>
            <div class="form-group row">
                <div class="col-12">
                    {{Form::select('stars', $searchForm->fieldWithOptions('starsOptions'), null,
                    [   'class'=>'form-control form-select',
                        'placeholder' => 'Select Stars',
                        'id' => 'stars',
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
                id="btn-clear-reviews-form-search">
            <i class="fa fa-undo mr-1"></i> Clean
        </button>
    </div>
</div>
