@extends('layouts.app')

@section('content')


    <div class="card my-3">
        <div class="card-header d-flex flex-row align-items-center justify-content-between bg-corporate-color-light text-corporate-dark-color fw-bold">
            <h6 class="m-0 font-weight-bold"><i class="fa fa-search"></i> Search Coaches</h6>
        </div>
        <div class="card-body">
            @include('admin.coach.ranking.search_form')
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-header d-flex justify-content-between bg-corporate-color-light text-corporate-dark-color fw-bold">
            <span class="">
                <i class="fas fa-sort-numeric-up-alt me-1"></i>
                {{$language->name}} Ranking
            </span>
        </div>
        <div class="card-body">

            <div class="row">

                <div class="col-12 col-xl-8 table-responsive">
                    <table id="" class="table table-hover" data-paging="false" data-searching="false" data-ordering="false">
                        <thead>
                        <tr class="small">
                            <th class="w-40">Coach</th>
                            <th>Ranking</th>
                            <th>Preference</th>
                        </tr>
                        </thead>

                        <tbody>

                        @forelse ($coaches as $coach)
                            <tr>
                                <td class="text-left">
                                    {{$coach->writeFullName()}}
                                </td>
                                <td class="text-left">

                                    {{Form::select('ranking', $rankingForm->optionsField('rankingOptions'), $coach->coachInfo->ranking,
                                        [   'class'=>'form-control form-select select-update-ranking',
                                            'data-update-url' => route('post.admin.coach.ranking.update', [$coach->hashId(), 'ranking']),
                                            'placeholder' => 'Select Ranking',
                                        ])}}
                                </td>
                                <td class="text-left">
                                    {{Form::select('ranking', $rankingForm->optionsField('preferenceOptions'), $coach->coachInfo->preference,
                                        [   'class'=>'form-control form-select select-update-ranking',
                                            'data-update-url' => route('post.admin.coach.ranking.update', [$coach->hashId(), 'preference']),
                                            'placeholder' => 'Select preference',
                                        ])}}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3">
                                    <span class=" text-white bg-warning px-2 py-1 rounded ">No coaches found</span>
                                </td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>

            </div>



        </div>
    </div>

@endsection
