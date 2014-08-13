<?php

namespace Shopware\Components\SwagImportExport\FileIO;

use Shopware\Components\SwagImportExport\Utils\FileHelper;

class CsvFileWriter implements FileWriter
{

    protected $treeStructure = false;

    /**
     * @var $fileHelper 
     */
    protected $fileHelper;

    public function __construct(FileHelper $fileHelper)
    {
        $this->fileHelper = $fileHelper;
    }

    /**
     * @param string $fileName
     * @param array $headerData
     * @throws \Exception
     * @throws \Exception
     */
    public function writeHeader($fileName, $headerData)
    {
        if (!is_array($headerData)) {
            throw new \Exception('Header data is not valid');
        }

        $columnNames .= implode(';', $headerData) . "\n";
        $columnNames .= "\xEF\xBB\xBF";

        $this->getFileHelper()->writeStringToFile($fileName, $columnNames);
    }

    public function writeRecords($fileName, $data)
    {
        $flatData = '';
        
        $convertor = new \Shopware_Components_Convert_Csv;
        $keys = array_keys(current($data));
        foreach ($data as $line) {
            $flatData .= $convertor->_encode_line($line, $keys) . $convertor->sSettings['newline'];
        }

        $this->getFileHelper()->writeStringToFile($fileName, $flatData, FILE_APPEND);
    }

    public function writeFooter($fileName, $footerData)
    {
        
    }

    public function hasTreeStructure()
    {
        return $this->treeStructure;
    }

    public function getFileHelper()
    {
        return $this->fileHelper;
    }

}
