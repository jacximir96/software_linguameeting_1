{{ Form::model($searchForm->model(),  [
    'class' => 'user',
    'url'=> $searchForm->action(),
    'autocomplete' => 'off',
    'id' =>'ranking-search-form'
    ]) }}


    <div class="row gx-3 mb-3">

        <div class="col-4 col-md-3">
            <label class="small fw-bold mb-1 @error('language_id') text-danger @enderror" for="language_id">Language</label>
            <div class="form-group row">
                <div class="col-12">
                    {{Form::select('language_id', $searchForm->optionsField('languageOptions'), null,
                    [   'class'=>'form-control form-select',
                        'placeholder' => 'Select Language',
                        'id' => 'language_id'
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
