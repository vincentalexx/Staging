<h1>Laporan Keuangan Gardujati</h1>

<table>
    <tr>
        <td>Periode</td>
        <td>{{ $bulan }} {{ date('Y', strtotime($budget->periode)) }}</td>
        <td></td>
        <td rowspan="2">BUDGET BULANAN</td>
        <td rowspan="2">{{ $budget->total_budget_awal }}</td>
    </tr>
    <tr>
        <td>Divisi</td>
        <td>{{ $budget->divisi }}</td>
        <td></td>
    </tr>
</table>

<table>
    <thead>
        <tr>
            <th>Tanggal</th>
            <th>Budget</th>
            <th>Deskripsi</th>
            <th>Jumlah Orang</th>
            <th>Total</th>
            <th>Reimburs</th>
        </tr>
    </thead>
    <tbody>
        @foreach($budgetUsages as $key => $budgetUsage)
        <tr>
            <td>{{ date('d M Y', strtotime($budgetUsage->tanggal)) }}</td>
            <td>{{ $budgetUsage->jenis_budget }}</td>
            <td>{{ $budgetUsage->deskripsi }}</td>
            <td>{{ $budgetUsage->jumlah_orang }}</td>
            <td>{{ $budgetUsage->total }}</td>
            <td>{{ $budgetUsage->reimburs }}</td>
        </tr>
        @endforeach
        <tr>
            <td colspan="3"></td>
            <td>TOTAL</td>
            <td>{{ $budget->total_budget_terpakai }}</td>
            <td>{{ $budget->total_reimburs }}</td>
        </tr>
        <tr>
            <td colspan="3"></td>
            <td>KEBABLASAN</td>
            <td>{{ $budget->kelebihan }}</td>
            <td></td>
        </tr>
        <tr>
            <td colspan="3"></td>
            <td>SISA</td>
            <td>{{ $budget->sisa }}</td>
            <td></td>
        </tr>
    </tbody>
</table>