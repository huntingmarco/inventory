// begin Authentication
let login = require('./components/auth/login.vue').default;
let register = require('./components/auth/register.vue').default;
let forget = require('./components/auth/forget.vue').default;
let logout = require('./components/auth/logout.vue').default;
let validation = require('./components/auth/validation.vue').default;
// end Authentication

let home = require('./components/home.vue').default;

// Employee component
let storeemployee = require('./components/employee/create.vue').default;
let employee = require('./components/employee/index.vue').default;
let editemployee = require('./components/employee/edit.vue').default;

// Supplier component
let storesupplier = require('./components/supplier/create.vue').default;
let supplier = require('./components/supplier/index.vue').default;
let editsupplier = require('./components/supplier/edit.vue').default;

// Category component
let storecategory = require('./components/category/create.vue').default;
let category = require('./components/category/index.vue').default;
let editcategory = require('./components/category/edit.vue').default;

// Product Component 
let storeproduct = require('./components/product/create.vue').default;
let product = require('./components/product/index.vue').default;
let editproduct = require('./components/product/edit.vue').default;

// Expense Component 
let storeexpense = require('./components/expense/create.vue').default;
let expense = require('./components/expense/index.vue').default;
let editexpense = require('./components/expense/edit.vue').default;

// Journal Component 
let storejournal = require('./components/journal/create.vue').default;
let journal = require('./components/journal/index.vue').default;
let editjournal = require('./components/journal/edit.vue').default;

// Account Group component
let storeacctgroup = require('./components/acctgroup/createAcctgroup.vue').default;
let acctgroup = require('./components/acctgroup/indexAcctgroup.vue').default;
let editacctgroup = require('./components/acctgroup/editAcctgroup.vue').default;

// Accounting Component 
let income = require('./components/accounting/income.vue').default;
let balance = require('./components/accounting/balance.vue').default;
let trialbalance = require('./components/accounting/trialbalance.vue').default;

  // Payroll Component 
  let addpayroll = require('./components/payroll/add_payroll.vue').default;
  let paysalary = require('./components/payroll/create.vue').default;
  let payroll = require('./components/payroll/index.vue').default;
  let viewpayroll = require('./components/payroll/view.vue').default;
  let editpayroll = require('./components/payroll/edit.vue').default;

  // Stock Component 
  let stock = require('./components/product/stock.vue').default;
  let editstock = require('./components/product/edit-stock.vue').default;

  // Customer component
  let storecustomer = require('./components/customer/create.vue').default;
  let customer = require('./components/customer/index.vue').default;
  let editcustomer = require('./components/customer/edit.vue').default;

  // POS component
  let pos = require('./components/pos/pointofsale.vue').default;

  // Sales component
  let sales = require('./components/sales/sales.vue').default;
  let viewsales = require('./components/sales/viewsales.vue').default;
  let searchsales = require('./components/sales/searchsales.vue').default;


  // Pay component
  let storepay = require('./components/pay/create.vue').default;
  let pay = require('./components/pay/index.vue').default;
  let editpay = require('./components/pay/edit.vue').default;

  // Reservation Component 
let storereservation = require('./components/reservation/create.vue').default;
let reservation = require('./components/reservation/index.vue').default;
let editreservation = require('./components/reservation/edit.vue').default;
  
export const routes = [
    { path: '/', component: login, name: '/' },
    { path: '/register', component: register, name: 'register' },
    { path: '/forget', component: forget, name: 'forget' },
    { path: '/logout', component: logout, name: 'logout' },
    { path: '/home', component: home, name: 'home' },
    { path: '/validation', component: validation, name: 'validation' },

    // Employee Routes
    { path: '/store-employee', component: storeemployee, name: 'store-employee' },
    { path: '/employee', component: employee, name: 'employee' },
    { path: '/edit-employee/:id', component: editemployee, name: 'edit-employee' },

    // Supplier Routes
    { path: '/store-supplier', component: storesupplier, name: 'store-supplier' },
    { path: '/supplier', component: supplier, name: 'supplier' },
    { path: '/edit-supplier/:id', component: editsupplier, name: 'edit-supplier' },

    // Category Routes
    { path: '/store-category', component: storecategory, name: 'store-category' },
    { path: '/category', component: category, name: 'category' },
    { path: '/edit-category/:id', component: editcategory, name: 'edit-category' },

    // Product Routes
    { path: '/store-product', component: storeproduct, name:'store-product'},
    { path: '/product', component: product, name:'product'},
    { path: '/edit-product/:id', component: editproduct, name:'edit-product'},

    // Expense Routes
    { path: '/store-expense', component: storeexpense, name:'store-expense'},
    { path: '/expense', component: expense, name:'expense'},
    { path: '/edit-expense/:id', component: editexpense, name:'edit-expense'},

    // Journal Routes
    { path: '/store-journal', component: storejournal, name:'store-journal'},
    { path: '/journal', component: journal, name:'journal'},
    { path: '/edit-journal/:id', component: editjournal, name:'edit-journal'},

     // Account Group Routes
     { path: '/store-acctgroup', component: storeacctgroup, name: 'store-acctgroup' },
     { path: '/acctgroup', component: acctgroup, name: 'acctgroup' },
     { path: '/edit-acctgroup/:id', component: editacctgroup, name: 'edit-acctgroup' },

     // Accounting Routes
     { path: '/income', component: income, name:'income'},
     { path: '/balance', component: balance, name:'balance'},
     { path: '/trialbalance', component: trialbalance, name:'trialbalance'},

    // Salary Routes
   
    { path: '/add-payroll', component: addpayroll, name:'add-payroll'},
    { path: '/pay-salary/:id', component: paysalary, name:'pay-salary'},

    { path: '/payroll', component: payroll, name:'payroll'},
    { path: '/view-payroll/:id', component: viewpayroll, name:'view-salary'},
    { path: '/edit-payroll/:id', component: editpayroll, name:'edit-payroll'},

    // Stocks Routes
    { path: '/stock', component: stock, name:'stock'},
    { path: '/edit-stock/:id', component: editstock, name:'edit-stock'},

    // Customer Routes
    { path: '/store-customer', component: storecustomer, name: 'store-customer' },
    { path: '/customer', component: customer, name: 'customer' },
    { path: '/edit-customer/:id', component: editcustomer, name: 'edit-customer' },
        
    // POS Routes
    { path: '/pos', component: pos, name: 'pos' },

    // Sales Routes
    { path: '/sales', component: sales, name: 'sales' },
    { path: '/view-sales/:id', component: viewsales, name: 'view-sales' },
    { path: '/searchsales', component: searchsales, name: 'searchsales' },

    // Pay Routes
    { path: '/store-pay', component: storepay, name: 'store-pay' },
    { path: '/pay', component: pay, name: 'pay' },
    { path: '/edit-pay/:id', component: editpay, name: 'edit-pay' },

    // Reservation Routes
    { path: '/store-reservation', component: storereservation, name:'store-reservation'},
    { path: '/reservation', component: reservation, name:'reservation'},
    { path: '/edit-reservation/:id', component: editreservation, name:'edit-reservation'},

  ]