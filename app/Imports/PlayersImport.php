<?php

namespace App\Imports;

use App\Models\Player;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class PlayersImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        return new Player([
            'team_id'       => request()->route('teamId'), // Lấy team_id từ route
            'name'          => $row['ten'],  // Cột "Tên" trong file Excel
            'age'           => is_numeric($row['tuoi']) ? (int)$row['tuoi'] : null, // Đảm bảo là số
            'position'      => $row['vi_tri'],
            'jersey_number' => is_numeric($row['so_ao']) ? (int)$row['so_ao'] : null,
            'email'         => $row['email'],
        ]);
    }
}
