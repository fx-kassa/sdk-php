<?php

namespace Flamix\Kassa\Actions;


/**
 * Trait Cashbox for working with cashbox API
 * @package Flamix\Kassa\Actions
 */
trait Cashbox
{
    /**
     * @return false|mixed
     */
    public function getCashBox()
    {
        $response = $this->exec('/', 'GET');

        return (!empty($response['response']))? $response['response'] : false;
    }

    /**
     * @return bool
     */
    public function deleteCashBox(): bool
    {
        $this->exec('/', 'DELETE');

        return true;
    }

    /**
     * @param $data
     * @return false|mixed
     */
    public function updateCashBox($data)
    {
        $this->preparePostData($data);

        $response = $this->exec('/', 'POST');

        return (!empty($response['response']))? $response['response'] : false;
    }

    /**
     * @param string $path
     * @return string
     */
    private function getFileName(string $path): string
    {
        $pathInfo = pathinfo($path);

        return $pathInfo['basename'];
    }

    /**
     * @param $data
     */
    private function preparePostData($data): void
    {
        if (
            isset($data['logo_file_path']) &&
            $data['logo_file_path'] !== '' &&
            file_exists($data['logo_file_path'])
        ) {
            foreach ($data as $param => $value) {
                if ($param === 'logo_file_path') {
                    $this->setMultipart($param, file_get_contents($value), $this->getFileName($value));
                } else {
                    $this->setMultipart($param, $value);
                }
            }
        } else {
            $this->setFormParams($data);
        }
    }
}
