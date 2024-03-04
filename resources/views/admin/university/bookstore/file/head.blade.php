<div style="padding:0;width: 100%;">
    <table border="0" align="center" class=" w-100" cellpadding="0" cellspacing="0">

        <tr>
            <td class="w-25" align="right">
                @if (!empty($rutaImagen))
                    <img src="{{$rutaImagen}}" width="150px">
                @endif
            </td>
            <td class="w-75" align="left"  style="vertical-align: top">
                @if (isset($titulo))
                    <h1 style="color:#8b0000;">{{$titulo}}</h1>
                @endif
            </td>

        </tr>
    </table>
</div>
