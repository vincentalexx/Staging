<h1>Data Jemaat Remaja/Pemuda Beat GII Gardujati tahun {{ date('Y') }}-{{ date('Y') + 1 }}</h1>
<table>
    <thead>
        <tr>
            <th>No</th>
            <th>Nama lengkap</th>
            <th>Jenis Kelamin</th>
            <th>Kelas Sekarang</th>
            <th>Tgl. Lahir</th>
            <th>Alamat</th>
            <th>No. WA</th>
            <th>Hobi</th>
        </tr>
    </thead>
    <tbody>
        @foreach($data as $key => $d)
        <tr>
            <td>{{ $key+1 }}</td>
            <td>{{ $d->nama_lengkap }}</td>
            <td>{{ $d->jenis_kelamin == 'laki_laki' ? 'Laki-laki' : 'Perempuan' }}</td>
            <td>{{ $d->kelas }}</td>
            <td>{{ date('d M Y', strtotime($d->tgl_lahir)) }}</td>
            <td>{{ $d->alamat }}</td>
            <td>{{ $d->no_wa }}</td>
            <td>{{ $d->hobi }}</td>
        </tr>
        @endforeach
    </tbody>
</table>