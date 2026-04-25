<?php

return [
    'accepted' => ':attribute harus diterima.',
    'active_url' => ':attribute bukan URL yang valid.',
    'after' => ':attribute harus berisi tanggal setelah :date.',
    'alpha' => ':attribute hanya boleh berisi huruf.',
    'alpha_dash' => ':attribute hanya boleh berisi huruf, angka, strip, dan garis bawah.',
    'alpha_num' => ':attribute hanya boleh berisi huruf dan angka.',
    'array' => ':attribute harus berupa sebuah array.',
    'before' => ':attribute harus berisi tanggal sebelum :date.',
    'between' => [
        'numeric' => ':attribute harus bernilai antara :min dan :max.',
        'file' => ':attribute harus berukuran antara :min dan :max kilobita.',
        'string' => ':attribute harus berisi antara :min dan :max karakter.',
        'array' => ':attribute harus memiliki :min sampai :max anggota.',
    ],
    'boolean' => ':attribute harus bernilai true atau false.',
    'confirmed' => 'Konfirmasi :attribute tidak cocok.',
    'date' => ':attribute bukan tanggal yang valid.',
    'email' => ':attribute harus berupa alamat email yang valid.',
    'exists' => ':attribute yang dipilih tidak valid.',
    'filled' => ':attribute wajib diisi.',
    'image' => ':attribute harus berupa gambar.',
    'in' => ':attribute yang dipilih tidak valid.',
    'integer' => ':attribute harus berupa bilangan bulat.',
    'max' => [
        'numeric' => ':attribute seharusnya tidak lebih dari :max.',
        'file' => ':attribute seharusnya tidak lebih dari :max kilobita.',
        'string' => ':attribute seharusnya tidak lebih dari :max karakter.',
        'array' => ':attribute seharusnya tidak lebih dari :max anggota.',
    ],
    'mimes' => ':attribute harus berupa berkas berjenis: :values.',
    'min' => [
        'numeric' => ':attribute harus minimal :min.',
        'file' => ':attribute harus minimal :min kilobita.',
        'string' => ':attribute harus minimal :min karakter.',
        'array' => ':attribute harus memiliki minimal :min anggota.',
    ],
    'required' => ':attribute wajib diisi.',
    'unique' => ':attribute sudah ada sebelumnya.',
    'url' => 'Format :attribute tidak valid.',

    'custom' => [
        'attribute-name' => [
            'rule-name' => 'custom-message',
        ],
    ],

    'attributes' => [
        'username' => 'Username',
        'email' => 'Alamat Email',
        'password' => 'Kata Sandi',
        'phone' => 'Nomor Telepon',
        'name' => 'Nama Lengkap',
    ],
];
