<?php

namespace App\Imports;

use App\Models\Siswa;
use Endroid\QrCode\QrCode;
use Maatwebsite\Excel\Concerns\ToModel;

class SiswaImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row,)
    {
        
        $nis = $row[0];

        if (!is_numeric($nis)) {
            // Tindakan yang sesuai jika 'nis' bukan numerik
            return null;
        }
    
        return new Siswa([
            'nis' => $nis,
            'nama' => $row[1],
            'id_jurusan' => $row[2],
        ]);

       
    }

}
