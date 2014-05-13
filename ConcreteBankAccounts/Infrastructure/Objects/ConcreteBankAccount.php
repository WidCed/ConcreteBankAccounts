<?php
namespace ConcreteBankAccounts\Infrastructure\Objects;
use ConcreteEntities\Infrastructure\Objects\AbstractEntity;
use BankAccounts\Domain\BankAccounts\BankAccount;
use BankBranches\Domain\BankBranches\BankBranch;
use CompleteNames\Domain\CompleteNames\CompleteName;
use Integers\Domain\Integers\Integer;
use Uuids\Domain\Uuids\Uuid;
use DateTimes\Domain\DateTimes\DateTime;
use Booleans\Domain\Booleans\Adapters\BooleanAdapter;
use Entities\Domain\Entities\Exceptions\CannotCreateEntityException;
use ConcreteClassAnnotationObjects\Infrastructure\Objects\ConcreteContainer;
use ConcreteMethodAnnotationObjects\Infrastructure\Objects\ConcreteKeyname;
use ConcreteMethodAnnotationObjects\Infrastructure\Objects\ConcreteTransform;

/**
 * @ConcreteContainer("bank_account") 
 */
final class ConcreteBankAccount extends AbstractEntity implements BankAccount {
    
    private $bankBranch;
    private $accountNumber;
    private $owner;
    public function __construct(Uuid $uuid, BankBranch $bankBranch, Integer $accountNumber, CompleteName $owner, DateTime $createdOn, BooleanAdapter $booleanAdapter, DateTime $lastUpdatedOn = null) {
        
        if ($accountNumber->get() == '') {
            throw new CannotCreateEntityException('The accountNumber must be a non-empty Integer object.');
        }
        
        parent::__construct($uuid, $createdOn, $booleanAdapter, $lastUpdatedOn);
        $this->bankBranch = $bankBranch;
        $this->accountNumber = $accountNumber;
        $this->owner = $owner;
        
    }
    
    /**
     * @ConcreteKeyname(name="bank_branch", argument="bankBranch")
     **/
    public function getBankBranch() {
        return $this->bankBranch;
    }
    
    /**
     * @ConcreteKeyname(name="account_number", argument="accountNumber")
     * @ConcreteTransform(reference="irestful.concreteintegers.adapter", method="convertElementToPrimitive")
     **/
    public function getAccountNumber() {
        return $this->accountNumber;
    }
    
    /**
     * @ConcreteKeyname(name="owner", argument="owner")
     **/
    public function getOwner() {
        return $this->owner;
    }
}