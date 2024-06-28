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
        {{ __(':data Data', ['data' => __('All Students')]) }}
    </h1>

    <table class="bordered">
        <thead>
            <th>#</th>
            <th>NPM</th>
            <th>{{ __('Fullname') }}</th>
            <th>{{ __('Gender') }}</th>
            <th>{{ __('Semester') }}</th>
            <th>{{ __('Stamp') }}</th>
            <th>{{ __('Address') }}</th>
            <th>{{ __('Phone Number') }}</th>
            <th>{{ __(':status Status', ['status' => __('Passed')]) }}</th>
        </thead>
        <tbody>
            @forelse ($students as $student)
                <tr>
                    <td class="text-center">
                        {{ $loop->iteration }}
                    </td>
                    <td class="text-center">
                        {{ $student['data']['npm'] }}
                    </td>
                    <td>
                        {{ $student['data']['name'] }}
                    </td>
                    <td class="text-center">
                        {{ $student['data']['gender'] }}
                    </td>
                    <td class="text-center">
                        {{ $student['data']['semester'] }}
                    </td>
                    <td class="text-center">
                        {{ $student['data']['stamp'] }}
                    </td>
                    <td>
                        {{ $student['data']['address'] }}
                    </td>
                    <td class="text-center">
                        {{ $student['data']['phone_number'] }}
                    </td>
                    <td class="text-center">
                        {{ $student['is_passed']['status'] ? __('Passed') : __('Not Yet') }}
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan=8 class="text-center">
                        {{ __('No data found') }}
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

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
