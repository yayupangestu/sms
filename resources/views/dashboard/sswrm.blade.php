@extends('layouts.app')

@section('content')
<style>
  * {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

body {
    font-family: Arial, sans-serif;
    background-color: #f8f8f8;
    padding: 20px;
}

.container {
    width: 100%;
    max-width: 1200px;
    margin: 0 auto;
    background-color: #fff;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    text-align: center;
}

.header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 20px;
}

.search-bar {
    padding: 10px 15px;
    width: 300px;
    border: 1px solid #ccc;
    border-radius: 5px;
}

.filter-button {
    background-color: #f2f2f2;
    padding: 10px 15px;
    border-radius: 5px;
    cursor: pointer;
    display: flex;
    align-items: center;
}

.filter-button i {
    margin-right: 10px;
}

.order-table {
    width: 100%;
    border-collapse: collapse;
}

.order-table thead {
    background-color: #f9f9f9;
    border-bottom: 2px solid #eee;
}

.order-table th, .order-table td {
    padding: 15px;
    text-align: left;
}

.order-table th {
    color: #777;
    text-transform: uppercase;
    font-size: 12px;
}

.order-table td {
    border-bottom: 1px solid #eee;
    font-size: 14px;
}

.product-image {
    width: 40px;
    margin-right: 10px;
    vertical-align: middle;
}

.customer-info {
    display: flex;
    align-items: center;
}

.avatar, .avatar-img {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    display: inline-block;
    margin-right: 10px;
    background-color: #ddd;
    text-align: center;
    line-height: 40px;
    font-weight: bold;
    color: #555;
}

.avatar-img {
    object-fit: cover;
}

small {
    color: #999;
    font-size: 12px;
}


</style>
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0">Pengeluaran Barang</h1>
      </div>
      <div class="col-sm-6">
        
      </div>
    </div>
  </div>
</div>

<section class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="container">
        <div class="header">
            <input type="text" placeholder="Search order..." class="search-bar">
            <div class="filter-button">
                <i class="fas fa-filter"></i> Filter
            </div>
        </div>

        <table class="order-table">
            <thead>
                <tr>
                    <th>ORDER</th>
                    <th>CUSTOMER</th>
                    <th>DATE</th>
                    <th>TOTAL</th>
                    <th>PAYMENT STATUS</th>
                    <th>ITEMS</th>
                    <th>DELIVERY METHOD</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><img src="macbook-air.png" alt="MacBook Air" class="product-image"> MacBook Air (M1, 2020) <br><small>#573829</small></td>
                    <td><div class="customer-info"><span class="avatar">DS</span> Darrell Steward</div></td>
                    <td>Apr 19, 08:01 AM</td>
                    <td>$1,099.00</td>
                    <td>Pending</td>
                    <td>1 items</td>
                    <td>Free Shipping</td>
                </tr>
                <tr>
                    <td><img src="macbook-pro.png" alt="MacBook Pro" class="product-image"> MacBook Pro 13-inch <br><small>#921047</small></td>
                    <td><div class="customer-info"><img src="profile1.jpg" class="avatar-img"> Courtney Henry</div></td>
                    <td>Apr 19, 09:15 AM</td>
                    <td>$2,198.00</td>
                    <td>Completed</td>
                    <td>2 items</td>
                    <td>Free Shipping</td>
                </tr>
                <!-- Add more rows as needed -->
            </tbody>
        </table>
    </div>

    </div>
  </div>
</section>
@endsection
