@include('admin.section.file.instructions.title_section', ['title' => 'Creating a new account'])

<table border="0" align="left" class="w-100 " cellpadding="0" cellspacing="0" >

     <tr>
        <td align="left">
            <p class="text-deep-black p-info mb-5">
                <span class="number-list">1.</span>
                Go to: <a href="#" class="text-corporate-color"> Go to: http://develop.linguameeting.com/codeRegister/{{$viewData->section()->code}}</a>.
            </p>

            <p class="text-deep-black p-info mb-5">
                <span class="number-list">2.</span>
                Create an account.
            </p>

            <p class="text-deep-black p-info mb-5">
                <span class="number-list">3.</span>
                3. Book your sessions by selecting a day & time for each one of them
            </p>
        </td>
    </tr>
</table>


@include('admin.section.file.instructions.title_section', ['title' => 'Already have an account?'])

<table border="0" align="left" class="w-100 table-instructions" cellpadding="0" cellspacing="0">

     <tr>
        <td align="left">
            <p class="text-deep-black p-info mb-5">
                <span class="number-list">1.</span>
                Login with your username and password from the previous semester.
            </p>
            <p class="text-deep-black p-info mb-5">
                <span class="number-list">2.</span>
                Select "Add new course" in your dashboard and enter your respective Class ID.
            </p>
        </td>
    </tr>
</table>


@include('admin.section.file.instructions.title_section', ['title' => 'Joining your Session'])

<table border="0" align="left" class="w-100 table-instructions" cellpadding="0" cellspacing="0">

     <tr>
        <td align="left">
            <p class="text-deep-black p-info mb-5">
                <span class="number-list">1.</span>
                Go to linguameeting.com and login using your username and password.
            </p>
            <p class="text-deep-black p-info mb-5">
                <span class="number-list">2.</span>
                Click "View Course".
            </p>
            <p class="text-deep-black p-info mb-5">
                <span class="number-list">3.</span>
                Click on the "Join session" button in the "Today" tab.
            </p>
        </td>
    </tr>
</table>
