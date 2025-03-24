<?php

namespace App\Imports;

use App\Models\Player;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class PlayersImport implements ToModel, WithHeadingRow
{
    protected $team_id;

    // Constructor để nhận team_id
    public function __construct($team_id)
    {
        $this->team_id = $team_id;
    }

    // Phương thức model để xử lý từng dòng dữ liệu
    public function model(array $row)
    {
        \Log::info('Importing row', $row);

        if (!isset($row['ten']) || empty(trim($row['ten']))) {
            \Log::error('Import error: Missing name', ['row' => $row]);
            return null;
        }
        return new Player([
            'team_id' => $this->team_id, // Sử dụng team_id từ thuộc tính
            'name' => $row['ten'], // Tên cầu thủ
            'age' => is_numeric($row['tuoi']) ? (int) $row['tuoi'] : null, // Tuổi
            'position' => $row['vi_tri'], // Vị trí
            'jersey_number' => is_numeric($row['so_ao']) ? (int) $row['so_ao'] : null, // Số áo
            'email' => $row['email'], // Email
        ]);
    }
}