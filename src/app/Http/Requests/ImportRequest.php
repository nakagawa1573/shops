<?php

namespace App\Http\Requests;

use App\Rules\CsvAreaFields;
use App\Rules\CsvGenreFields;
use App\Rules\CsvImgFields;
use Illuminate\Foundation\Http\FormRequest;
use PhpOffice\PhpSpreadsheet\IOFactory;

class ImportRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'csvFile' => ['required', 'file', 'mimes:csv,txt'],
            'csv_data' => ['required', 'array'],
            'csv_data.*.0' => ['required', 'max:50'],
            'csv_data.*.1' => ['required', new CsvAreaFields],
            'csv_data.*.2' => ['required', new CsvGenreFields],
            'csv_data.*.3' => ['required', 'max:400'],
            'csv_data.*.4' => ['required', new CsvImgFields],
        ];
    }

    protected function prepareForValidation()
    {
        $rule = [
            'csvFile' => ['required', 'file', 'mimes:csv,txt'],
        ];
        $this->validate($rule);
        $file = $this->file('csvFile');
        $csv = IOFactory::load($file->getPathName());
        $csvData = $csv->getActiveSheet()->toArray();
        $this->merge([
            'csv_data' => $csvData
        ]);
    }

    public function messages()
    {
        return [
            'csvFile.required' => 'ファイルを選択してください',
            'csv_data.required' => 'CSVファイルの内容が誤っています',
            'csv_data.array' => 'CSVファイルの内容が誤っています',
        ];
    }

}
