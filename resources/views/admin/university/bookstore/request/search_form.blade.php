{{ Form::model($searchForm->model(),  [
    'class' => 'user',
    'url'=> $searchForm->action(),
    'autocomplete' => 'off',
    'id' =>'bookstore-request-search-form'
    ]) }}

<div class="row gx-3 mb-3">

    <div class="col-12">
        <label class="small mb-1 fw-bold @error('university_id') text-danger @enderror" for="university_id">University</label>
        <div class="form-group row">
            <div class="col-12">
                {{Form::select('university_id', $searchForm->universityOptions(), null,
                    [   'class'=>'form-control form-select ',
                        'placeholder' => 'Select University',
                        'id' => 'university_id'
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
    </div>
</div>
{{Form::close()}}


