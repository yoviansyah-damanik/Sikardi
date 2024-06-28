<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <style>
        html {
            font-size: 11pt;
            font-family: "Times New Roman";
            margin: 1cm;
        }

        h1 {
            font-size: 13pt;
            font-weight: 700;
        }

        div {
            display: block;
        }

        .text-center {
            text-align: center;
        }

        .text-start {
            text-align: left;
        }

        .text-end {
            text-align: right;
        }

        .font-light {
            font-weight: 300;
        }

        .font-semibold {
            font-weight: 500;
        }

        .font-bold {
            font-weight: bold;
        }

        .font-bolder {
            font-weight: bolder;
        }

        .font-lighter {
            font-weight: lighter;
        }

        .text-uppercase {
            text-transform: uppercase;
        }

        table {
            display: table;
            border-spacing: 2px;
            width: 100%;
            text-indent: 0;
            unicode-bidi: isolate;
        }

        table thead {
            vertical-align: middle;
        }

        table tr {
            display: table-row;
            vertical-align: inherit;
            unicode-bidi: isolate;
        }

        table th,
        table td {
            display: table-cell;
            vertical-align: inherit;
            unicode-bidi: isolate;
        }

        table.bordered {
            margin-top: 1rem;
            border-collapse: collapse;
        }

        table.bordered th {
            text-align: center;
        }

        table.bordered td,
        table.bordered th {
            border: 1px solid #ddd;
            padding: 6px;
        }

        table.bordered th {
            padding: 6px;
            background-color: #27647d;
            color: #fff;
        }

        table.bordered td {
            vertical-align: top;
        }

        .page-break {
            page-break-after: always;
        }

        .page-break-inside-avoid {
            page-break-inside: avoid;
        }

        .logo {
            position: relative;
            width: 80px;
        }

        .valign-middle {
            vertical-align: middle !important;
        }

        .underline {
            text-decoration: underline;
        }

        .text-xs {
            font-size: .75em;
        }

        .text-sm {
            font-size: .875em;
        }

        .uppercase {
            text-transform: uppercase
        }

        .italic {
            font-style: italic;
        }

        .p-4 {
            padding: 1rem;
        }

        .border {
            border: 1px solid #ddd;
        }

        .pb-3 {
            padding-bottom: .75rem;
        }

        .mt-3 {
            margin-top: .75rem;
        }

        .mt-4 {
            margin-top: 1rem;
        }

        .mt-5 {
            margin-top: 1.25rem;
        }

        .mt-6 {
            margin-top: 1.5rem;
        }

        .mt-9 {
            margin-top: 2.25rem;
        }

        .mb-3 {
            margin-bottom: .75rem;
        }

        .mb-4 {
            margin-bottom: 1rem;
        }

        .mb-5 {
            margin-bottom: 1.25rem;
        }

        .mb-6 {
            margin-bottom: 1.5rem;
        }

        .mb-9 {
            margin-bottom: 2.25rem;
        }

        .mb-12 {
            margin-bottom: 3rem;
        }

        .mb-16 {
            margin-bottom: 4rem;
        }

        .border-b {
            border-bottom-width: 1px;
        }

        .border-s-0 {
            border-left-width: 0 !important;
        }

        .border-e-0 {
            border-right-width: 0 !important;
        }

        .w-44 {
            width: 11rem;
        }

        .w-1\/5 {
            width: calc(100% / 5);
        }

        .w-2\/5 {
            width: calc(100% * 2 / 5);
        }

        .w-3\/5 {
            width: calc(100% * 3 / 5);
        }

        .w-4\/5 {
            width: calc(100% * 4 / 5);
        }

        .w-1\/2 {
            width: 50%;
        }

        .w-1\/3 {
            width: 33.33%;
        }

        .w-2\/3 {
            width: 66.66%;
        }

        .w-full {
            width: 100%;
        }

        .float-left {
            float: left;
        }

        .float-right {
            float: right;
        }
    </style>
</head>

<body>
    <h1 class="text-center uppercase mb-9">
        {{ __('Course Selection Sheet (CSS)') }}
    </h1>

    <div class="mb-9">
        <div style="clear:both;">
            <div style="width:20%; float:left">
                {{ __('Name') }}
            </div>
            <div style="width:30%; float:left">: {{ $student['name'] }}</div>
            <div style="width:20%; float:left;">
                {{ __('Department') }}
            </div>
            <div style="width:30%; float:left">: Ilmu Komputer</div>
        </div>
        <div style="clear:both;">
            <div style="width:20%; float:left;; float:left">
                {{ __('NPM') }}
            </div>
            <div style="width:30%; float:left">: {{ $student['npm'] }}</div>
            <div style="width:20%; float:left;">
                {{ __('Education Program') }}
            </div>
            <div style="width:30%; float:left">: Strata-I</div>
        </div>
        <div style="clear:both;">
            <div style="width:20%; float:left;; float:left">
                {{ __('Semester') }}
            </div>
            <div style="width:30%; float:left">: {{ $data['semester'] }}</div>
            <div style="width:20%; float:left;">
                {{ __('Academic Year') }}
            </div>
            <div style="width:30%; float:left">: {{ $data['year'] . '/' . ($data['year'] + 1) }}</div>
        </div>
        <div style="clear:both;">
            <div style="width:20%; float:left;; float:left">
                {{ __('Last Semester GP') }}
            </div>
            <div style="width:30%; float:left">: </div>
            <div style="width:20%; float:left;">
                {{ __('Maximum Load') }} {{ __('CC') }}
            </div>
            <div style="width:30%; float:left">: {{ $data['max_load'] }} {{ __('CC') }}</div>
        </div>
    </div>

    <table class="bordered mb-9">
        <thead>
            <th>{{ __('Numb') }}</th>
            <th>{{ __(':code Code', ['code' => __('Course')]) }}</th>
            <th>{{ __(':name Name', ['name' => __('Course')]) }}</th>
            <th>{{ __('CC') }}</th>
            <th>{{ __('Responsible Lecturer') }}</th>
            <th>{{ __('Day') }}</th>
            <th>{{ __('Schedule') }}</th>
            <th>{{ __('Room') }}</th>
            <th>{{ __('Explanation') }}</th>
        </thead>
        <tbody>
            @foreach ($data['details'] as $detail)
                <tr>
                    <td class="text-center">
                        {{ $loop->iteration }}
                    </td>
                    <td class="text-center">
                        {{ $detail['course_code'] }}
                    </td>
                    <td>
                        {{ $detail['course'] }}
                    </td>
                    <td class="text-center">
                        {{ $detail['cc'] }}
                    </td>
                    <td>
                        {{ $detail['lecturer'] }}
                    </td>
                    <td class="text-center">
                        {{ $detail['day'] }}
                    </td>
                    <td class="text-center">
                        {{ $detail['start_time'] }} -
                        {{ $detail['end_time'] }}
                    </td>
                    <td class="text-center">
                        {{ $detail['room_code'] }}
                    </td>
                    <td></td>
                </tr>
            @endforeach
            <tr class="font-semibold text-white !bg-primary-700">
                <td class="text-end" colspan=3>
                    {{ __(':total Total', ['total' => __('CC')]) }}
                </td>
                <td class="text-center">
                    {{ $data['cc_total'] }}
                </td>
                <td colspan="5"></td>
            </tr>
        </tbody>
    </table>

    <div style="clear:both;">
        <div style="width: 30%; float:left;" class="font-bold">
            Mengetahui,<br />
            Ketua Program Studi
            <br />
            <br />
            <br />
            <br />
            <div class="underline">
                {{ GeneralHelper::nameOfDepartmentHead() }}
            </div>
            NIDN. {{ GeneralHelper::nidnOfDepartmentHead() }}
        </div>
        <div style="width: 5%; float:left;"></div>
        <div style="width: 30%; float:left;" class="font-bold">
            Dosen Pembimbing Akademik
            <br />
            <br />
            <br />
            <br />
            <br />
            <div class="underline">
                {{ $supervisor['name'] }}
            </div>
            NIDN. {{ $supervisor['nidn'] }}
        </div>
        <div style="width: 5%; float:left;"></div>
        <div style="width: 30%; float:left;" class="font-bold">
            Padangsidimpuan, {{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}<br />
            Mahasiswa
            <br />
            <br />
            <br />
            <br />
            <div class="underline">
                {{ $student['name'] }}
            </div>
            NPM. {{ $student['npm'] }}
        </div>
    </div>
    <script type="text/php">
        if ( isset($pdf) ) {
            $x = 30;
            $x_2 = 787;
            $x_3 = 600;
            $y = 568;

            $text = "Diakses melalui ".url('/')." | ". env('APP_NAME') ." | ". \Carbon\Carbon::now()->translatedFormat('d F Y H:i:s');
            $text_2 = "{PAGE_NUM} / {PAGE_COUNT}";
            $font = $fontMetrics->get_font("Times New Roman");
            $size = 8;
            $color = array(0,0,0);
            $word_space = 0.0;  //  default
            $char_space = 0.0;  //  default
            $angle = 0.0;   //  default
            $pdf->page_text($x, $y, $text, $font, $size, $color, $word_space, $char_space, $angle);
            $pdf->page_text($x_2, $y, $text_2, $font, $size, $color, $word_space, $char_space, $angle);
        }
    </script>
</body>

</html>
