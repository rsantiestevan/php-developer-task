<?php

namespace App\Reports;

use Illuminate\Support\Facades\Response;

class ExportCsv 
{
    /**
     * The file name to export
     * 
     * @var string $fileName;
     */
    private $fileName;
    
    /**
     * Export constructor
     * 
     * @param string $filename
     * @return void
     */ 
    public function __construct($filename = null)
    {
        $this->fileName = is_null($filename) ? 'file.csv' : $filename.'.csv';
    }
    
    /**
     * 
     * $return array $headers
     */
    private function getHeaders()
    {
         $headers = [
            "Content-type" => "text/csv",
            "Content-Disposition" => "attachment; filename=" . $this->fileName,
            "Pragma" => "no-cache",
            "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
            "Expires" => "0"
        ];
        return $headers;
    }
    
    /**
     * @param array $data
     * @param array $columnNames
     * @return \Symfony\Component\HttpFoundation\StreamedResponse
     */
    public function getCsv($data,  $columnNames, $fileName='file.csv') {
       
        $callback = function() use ($columnNames, $data ) {
            $file = fopen('php://output', 'w');
            
            $this->putCsv($file, $columnNames);
            
            foreach ($data as $row) {
                
                $this->putCsv($file, $row);
                
            }
            
            fclose($file);
        };
        
        return response()->stream($callback, 200, $this->getHeaders());
    }

    /**
     * 
     * @param handle $file
     * @param array $columnNames
     * @return void
     */
    private function putCsv($file, $data)
    {
        fputs($file, implode($data,',')."\n");
    }
    
}