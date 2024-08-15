<?php

namespace App\Imports;

use App\Models\Mahasiswa;
use Illuminate\Support\Str;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class MahasiswaImport implements ToCollection, WithHeadingRow, WithValidation
{
    public $duplicateNims = [];
    public $invalidHeaders = false;

    /**
    * @param Collection $rows
    */
    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
            if (Mahasiswa::where('nim', $row['nim'])->exists()) {
                $this->duplicateNims[] = $row['nim'];
            } else {
                Mahasiswa::create([
                    'id' => Str::random(16),
                    'nama' => $row['nama'],
                    'nim' => $row['nim'],
                    'prodi' => $row['prodi'],
                    'angkatan' => $row['angkatan'],
                    'username' => $row['username'],
                    'email' => $row['email'],
                ]);
            }
        }
    }

    public function getDuplicateNims()
    {
        return $this->duplicateNims;
    }

    public function rules(): array
    {
        return [
            '*.nama' => 'required',
            '*.nim' => 'required',
            '*.prodi' => 'required',
            '*.angkatan' => 'required',
            '*.username' => 'required',
            '*.email' => 'required|email',
        ];
    }

    public function prepareForValidation($data, $index)
    {
        $expectedHeaders = ['nama', 'nim', 'prodi', 'angkatan', 'username', 'email'];

        foreach ($expectedHeaders as $header) {
            if (!array_key_exists($header, $data)) {
                $this->invalidHeaders = true;
            }
        }

        return $data;
    }

    public function getInvalidHeaders()
    {
        return $this->invalidHeaders;
    }
}