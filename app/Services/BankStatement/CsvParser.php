<?php

namespace App\Services\BankStatement;

use Illuminate\Http\UploadedFile;

class CsvParser
{
    public function parse(UploadedFile $file): array
    {
        $extension = strtolower($file->getClientOriginalExtension());

        if ($extension === 'csv') {
            return $this->parseCsv($file->getRealPath());
        }

        if (in_array($extension, ['xlsx', 'xls'])) {
            return $this->parseExcel($file->getRealPath());
        }

        throw new \InvalidArgumentException("Unsupported file type: {$extension}. Please upload a CSV or Excel file.");
    }

    private function parseCsv(string $path): array
    {
        $rows = [];
        $headers = [];

        if (($handle = fopen($path, 'r')) === false) {
            throw new \RuntimeException('Could not open uploaded file.');
        }

        while (($row = fgetcsv($handle, 0, ',')) !== false) {
            if (empty(array_filter($row))) continue;

            if (empty($headers)) {
                $headers = array_map('trim', $row);
                continue;
            }

            while (count($row) < count($headers)) $row[] = '';
            $rows[] = array_combine($headers, array_map('trim', $row));
        }

        fclose($handle);
        return $rows;
    }

    private function parseExcel(string $path): array
    {
        if (!class_exists(\PhpOffice\PhpSpreadsheet\IOFactory::class)) {
            throw new \RuntimeException('PhpSpreadsheet not installed. Run: composer require phpoffice/phpspreadsheet');
        }

        $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($path);
        $data = $spreadsheet->getActiveSheet()->toArray(null, true, true, false);

        if (empty($data)) return [];

        $headers = null;
        $rows = [];

        foreach ($data as $row) {
            $filtered = array_filter($row, fn($v) => $v !== null && $v !== '');
            if (empty($filtered)) continue;

            if ($headers === null) {
                $headers = array_map(fn($v) => trim((string) $v), $row);
                continue;
            }

            while (count($row) < count($headers)) $row[] = null;
            $rows[] = array_combine($headers, array_map(fn($v) => trim((string) $v), $row));
        }

        return $rows;
    }
}
