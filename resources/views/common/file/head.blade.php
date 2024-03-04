@php
    $dataBackground = file_get_contents(public_path('assets/img/background_page_pdf.png'));
           $typeBackground = mime_content_type(public_path('assets/img/background_page_pdf.png'));
           $backgroundBase64 = 'data:' . $typeBackground . ';base64,' . base64_encode($dataBackground);
@endphp
<style>
    @page {
        margin: 1in;
    }
    body {
        font-family: 'Manrope', sans-serif;
        width: 18cm;
    }
    body:before {

        display: block;
        position: fixed;
        top: -2.54cm;
        right: -3cm;
        bottom: -2.54cm;
        left: -3cm;
        background-image: url({{$backgroundBase64}});
        background-repeat: no-repeat;
        background-size: cover;
        content: "";
        z-index: -1000;
    }

    .content{
        position: relative ;
        left: -1cm;
        width: 100%;
    }
    /*
    @page{
        font-family: 'Manrope', Arial, sans-serif;

        size: A4;
        padding-top:0;
        padding-bottom:0;
        padding-left:0;
        padding-right:0;
        margin: 0;
    }
    body{
        font-family: 'Manrope', sans-serif;
        background-image: url({{$backgroundBase64}});
        background-repeat: no-repeat;
        background-size: 210mm 297mm;
    }


    .content{
        padding:2cm 2cm 2cm 2cm;
    }
    */

    .bg-corporate-color-lighter{background-color: #edf4f4 !important;} /*sky blue*/
    .bg-corporate-color-lighter-2{background-color: rgb(237, 244, 244)}
    .text-corporate-color{color: #39b4b3 !important;} /*aqua blue*/
    .text-deep-black{color:#4d4c4c}
    .text-corporate-dark-color{color: #186e74 !important;}
    .section-title{
        color: #186e74 !important;
        font-size:15px;
    }
    .div-section{
        margin-bottom:10px;
        padding:0 5px 0 5px;
    }
    .p-info{
        font-size:14px;
        margin: 2px 0 2px 0;
    }
    ol{
        margin-top:0;
        padding-top:0;
        padding-left:0;
    }
    p{
        margin:0;
        padding:0;
    }
    .number-list{
        display: block;
        float:left;
        width: 15px;
    }
    #logo{
        position:fixed;
        top:-1cm;
        left:-1cm;

    }
</style>

<div id="logo">
    <img src="{{asset('assets/img/logo_transp.png')}}" width="80%" style="width: 40%" >
</div>
