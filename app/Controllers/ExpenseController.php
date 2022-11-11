<?php

namespace App\Controllers;

use App\Controllers\BaseController;

use App\Models\ExpensesModel;
use monken\TablesIgniter;

class ExpenseController extends BaseController
{
    public function index()
    {
        //
    }

    public function list(){
       return view('expense/list');
    }

    public function add(){
        helper('form');
        $expense = new ExpensesModel;
        $data = [];
        if($this->request->getMethod() == 'post'){

            $rules = [
                'description' => 'required',
                'amount' => 'required|min_length[0]'
            ];

            if(!$this->validate($rules)){
                $data['validation'] = $this->validator;
            }else{
        
                $current_expense = [
                    'description' =>  $this->request->getVar('description'),
                    'amount' =>  $this->request->getVar('amount'),
                    'user_id' => session()->get('id')
                ];
              if($expense->save($current_expense)){
                  return redirect()->to('expense/list')->with('success', 'Expense added');
              }
            }
        }
        return view('expense/add', $data);
    }
    public function edit($expense_id = null){
        helper('form');
        $expense = new ExpensesModel;
        $data = [];
        if($this->request->getMethod() == 'post'){

            $rules = [
                'description' => 'required',
                'amount' => 'required|min_length[0]'
            ];

            if(!$this->validate($rules)){
                $data['validation'] = $this->validator;
            }else{
        
                $current_expense = [
                    'id' => $expense_id,
                    'description' =>  $this->request->getVar('description'),
                    'amount' =>  $this->request->getVar('amount'),
                    'user_id' => session()->get('id'),
                    'updated_at' => date('Y-m-d')
                ];
              if($expense->save($current_expense)){
                  return redirect()->to('expense/list')->with('success', 'Expense edited!');
              }
            }
        }
        $data['expense'] = $expense->find($expense_id); 
        return view('expense/edit', $data);
    }

    public function delete_expense($expense_id){
        $expenseModel = new ExpensesModel;
        $expenseModel->where('id', $expense_id)->delete();

        return redirect()->to('/expense/list')->with('success', 'deleted successfuly');
    }

    public function ajax_expenses(){
        $expenseModel = new ExpensesModel;

        // echo '<pre> expenses ---------- <br/>';
        //     print_r($expenseModel->expensesTable());
        // echo '</pre>';

        $data_table = new TablesIgniter();

        $data_table->setTable($expenseModel->expensesTable())
                //    ->setDefaultOrder('id', 'DESC')
                   ->setSearch(['updated_at', 'description' , 'amount'])
                   ->setOrder(['updated_at', 'description', 'amount'])
                   ->setOutput([ $expenseModel->expenseDateFormat(), 'description', $expenseModel->expensePriceFormat(),
                                $expenseModel->expenseIssuedBy(),
                                 $expenseModel->actionButtons()
                               ]);

        return $data_table->getDatatable();
    }

}
