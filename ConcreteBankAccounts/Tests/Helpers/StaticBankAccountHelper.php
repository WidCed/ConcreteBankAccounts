<?php
namespace ConcreteBankAccounts\Tests\Helpers;
use ConcreteFunctionalTestHelpers\Tests\Helpers\ConcreteDependencyInjectionFunctionalTestHelper;
use ConcreteBankBranches\Tests\Helpers\StaticBankBranchHelper;

final class StaticBankAccountHelper {
    
    private static $objectsData;
    private static $uuidObjectsData;
    private static $integerObjectsData;
    private static $dateTimeObjectsData;
    private static $stringObjectsData;
    private static $booleanObjectsData;
    private static $completeNameObjectsData;
    private static $object = null;
    
    public static function isSetUp() {
        return !empty(self::$object);
    }
    
    public static function setUp(
        ConcreteDependencyInjectionFunctionalTestHelper $depdendencyInjectionFunctionalTestHelper,
        $jsonFilePathElement,
        $bankBranchJsonFilePathElement,
        $floatJsonFilePathElement,
        $stringJsonFilePathElement,
        $americanPostalCodeJsonFilePathElement,
        $neighborhoodJsonFilePathElement,
        $cityJsonFilePathElement,
        $regionJsonFilePathElement,
        $countryJsonFilePathElement,
        $coordinateJsonFilePathElement,
        $uuidJsonFilePathElement,
        $integerJsonFilePathElement,
        $bankJsonFilePathElement,
        $addressJsonFilePathElement,
        $completeNameJsonFilePathElement,
        $dateTimeJsonFilePathElement,
        $booleanJsonFilePathElement
    ) {
        
        if (self::isSetUp()) {
            return;
        }
        
        StaticBankBranchHelper::setUp(
                $depdendencyInjectionFunctionalTestHelper,
                $bankBranchJsonFilePathElement,
                $floatJsonFilePathElement,
                $stringJsonFilePathElement,
                $americanPostalCodeJsonFilePathElement,
                $neighborhoodJsonFilePathElement,
                $cityJsonFilePathElement,
                $regionJsonFilePathElement,
                $countryJsonFilePathElement,
                $coordinateJsonFilePathElement,
                $uuidJsonFilePathElement,
                $integerJsonFilePathElement,
                $bankJsonFilePathElement,
                $addressJsonFilePathElement,
                $dateTimeJsonFilePathElement,
                $booleanJsonFilePathElement
        );
        
        self::$objectsData = $depdendencyInjectionFunctionalTestHelper->getMultipleFileDependencyInjectionApplication()->execute($jsonFilePathElement);
        self::$uuidObjectsData = $depdendencyInjectionFunctionalTestHelper->getMultipleFileDependencyInjectionApplication()->execute($uuidJsonFilePathElement);
        self::$integerObjectsData = $depdendencyInjectionFunctionalTestHelper->getMultipleFileDependencyInjectionApplication()->execute($integerJsonFilePathElement);
        self::$dateTimeObjectsData = $depdendencyInjectionFunctionalTestHelper->getMultipleFileDependencyInjectionApplication()->execute($dateTimeJsonFilePathElement);
        self::$booleanObjectsData = $depdendencyInjectionFunctionalTestHelper->getMultipleFileDependencyInjectionApplication()->execute($booleanJsonFilePathElement);
        self::$stringObjectsData = $depdendencyInjectionFunctionalTestHelper->getMultipleFileDependencyInjectionApplication()->execute($stringJsonFilePathElement);
        self::$completeNameObjectsData = $depdendencyInjectionFunctionalTestHelper->getMultipleFileDependencyInjectionApplication()->execute($completeNameJsonFilePathElement);
        
        self::$object = self::build();
    }
    
    public static function getObject() {
        return self::$object;
    }
    
    public static function getObjectWithSubObjects() {
        $objectsData = StaticBankBranchHelper::getObjectWithSubObjects();
        return array_merge(array(self::$object), $objectsData);
    }
    
    private static function build() {
        
        $uuidElement = 'ca3497a0-b00b-11e3-a5e2-0800200c9a66';
        $accountNumberElement = "12354";
        $firstNameElement = "This is a first name";
        $lastNameElement = "This is a last name";
        $createdOnTimestampElement = time() - (24 * 60 * 60);
        $lastUpdatedOnTimestampElement = time();
        
        $firstName = self::$stringObjectsData['adapter']->convertElementToPrimitive($firstNameElement);
        $lastName = self::$stringObjectsData['adapter']->convertElementToPrimitive($lastNameElement);
        
        $owner = self::$completeNameObjectsData['builderfactory']->create()
                                                                    ->create()
                                                                    ->withFirstName($firstName)
                                                                    ->withLastName($lastName)
                                                                    ->now();
        
        $bankBranch = StaticBankBranchHelper::getObject();
        
        
        $uuid = self::$uuidObjectsData['adapter']->convertElementToUuid($uuidElement);
        $accountNumber = self::$integerObjectsData['adapter']->convertElementToPrimitive($accountNumberElement);
        $createdOn = self::$dateTimeObjectsData['adapter']->convertTimestampElementToDateTime($createdOnTimestampElement);
        $lastUpdatedOn = self::$dateTimeObjectsData['adapter']->convertTimestampElementToDateTime($lastUpdatedOnTimestampElement);
        
        return self::$objectsData['builderfactory']->create()
                                                    ->create()
                                                    ->withUuid($uuid)
                                                    ->withBankBranch($bankBranch)
                                                    ->withAccountNumber($accountNumber)
                                                    ->withOwner($owner)
                                                    ->createdOn($createdOn)
                                                    ->lastUpdatedOn($lastUpdatedOn)
                                                    ->now();
    }
    
}