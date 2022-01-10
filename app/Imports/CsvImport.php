<?php

namespace App\Imports;

use App\Models\Contact;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

class CsvImport implements ToCollection, WithStartRow
{

    public static $startRow = 2; // csvの1行目にヘッダがあるので2行目から取り込む

    /**
    * @param Collection $collection
    */
    public function collection(Collection $rows)
    {
        Validator::make($rows->toArray(), [
            '*.0' => "required|string", // 名前
            '*.1' => "required|unique:users", // メールアドレス
            '*.2' => "required|min:8", // カタログ掲載ページ（かんま区切り）
        ])->validate();

        foreach ($rows as $row) {
            Contact::create([
                'name' => $row[0], // 行の1列目
                'email' => $row[1], // 行の2列目
                'password' => bcrypt($row[2]), // 行の3列目
            ]);
        }
    }

    /**
     * @return int
     */
    public function startRow(): int
    {
        return self::$startRow;
    }
}
