{{ Form::model($searchForm->model(),  [
    'class' => 'user',
    'url'=> $searchForm->action(),
    'autocomplete' => 'off',
    'id' =>'schedule-course-search-form'
    ]) }}

<div class="row gx-3 mb-3">
    <div class="col-12 col-md-3">
        <label class="small fw-bold mb-1 @error('period') text-danger @enderror" for="period">Weeks</label>
        <div class="form-group row">
            <div class="col-12">
                {{Form::select('period', $searchForm->fieldWithOptions('periodsOptions'), null,
                    [   'class'=>'form-control form-select schedule-period-select ',
                        'id' => 'period'
                        ])}}
            </div>
        </div>
    </div>
</div>
{{Form::close()}}


