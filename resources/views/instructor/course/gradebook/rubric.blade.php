<div class="row mt-3">

    <div class="col-12">
        <table class="table table-responsive table-bordered table-striped small">
            <thead>
            <tr class="fw-bold">
                <td class="text-center w-25 bg-gray"></td>
                <td class="text-center w-25 table-success">VERY GOOD (3)</td>
                <td class="text-center w-25 table-warning">ACCEPTABLE (2)</td>
                <td class="text-center w-25 table-danger">NOT ACCEPTABLE (1)</td>
            </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="table-light fw-bold">PUNCTUALITY</td>
                    <td class="table-success text-center">
                        {{$rubric->instructorDescription(
                            \App\Src\CourseDomain\SessionDomain\StudentReviewType\Model\PunctualityType::DESCRIPCION,
                            config('linguameeting.session.rubric.levels.good.key')
                            )}}
                    </td>
                    <td class="table-warning text-center">
                        {{$rubric->instructorDescription(
                            \App\Src\CourseDomain\SessionDomain\StudentReviewType\Model\PunctualityType::DESCRIPCION,
                            config('linguameeting.session.rubric.levels.acceptable.key')
                            )}}
                    </td>
                    <td class="bg-corporate-color-light text-center">
                        {{$rubric->instructorDescription(
                            \App\Src\CourseDomain\SessionDomain\StudentReviewType\Model\PunctualityType::DESCRIPCION,
                            config('linguameeting.session.rubric.levels.not_acceptable.key')
                            )}}
                    </td>
                </tr>

                <tr>
                    <td class="bg-gray fw-bold">PREPARED FOR CLASS</td>
                    <td class="table-success text-center">
                        {{$rubric->instructorDescription(
                            \App\Src\CourseDomain\SessionDomain\StudentReviewType\Model\PreparedClassType::DESCRIPCION,
                            config('linguameeting.session.rubric.levels.good.key')
                            )}}
                    </td>
                    <td class="table-warning text-center">
                        {{$rubric->instructorDescription(
                            \App\Src\CourseDomain\SessionDomain\StudentReviewType\Model\PreparedClassType::DESCRIPCION,
                            config('linguameeting.session.rubric.levels.acceptable.key')
                            )}}
                    </td>
                    <td class="bg-corporate-color-light text-center">
                        {{$rubric->instructorDescription(
                            \App\Src\CourseDomain\SessionDomain\StudentReviewType\Model\PreparedClassType::DESCRIPCION,
                            config('linguameeting.session.rubric.levels.not_acceptable.key')
                            )}}
                    </td>
                </tr>

                <tr>
                    <td class="bg-gray fw-bold">PREPARED FOR CLASS</td>
                    <td class="table-success text-center">
                        {{$rubric->instructorDescription(
                            \App\Src\CourseDomain\SessionDomain\StudentReviewType\Model\ParticipationType::DESCRIPCION,
                            config('linguameeting.session.rubric.levels.good.key')
                            )}}
                    </td>
                    <td class="table-warning text-center">
                        {{$rubric->instructorDescription(
                            \App\Src\CourseDomain\SessionDomain\StudentReviewType\Model\ParticipationType::DESCRIPCION,
                            config('linguameeting.session.rubric.levels.acceptable.key')
                            )}}
                    </td>
                    <td class="bg-corporate-color-light text-center">
                        {{$rubric->instructorDescription(
                            \App\Src\CourseDomain\SessionDomain\StudentReviewType\Model\ParticipationType::DESCRIPCION,
                            config('linguameeting.session.rubric.levels.not_acceptable.key')
                            )}}
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
