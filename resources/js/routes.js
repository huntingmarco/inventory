// begin Authentication
let login = require('./components/auth/login.vue').default;
let register = require('./components/auth/register.vue').default;
let forget = require('./components/auth/forget.vue').default;
let logout = require('./components/auth/logout.vue').default;
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
  
export const routes = [
    { path: '/', component: login, name: '/' },
    { path: '/register', component: register, name: 'register' },
    { path: '/forget', component: forget, name: 'forget' },
    { path: '/logout', component: logout, name: 'logout' },
    { path: '/home', component: home, name: 'home' },

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
        
  ]