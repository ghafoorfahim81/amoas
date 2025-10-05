<?php

namespace App\Imports;

use App\Models\Tracing\Passport;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class ImpPassportTracing implements ToModel, WithChunkReading, WithHeadingRow, WithMultipleSheets
{
    /**
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        return new Passport([
            'id' => $row['id'],
            'family_name' => $row['family_name'],
            'given_name' => $row['given_names'] ?? $row['given_name'],
            'passport_no' => $row['passport_no'],
            'office' => $row['office'],
            'status' => $row['status'],
            'date' => $row['date'],
        ]);
    }

    public function headingRow(): int
    {
        return 9;
    }

    public function chunkSize(): int
    {
        return 1000;
    }

    public function sheets(): array
    {
        return [
            0 => $this,
        ];
    }
}
