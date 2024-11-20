<?php

namespace App\Imports;

use App\Models\Member;
use Maatwebsite\Excel\Concerns\ToModel;
use Illuminate\Contracts\Queue\ShouldQueue;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class MemberImport implements ToModel,WithHeadingRow, ShouldQueue, WithChunkReading
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Member([
            'name' => $row['name'],
            'member_code' => $row['member_code'],
            'status' => 1,
            // 'password' => bcrypt($row[2]),
        ]);
    }

    public function chunkSize(): int
    {
        return 100; // Memproses 100 baris setiap kali
    }
}
