<?php
namespace ConcreteBankAccounts\Infrastructure\Builders;
use ConcreteEntities\Infrastructure\Builders\AbstractEntityBuilder;
use BankAccounts\Domain\BankAccounts\Builders\BankAccountBuilder;
use Booleans\Domain\Booleans\Adapters\BooleanAdapter;
use ObjectLoaders\Domain\ObjectLoaders\Adapters\ObjectLoaderAdapter;
use Integers\Domain\Integers\Integer;
use CompleteNames\Domain\CompleteNames\CompleteName;
use BankBranches\Domain\BankBranches\BankBranch;
use Entities\Domain\Entities\Builders\Exceptions\CannotBuildEntityException;

final class ConcreteBankAccountBuilder extends AbstractEntityBuilder implements BankAccountBuilder {
    
    private $bankBranch;
    private $accountNumber;
    private $owner;
    public function __construct(BooleanAdapter $booleanAdapter, ObjectLoaderAdapter $objectLoaderAdapter) {
        parent::__construct($booleanAdapter, $objectLoaderAdapter, 'ConcreteBankAccounts\Infrastructure\Objects\ConcreteBankAccount');
    }
    
    public function create() {
        parent::create();
        $this->bankBranch = null;
        $this->accountNumber = null;
        $this->owner = null;
        return $this;
    }
    
    public function withBankBranch(BankBranch $bankBranch) {
        $this->bankBranch = $bankBranch;
        return $this;
    }
    
    public function withAccountNumber(Integer $accountNumber) {
        $this->accountNumber = $accountNumber;
        return $this;
    }
    
    public function withOwner(CompleteName $owner) {
        $this->owner = $owner;
        return $this;
    }
    
    protected function getParamsData() {
        
        $paramsData = array($this->uuid, $this->bankBranch, $this->accountNumber, $this->owner, $this->createdOn, $this->booleanAdapter);
        
        if (!empty($this->lastUpdatedOn)) {
            $paramsData[] = $this->lastUpdatedOn;
        }
        
        return $paramsData;
    }
    
    public function now() {
        
        if (empty($this->bankBranch)) {
            throw new CannotBuildEntityException('The BankBranch is mandatory in order to build a BankAccount object.');
        }
        
        if (empty($this->accountNumber)) {
            throw new CannotBuildEntityException('The accountNumber is mandatory in order to build a BankAccount object.');
        }
        
        if (empty($this->owner)) {
            throw new CannotBuildEntityException('The owner is mandatory in order to build a BankAccount object.');
        }
        
        return parent::now();
        
    }
}
