<?php
namespace ConcreteBankAccounts\Tests\Tests\Functional;
use ConcreteFunctionalTestHelpers\Tests\Helpers\ConcreteDependencyInjectionFunctionalTestHelper;
use ConcreteBankAccounts\Tests\Helpers\StaticBankAccountHelper;

final class ConcreteBankAcccountTest extends \PHPUnit_Framework_TestCase {
    
    private $objectsData;
    public function setUp() {
        
        $dependencyInjectionFunctionalTestHelper = new ConcreteDependencyInjectionFunctionalTestHelper(__DIR__.'/../../../../vendor');
        
        $jsonFilePathElement = realpath(__DIR__.'/../../../../dependencyinjection.json');
        $bankBranchJsonFilePathElement = realpath(__DIR__.'/../../../../vendor/irestful/concretebankbranches/dependencyinjection.json');
        $integerJsonFilePathElement = realpath(__DIR__.'/../../../../vendor/irestful/concreteintegers/dependencyinjection.json');
        $uuidJsonFilePathElement = realpath(__DIR__.'/../../../../vendor/irestful/concreteuuids/dependencyinjection.json');
        $bankJsonFilePathElement = realpath(__DIR__.'/../../../../vendor/irestful/concretebanks/dependencyinjection.json');
        $addressJsonFilePathElement = realpath(__DIR__.'/../../../../vendor/irestful/concreteaddresses/dependencyinjection.json');
        $stringJsonFilePathElement = realpath(__DIR__.'/../../../../vendor/irestful/concretestrings/dependencyinjection.json');
        $dateTimeFilePathElement = realpath(__DIR__.'/../../../../vendor/irestful/concretedatetimes/dependencyinjection.json');
        $booleanFilePathElement = realpath(__DIR__.'/../../../../vendor/irestful/concretebooleans/dependencyinjection.json');
        $americanPostalCodeJsonFilePathElement = realpath(__DIR__.'/../../../../vendor/irestful/concreteamericanpostalcodes/dependencyinjection.json');
        $neighborhoodJsonFilePathElement = realpath(__DIR__.'/../../../../vendor/irestful/concreteneighborhoods/dependencyinjection.json');
        $cityJsonFilePathElement = realpath(__DIR__.'/../../../../vendor/irestful/concretecities/dependencyinjection.json');
        $regionJsonFilePathElement = realpath(__DIR__.'/../../../../vendor/irestful/concreteregions/dependencyinjection.json');
        $countryJsonFilePathElement = realpath(__DIR__.'/../../../../vendor/irestful/concretecountries/dependencyinjection.json');
        $coordinateJsonFilePathElement = realpath(__DIR__.'/../../../../vendor/irestful/concretecoordinates/dependencyinjection.json');
        $floatJsonFilePathElement = realpath(__DIR__.'/../../../../vendor/irestful/concretefloats/dependencyinjection.json');
        $completeNameJsonFilePathElement = realpath(__DIR__.'/../../../../vendor/irestful/concretecompletenames/dependencyinjection.json');
        
        StaticBankAccountHelper::setUp(
                $dependencyInjectionFunctionalTestHelper,
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
                $dateTimeFilePathElement,
                $booleanFilePathElement
        );
        
        $this->objectsData = $dependencyInjectionFunctionalTestHelper->getMultipleFileDependencyInjectionApplication()->execute($jsonFilePathElement);
        $this->objectsData['irestful.concreteobjectmetadatacompilerapplications.application']->compile();
    }
    
    public function tearDown() {
        
    }
    
    public function testConvertBankAccount_toHashMap_toBankAccount_Success() {
        
        $bankAccount = StaticBankAccountHelper::getObject();
        
        //convert the object into hashmap:
        $hashMap = $this->objectsData['irestful.concreteentities.adapter']->convertEntityToHashMap($bankAccount);
        $this->assertTrue($hashMap instanceof \HashMaps\Domain\HashMaps\HashMap);
                
        //convert hashmap back to a BankAccount object:
        $convertedBankAccount = $this->objectsData['irestful.concreteentities.adapter']->convertHashMapToEntity($hashMap);
        $this->assertEquals($bankAccount, $convertedBankAccount);    
    }
    
}