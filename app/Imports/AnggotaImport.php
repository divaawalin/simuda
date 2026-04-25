<?php

namespace App\Imports;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class AnggotaImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        // Skip empty rows
        if (empty($row['nama']) || empty($row['email'])) {
            return null;
        }

        // Skip if email already exists
        if (User::where('email', $row['email'])->exists()) {
            return null;
        }

        return new User([
            'name' => $row['nama'],
            'email' => $row['email'],
            'no_telp' => $row['no_hp'] ?? '',
            'divisi' => $row['divisi'] ?? '',
            'status' => $row['status'] ?? 'aktif',
            'role' => 'anggota',
            'password' => Hash::make('password'), // default password
        ]);
    }

    public function rules(): array
    {
        return [
            'nama' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'no_hp' => 'nullable|string|max:20',
            'divisi' => 'nullable|string|max:255',
            'status' => 'nullable|in:aktif,tidak_aktif',
        ];
    }
}
