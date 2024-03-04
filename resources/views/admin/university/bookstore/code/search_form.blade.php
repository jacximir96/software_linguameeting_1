{{ Form::model($searchFormCode->model(),  [
    'class' => 'user',
    'url'=> $searchFormCode->action(),
    'autocomplete' => 'off',
    'id' =>'bookstore-code-search-form'
    ]) }}

<div class="row gx-3 mb-3">

    <div class="col-6">
        <label class="small mb-1 fw-bold @error('code_university_id') text-danger @enderror" for="code_university_id">University</label>
        <div class="form-group row">
            <div class="col-12">
                {{Form::select('code_university_id', $searchFormRequest->universityOptions(), null,
                    [   'class'=>'form-control form-select ',
                        'placeholder' => 'Select University',
                        'id' => 'code_university_id'
                    ])}}
            </div>
        </div>
    </div>

    <div class="col-6">
        <label class="small mb-1 fw-bold @error('code') text-danger @enderror" for="code">Code</label>
        <div class="form-group row">
            <div class="col-12">
                {{Form::text('code', null, ['class' => 'form-control', 'id' => 'code'])}}
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


