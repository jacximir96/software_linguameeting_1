{{ Form::model($form->model(),  [
          'class' => '',
          'url'=> $form->action(),
          'autocomplete' => 'off',
          'id' =>'contact-us-form',
          'files' => true,
          ]) }}

<div class="row mt-3">
    <div class="col-12">
        @include('common.form-field.text', ['label' => 'Name', 'field' => 'name', 'readonly' => true])
    </div>
</div>

<div class="row mt-3">
    <div class="col-12">
        @include('common.form-field.email', ['label' => 'Email', 'field' => 'email', 'readonly' => true])
    </div>
</div>

<div class="row mt-3">
    <div class="col-12">
        @include('common.form-field.select', [  'field' => 'issue_type_id',
                                               'label' => 'Issue Type',
                                               'optionsField' => 'issueTypeOptions',
                                               'placeholder' => 'Select Issue Type'])
    </div>
</div>

<div class="row mt-3">
    <div class="col-12">
        @include('common.form-field.text', ['label' => 'Summary', 'field' => 'summary'])
    </div>
</div>

<div class="row mt-3">
    <div class="col-12">
        @include('common.form-field.textarea', ['label' => 'Description', 'field' => 'description'])
    </div>
</div>

<div class="row mt-3">
    <div class="col-12 text-600">
        <span class="{{isset($normalText) ? '' : 'fw-bold'}}  mb-2  ">Image</span>
    </div>
    <div class="col-12">
        {{Form::file('issue_file', ['class' => 'profile-image'])}}
    </div>
</div>

<div class="row mt-3">
    <div class="col-12 text-start">
        <button class="btn btn-primary btn-sm btn-bold px-4" type="submit">
            Send
        </button>
    </div>
</div>

{{Form::close()}}
