<h1>{{ $title }}</h1>

<table>
    <thead>
        <tr>
            <th></th>
            @foreach($discipleshipDetails as $discipleshipDetail)
                <th><strong>{{ $discipleshipDetail->nama_pembinaan }}</strong></th>
            @endforeach
        </tr>
        <tr>
            <th></th>
            @foreach($totalHadir as $total)
                <th><strong>{{ $total }}</strong></th>
            @endforeach
        </tr>
        <tr>
            <th><strong>Jemaat</strong></th>
            @foreach($daysInPeriod as $day)
                <th><strong>{{ date('d/m/Y', strtotime($day)) }}</strong></th>
            @endforeach
        </tr>
    </thead>
    <tbody>
        @foreach($congregations as $key => $congregation)
        <tr>
            <td>{{ $congregation->nama_lengkap }}</td>
            @foreach($daysInPeriod as $key1 => $day)
                @if (!empty($calendarData[$key][$key1]))
                    @if ($calendarData[$key][$key1]->keterangan == null)
                        <td>1</td>
                    @else
                        <td>-1</td>
                    @endif
                @else
                    <td>0</td>
                @endif
            @endforeach
        </tr>
        @endforeach
    </tbody>
</table>