<?php
/*
 * Project: RED_ORM.
 * Author: Levan Ostrowski
 * User: cod3venom
 * Date: 19.10.2021
 * Time: 15:32
*/

namespace src\annotation\helpers;

use ReflectionClass;
use ReflectionException;

class ReflectionParser
{
    public string $className;
    private ReflectionClass $mainClass;
    public function __construct(string $className)
    {
        $this->className = $className;
        $this->buildReflectionClass();
    }

    /**
     * Build reflection class
     */
    private function buildReflectionClass(): void{
        try {
            $this->mainClass = new ReflectionClass($this->className);
        }
        catch (\Exception $ex) {
            throw new \UnexpectedValueException(sprintf("[ReflectionParser] Class '%s' not found", $this->mainClass));
        }
    }

    /**
     * Return class comments
     * @return string
     */
    public function getClassDocs(): string {
        return $this->mainClass->getDocComment();
    }

    /**
     * Return comments of all properties
     * @return array
     */
    public function getAllPropertyDocs(): array
    {
        $allProperties = $this->mainClass->getProperties();
        return array_map(
            function (\ReflectionProperty $property){
                return $property->getDocComment();
            }, $allProperties
        );
    }

    /**
     * Return all docs together.
     * @return array
     */
    public function getAllDocs(): array
    {
        $all = $this->getAllPropertyDocs();
        $all[] = $this->getClassDocs();
        return $all;
    }
}