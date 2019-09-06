<?php

namespace App\Imports;

use App\Question;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Illuminate\Http\Request;

class QuestionImport implements ToModel, WithBatchInserts, WithChunkReading
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {

        return new Question([
            'course_id' => $row[0] = $this->request('course_id'),
            'section_id' => $row[1] = $this->request('section_id'),
            'question' => $row[3],
            'option_a' => $row[4],
            'option_b' => $row[5],
            'option_c' => $row[6],
            'option_d' => $row[7],
            'answer' => $row[8]
        ]);
    }

    public function batchSize(): int
    {
        return 1000;
    }

    public function chunkSize(): int
    {
        return 1000;
    }
}
