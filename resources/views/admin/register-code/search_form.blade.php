{{ Form::model($searchForm->model(),  [
    'class' => 'user',
    'url'=> $searchForm->action(),
    'autocomplete' => 'off',
    'id' =>'register-code-search-form'
    ]) }}
    <div class="row gx-3 mb-3">

        <div class="col-3 col-md-3">
            <label class="small mb-1 fw-bold" for="name">Code</label>
            {{Form::text('code', null, ['class' => 'form-control', 'id' => 'code'])}}
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
                    id="btn-clear-register-codes-form-search">
                <i class="fa fa-undo mr-1"></i> Clean
            </button>
        </div>
    </div>
{{Form::close()}}
