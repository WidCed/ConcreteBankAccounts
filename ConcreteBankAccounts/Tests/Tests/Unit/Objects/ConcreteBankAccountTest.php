<?php
namespace ConcreteBankAccounts\Tests\Tests\Unit\Objects;
use ConcreteBankAccounts\Infrastructure\Objects\ConcreteBankAccount;
use DateTimes\Tests\Helpers\DateTimeHelper;
use Primitives\Tests\Helpers\PrimitiveHelper;
use Entities\Domain\Entities\Exceptions\CannotCreateEntityException;

final class ConcreteBankAccountTest extends \PHPUnit_Framework_TestCase {
    
    private $uuidMock;
    private $integerMock;
    private $dateTimeMock;
    private $booleanAdapterMock;
    private $bankBranchMock;
    private $completeNameMock;
    private $createdOnTimestampElement;
    private $lastUpdatedOnTimestampElement;
    private $accountNumberElement;
    private $emptyAccountNumberElement;
    private $dateTimeHelper;
    private $integerHelper;
    public function setUp() {
        
        $this->uuidMock = $this->getMock('Uuids\Domain\Uuids\Uuid');
        $this->integerMock = $this->getMock('Integers\Domain\Integers\Integer');
        $this->dateTimeMock = $this->getMock('DateTimes\Domain\DateTimes\DateTime');
        $this->booleanAdapterMock = $this->getMock('Booleans\Domain\Booleans\Adapters\BooleanAdapter');
        $this->bankBranchMock = $this->getMock('BankBranches\Domain\BankBranches\BankBranch');
        $this->completeNameMock = $this->getMock('CompleteNames\Domain\CompleteNames\CompleteName');
        
        $this->createdOnTimestampElement = time() - (24 * 60 * 60);
        $this->lastUpdatedOnTimestampElement = time();
        $this->accountNumberElement = 125;
        $this->emptyAccountNumberElement = null;
        
        $this->dateTimeHelper = new DateTimeHelper($this, $this->dateTimeMock);
        $this->integerHelper = new PrimitiveHelper($this, $this->integerMock);
        
    }
    
    public function tearDown() {
        
    }
    
    public function testCreate_Success() {
        
        $this->integerHelper->expectsGet_multiple_Success(array($this->accountNumberElement));
        
        $bankAccount = new ConcreteBankAccount($this->uuidMock, $this->bankBranchMock, $this->integerMock, $this->completeNameMock, $this->dateTimeMock, $this->booleanAdapterMock);
        
        $this->assertEquals($this->uuidMock, $bankAccount->getUuid());
        $this->assertEquals($this->bankBranchMock, $bankAccount->getBankBranch());
        $this->assertEquals($this->integerMock, $bankAccount->getAccountNumber());
        $this->assertEquals($this->completeNameMock, $bankAccount->getOwner());
        $this->assertEquals($this->dateTimeMock, $bankAccount->createdOn());
        $this->assertNull($bankAccount->lastUpdatedOn());
        
        $this->assertTrue($bankAccount instanceof \BankAccounts\Domain\BankAccounts\BankAccount);
        $this->assertTrue($bankAccount instanceof \ConcreteEntities\Infrastructure\Objects\AbstractEntity);
        
    }
    
    public function testCreate_withEmptyAccountNumberElement_Success() {
        
        $this->integerHelper->expectsGet_Success($this->emptyAccountNumberElement);
        
        $asserted = false;
        try {
        
            new ConcreteBankAccount($this->uuidMock, $this->bankBranchMock, $this->integerMock, $this->completeNameMock, $this->dateTimeMock, $this->booleanAdapterMock);
            
        } catch (CannotCreateEntityException $exception) {
            $asserted = true;
        }
        
        $this->assertTrue($asserted);
        
    }
    
    
    public function testCreate_withLastUpdatedOn_Success() {
        
        $this->dateTimeHelper->expectsGetTimestamp_multiple_Success(array($this->integerMock, $this->integerMock));
        $this->integerHelper->expectsGet_multiple_Success(array($this->accountNumberElement, $this->createdOnTimestampElement, $this->lastUpdatedOnTimestampElement));
        
        $bankAccount = new ConcreteBankAccount($this->uuidMock, $this->bankBranchMock, $this->integerMock, $this->completeNameMock, $this->dateTimeMock, $this->booleanAdapterMock, $this->dateTimeMock);
        
        $this->assertEquals($this->uuidMock, $bankAccount->getUuid());
        $this->assertEquals($this->bankBranchMock, $bankAccount->getBankBranch());
        $this->assertEquals($this->integerMock, $bankAccount->getAccountNumber());
        $this->assertEquals($this->completeNameMock, $bankAccount->getOwner());
        $this->assertEquals($this->dateTimeMock, $bankAccount->createdOn());
        $this->assertEquals($this->dateTimeMock, $bankAccount->lastUpdatedOn());
        
    }
}