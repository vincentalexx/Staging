<?php

return [
    'admin-user' => [
        'title' => 'Users',

        'actions' => [
            'index' => 'Users',
            'create' => 'New User',
            'edit' => 'Edit :name',
            'edit_profile' => 'Edit Profile',
            'edit_password' => 'Edit Password',
        ],

        'columns' => [
            'id' => 'ID',
            'last_login_at' => 'Last login',
            'first_name' => 'First name',
            'last_name' => 'Last name',
            'email' => 'Email',
            'password' => 'Password',
            'password_repeat' => 'Password Confirmation',
            'activated' => 'Activated',
            'forbidden' => 'Forbidden',
            'language' => 'Language',
                
            //Belongs to many relations
            'roles' => 'Roles',
                
        ],
    ],

    'signup' => [
        'title' => 'Pendaftaran',
        'subtitle' => 'Data diri',
    ],

    'user' => [
        'title' => 'User',

        'actions' => [
            'index' => 'User',
            'create' => 'New User',
            'edit' => 'Edit User :name',
            'edit_profile' => 'Edit Profile',
            'edit_password' => 'Edit Password',
        ],

        'columns' => [
            'id' => 'ID',
            'no' => 'No',
            'name' => 'Nama',
            'roles' => 'Role',
            'email' => 'Email',
            'password' => 'Password',
            'password_repeat' => 'Konfirmasi Password',
        ],
    ],

    'congregation' => [
        'title' => 'Jemaat',

        'actions' => [
            'index' => 'Jemaat',
            'create' => 'Tambah Jemaat',
            'edit' => 'Edit :name',
            'export-excel' => 'Export Excel',
        ],

        'columns' => [
            'no' => 'No',
            'id' => 'ID',
            'id_card' => 'ID Card',
            'nama_lengkap' => 'Nama lengkap',
            'jenis_kelamin' => 'Jenis kelamin',
            'angkatan' => 'Angkatan',
            'sekolah' => 'Tempat sekolah/kuliah',
            'tgl_lahir' => 'Tgl lahir',
            'alamat' => 'Alamat',
            'no_wa' => 'No wa',
            'hobi' => 'Hobi',
            'status' => 'Status',
        ],
    ],

    'role' => [
        'title' => 'Role',

        'actions' => [
            'index' => 'Role',
            'create' => 'New Role',
            'edit' => 'Edit :name',
        ],

        'columns' => [
            'id' => 'No',
            'name' => 'Role Name',
            'guard_name' => 'Guard name',
        ],
    ],

    'congregation-attendance' => [
        'title' => 'Absensi Jemaat',

        'actions' => [
            'index' => 'Absensi Jemaat',
            'edit' => 'Edit Absensi Jemaat',
            'export-excel' => 'Export Excel',
        ],

        'columns' => [
            'no' => 'No',
            'keterangan' => 'Keterangan',
            'tanggal' => 'Tanggal',
            'jam_datang' => 'Jam Datang',
            'congregation' => 'Jemaat',
            'tempat_kebaktian' => 'Tempat Kebaktian',
        ],
    ],

    // Do not delete me :) I'm used for auto-generation
];