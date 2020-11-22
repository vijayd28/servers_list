<?php


namespace App\Services;

use PhpOffice\PhpSpreadsheet\IOFactory;
use App\Utils\Excel\Filter\ChunkReadFilter;
use PhpOffice\PhpSpreadsheet\Worksheet\AutoFilter\Column;
use PhpOffice\PhpSpreadsheet\Worksheet\AutoFilter\Column\Rule;

class FileFilterService
{

    /**
     * @var $reader
     */
    private $reader;

    /**
     * @var $spreadsheet;
     */
    private $spreadsheet;
    private $targetDirectory;

    /**
     * FileFilterService constructor.
     * @param $targetDirectory
     */
    public function __construct($targetDirectory)
    {
        $this->targetDirectory = $targetDirectory;
    }

    /**
     * @param $fileName
     * @throws \PhpOffice\PhpSpreadsheet\Reader\Exception
     */
    public function init($fileName)
    {
        $this->reader = IOFactory::createReader('Xls');
        $this->spreadsheet = $this->reader->load($this->targetDirectory . '/'. $fileName);

        return $this;
    }

    public function setRule($column, $value)
    {
        $autoFilter = $this->spreadsheet->getActiveSheet()->getAutoFilter();

        $autoFilter->getColumn($column)
            ->setFilterType(Column::AUTOFILTER_FILTERTYPE_CUSTOMFILTER)
            ->createRule()
            ->setRule(
                Rule::AUTOFILTER_COLUMN_RULE_EQUAL,
                $value
            )
            ->setRuleType(Rule::AUTOFILTER_RULETYPE_CUSTOMFILTER);
    }

    /**
     * @param $limit
     * @param $offset
     */
    public function filter($limit, $offset)
    {
        $this->reader->setReadFilter(new ChunkReadFilter($offset, $limit));
    }


    /**
     * @return mixed
     */
    public function toArray()
    {
        return $this
            ->spreadsheet
            ->getActiveSheet()
            ->toArray(null, true, true, true);
    }
}