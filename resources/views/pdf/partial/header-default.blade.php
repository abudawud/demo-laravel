<div>
    <table style="padding: 0px;margin: 0px;" width="100%">
        <tr>
            <td align="center" width="25%">
                <img src="{{ asset('assets/img/logo.png') }}" height="60px">
            </td>
            <td width="40%">
                <div><strong>{{ config('app.company_name') }}</strong></div>
                <div style="font-size: 10pt;margin-top: 3px;">{{ config('app.company_address') }}</div>
                <div style="font-size: 10pt;">{{ config('app.company_location' )}}</div>
            </td>
            <td width="30%">
                @if (isset($doc_no) || isset($doc_date))
                    <table width="100%" style="font-size: 11px;padding: 0px;margin: 0px;" class="table-bordered">
                        <tr>
                            <td width="110px">No. Dokumen</td>
                            <td>{{ $doc_no ?? '' }}</td>
                        </tr>
                        <tr>
                            <td>Tanggal mulai berlaku</td>
                            <td>{{ $doc_date ?? '' }}</td>
                        </tr>
                        <tr>
                            <td>Rev : {{ $doc_rev ?? 1 }}</td>
                            <td>Hal: 1 Dari: 1</td>
                        </tr>
                    </table>
                @endif
            </td>
        </tr>
    </table>
    <div class="head-title">
        <strong>{{ $doc_title ?? '' }}</strong>
    </div>
</div>
