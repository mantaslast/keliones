<?php
/**
 * Klase CSV importavimui
 * Geriausia importuoti gražiai suformatuotą failą, kad grąžintų tvarkingus array
 * Negrąžina tvarkingų array iš  XLS ar XSLX failų, reikia tokius failus convertint į
 * CSV (UTF8 - comma delimeted)
 */
namespace App\Classes\Csv;

class CsvIterator implements \Iterator
{
    const ROW_SIZE = 1000;

    protected $csvFile = null;
    protected $currentEl = null;
    protected $rowsCount = null;
    protected $delimeter = null;

    public function __construct($file, $delimeter = ',')
    {
        try{
            $this->csvFile = fopen($file, 'rb');
            $this->delimeter = $delimeter;
        } catch (\Exception $e) {
            throw new \Exception('Failas"' . $file . '" nenuskaitomas');
        }
    }

    public function rewind(): void
    {
        $this->rowsCount = 0;
        rewind($this->csvFile);
    }

    public function current()
    {
        $this->currentEl = fgetcsv($this->csvFile, self::ROW_SIZE, $this->delimeter);
        $this->rowsCount++;

        return $this->currentEl;
    }

    public function key(): int
    {
        return $this->rowsCount;
    }

    public function next(): bool
    {
        if (is_resource($this->csvFile)) {
            return !feof($this->csvFile);
        }

        return false;
    }

    public function valid(): bool
    {
        if (!$this->next()) {
            if (is_resource($this->csvFile)) {
                fclose($this->csvFile);
            }

            return false;
        }

        return true;
    }
}