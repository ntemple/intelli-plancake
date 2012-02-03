<?php

/**
 * dashboard actions.
 *
 * @package    plancake
 * @subpackage dashboard
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class dashboardActions extends sfActions
{
 /**
  * Executes index action
  *
  * @param sfRequest $request A request object
  */
  public function executeIndex(sfWebRequest $request)
  {
    $firstDayOfCurrentMonth = date("Y-m-d", strtotime(date('m').'/01/'.date('Y').' 00:00:00'));
    

    $this->monthIncome = $this->getSum("SELECT SUM(amount) AS sum FROM pc_bookkeeping_entry WHERE type_id=" . PcBookkeepingCategory::INCOME .
              " AND date >= '" . $firstDayOfCurrentMonth . "'");
    $this->monthExpense = $this->getSum("SELECT SUM(amount) AS sum FROM pc_bookkeeping_entry WHERE type_id=" . PcBookkeepingCategory::EXPENSE .
              " AND date >= '" . $firstDayOfCurrentMonth . "'");

    $this->monthProfit = $this->monthIncome - $this->monthExpense;      
      
    $this->totalIncome = $this->getSum("SELECT SUM(amount) AS sum FROM pc_bookkeeping_entry WHERE type_id=" . PcBookkeepingCategory::INCOME);
    $this->totalExpense = $this->getSum("SELECT SUM(amount) AS sum FROM pc_bookkeeping_entry WHERE type_id=" . PcBookkeepingCategory::EXPENSE);
    $this->totalProfit = $this->totalIncome - $this->totalExpense;     
      
  }
  
  private function getSum($query) {
    $con = Propel::getConnection('propel'); 
    
    $statement = $con->prepare($query);
    $statement->execute();
    $resultset = $statement->fetch(PDO::FETCH_OBJ);
    return $resultset->sum;       
  }
}
