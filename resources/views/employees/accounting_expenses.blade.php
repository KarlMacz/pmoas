@extends('layouts.employees')

@section('content')
    <div class="page-header">
        <h1 class="no-margin">Accounting</h1>
        <div>Expenses</div>
    </div>
    <table class="table table-striped table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Product Name</th>
                <th>Quantity Stocked</th>
                <th>Date & Time Stocked</th>
                <th>Total Amount</th>
            </tr>
        </thead>
        <tbody>
            <?php
                $totalExpenses = 0;
            ?>
            @foreach($stocks as $stock)
                <?php
                    $totalExpenses += $stock->total_amount;
                ?>
                <tr>
                    <td>{{ $stock->id }}</td>
                    <td>{{ $stock->product->name }}</td>
                    <td>{{ $stock->quantity }}</td>
                    <td>{{ date('F d, Y', strtotime($stock->created_at)) }}</td>
                    <td>Php {{ $stock->total_amount }}</td>
                </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <td class="text-right" colspan="2">Total Expenses:</td>
                <td>Php {{ $totalExpenses }}</td>
            </tr>
        </tfoot>
    </table>
@endsection
