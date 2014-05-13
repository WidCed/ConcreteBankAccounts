<?php
namespace ConcreteBankAccounts\Tests\Tests\Unit\Builders;
use ConcreteBankAccounts\Infrastructure\Builders\ConcreteBankAccountBuilder;
use DateTimes\Tests\Helpers\DateTimeHelper;
use Primitives\Tests\Helpers\PrimitiveHelper;
use ObjectLoaders\Tests\Helpers\ObjectLoaderAdapterHelper;
use ObjectLoaders\Tests\Helpers\ObjectLoaderHelper;
use Entities\Domain\Entities\Builders\Exceptions\CannotBuildEntityException;

final class ConcreteBankAccountBuilderTest extends \PHPUnit_Framework_TestCase {
    
    private $objectLoaderAdapterMock;
    private $objectLoaderMock;
    private $uuidMock;
    private $integerMock;
    private $bankBranchMock;
    private $completeNameMock;
    private $dateTimeMock;
    private $accountNumberElement;
    private $booleanAdapterMock;
    private $classNameElement;
    private $createdOnTimestampElement;
    private $lastUpdatedOnTimestampElement;
    private $builder;
    private $objectLoaderAdapterHelper;
    private $objectLoaderHelper;
    private $dateTimeHelper;
    private $integerHelper;
    private $bankAccountMock;
    public function setUp() {
        
        $this->objectLoaderAdapterMock = $this->getMock('ObjectLoaders\Domain\ObjectLoaders\Adapters\ObjectLoaderAdapter');
        $this->objectLoaderMock = $this->getMock('ObjectLoaders\Domain\ObjectLoaders\ObjectLoader');
        $this->uuidMock = $this->getMock('Uuids\Domain\Uuids\Uuid');
        $this->integerMock = $this->getMock('Integers\Domain\Integers\Integer');
        $this->bankBranchMock = $this->getMock('BankBranches\Domain\BankBranches\BankBranch');
        $this->dateTimeMock = $this->getMock('DateTimes\Domain\DateTimes\DateTime');
        $this->booleanAdapterMock = $this->getMock('Booleans\Domain\Booleans\Adapters\BooleanAdapter');
        $this->completeNameMock = $this->getMock('CompleteNames\Domain\CompleteNames\CompleteName');
        $this->bankAccountMock = $this->getMock('BankAccounts\Domain\BankAccounts\BankAccount');
        
        $this->classNameElement = 'ConcreteBankAccounts\Infrastructure\Objects\ConcreteBankAccount';
        $this->createdOnTimestampElement = time() - (24 * 60 * 60);
        $this->lastUpdatedOnTimestampElement = time();
        
        $this->builder = new ConcreteBankAccountBuilder($this->booleanAdapterMock, $this->objectLoaderAdapterMock);
        
        $this->objectLoaderAdapterHelper = new ObjectLoaderAdapterHelper($this, $this->objectLoaderAdapterMock);
        $this->objectLoaderHelper = new ObjectLoaderHelper($this, $this->objectLoaderMock);
        $this->dateTimeHelper = new DateTimeHelper($this, $this->dateTimeMock);
        $this->integerHelper = new PrimitiveHelper($this, $this->integerMock);
        
    }
    
    public function tearDown() {
        
    }
    
    public function testBuild_Success() {
        
        $this->objectLoaderAdapterHelper->expects_convertClassNameElementToObjectLoader_Success($this->objectLoaderMock, $this->classNameElement);
        $this->objectLoaderHelper->expects_instantiate_Success($this->bankAccountMock, array($this->uuidMock, $this->bankBranchMock, $this->integerMock, $this->completeNameMock, $this->dateTimeMock, $this->booleanAdapterMock));
        $this->integerHelper->expectsGet_multiple_Success(array($this->accountNumberElement));
        
        $bankAccount = $this->builder->create()
                                ->withUuid($this->uuidMock)
                                ->withBankBranch($this->bankBranchMock)
                                ->withAccountNumber($this->integerMock)
                                ->withOwner($this->completeNameMock)
                                ->createdOn($this->dateTimeMock)
                                ->now();
        
        $this->assertEquals($this->bankAccountMock, $bankAccount);
        
    }
    
    public function testBuild_throwsCannotInstantiateObjectException_throwsCannotBuildEntityException() {
        
        $this->objectLoaderAdapterHelper->expects_convertClassNameElementToObjectLoader_Success($this->objectLoaderMock, $this->classNameElement);
        $this->objectLoaderHelper->expects_instantiate_throwsCannotInstantiateObjectException(array($this->uuidMock, $this->bankBranchMock, $this->integerMock, $this->completeNameMock, $this->dateTimeMock, $this->booleanAdapterMock));
        
        $asserted = false;
        try {
        
            $this->builder->create()
                            ->withUuid($this->uuidMock)
                            ->withBankBranch($this->bankBranchMock)
                            ->withAccountNumber($this->integerMock)
                            ->withOwner($this->completeNameMock)
                            ->createdOn($this->dateTimeMock)
                            ->now();
            
        } catch (CannotBuildEntityException $exception) {
            $asserted = true;
        }
        
        $this->assertTrue($asserted);
        
    }
    
    public function testBuild_throwsCannotConvertClassNameElementToObjectLoaderException_throwsCannotBuildEntityException() {
        
        $this->objectLoaderAdapterHelper->expects_convertClassNameElementToObjectLoader_throwsCannotConvertClassNameElementToObjectLoaderException($this->classNameElement);
        
        $asserted = false;
        try {
        
            $this->builder->create()
                            ->withUuid($this->uuidMock)
                            ->withBankBranch($this->bankBranchMock)
                            ->withAccountNumber($this->integerMock)
                            ->withOwner($this->completeNameMock)
                            ->createdOn($this->dateTimeMock)
                            ->now();
            
        } catch (CannotBuildEntityException $exception) {
            $asserted = true;
        }
        
        $this->assertTrue($asserted);
        
    }
    
    public function testBuild_withoutBankBranch_throwsCannotBuildEntityException() {
        
        $asserted = false;
        try {
        
            $this->builder->create()
                            ->withUuid($this->uuidMock)
                            ->withAccountNumber($this->integerMock)
                            ->withOwner($this->completeNameMock)
                            ->createdOn($this->dateTimeMock)
                            ->now();
            
        } catch (CannotBuildEntityException $exception) {
            $asserted = true;
        }
        
        $this->assertTrue($asserted);
        
    }
    
    public function testBuild_withoutAccountNumber_throwsCannotBuildEntityException() {
        
        $asserted = false;
        try {
        
            $this->builder->create()
                            ->withUuid($this->uuidMock)
                            ->withBankBranch($this->bankBranchMock)
                            ->withOwner($this->completeNameMock)
                            ->createdOn($this->dateTimeMock)
                            ->now();
            
        } catch (CannotBuildEntityException $exception) {
            $asserted = true;
        }
        
        $this->assertTrue($asserted);
        
    }
    
    public function testBuild_withoutOwner_throwsCannotBuildEntityException() {
        
        $asserted = false;
        try {
        
            $this->builder->create()
                            ->withUuid($this->uuidMock)
                            ->withBankBranch($this->bankBranchMock)
                            ->withOwner($this->completeNameMock)
                            ->createdOn($this->dateTimeMock)
                            ->now();
            
        } catch (CannotBuildEntityException $exception) {
            $asserted = true;
        }
        
        $this->assertTrue($asserted);
        
    }
    
    public function testBuild_withLastUpdatedOn_Success() {
        
        $this->objectLoaderAdapterHelper->expects_convertClassNameElementToObjectLoader_Success($this->objectLoaderMock, $this->classNameElement);
        $this->objectLoaderHelper->expects_instantiate_Success($this->bankAccountMock, array($this->uuidMock, $this->bankBranchMock, $this->integerMock, $this->completeNameMock, $this->dateTimeMock, $this->booleanAdapterMock, $this->dateTimeMock));
        $this->integerHelper->expectsGet_multiple_Success(array($this->accountNumberElement));
        
        $bankAccount = $this->builder->create()
                                ->withUuid($this->uuidMock)
                                ->withBankBranch($this->bankBranchMock)
                                ->withAccountNumber($this->integerMock)
                                ->withOwner($this->completeNameMock)
                                ->createdOn($this->dateTimeMock)
                                ->lastUpdatedOn($this->dateTimeMock)
                                ->now();
        
        $this->assertEquals($this->bankAccountMock, $bankAccount);
        
    }
    
}