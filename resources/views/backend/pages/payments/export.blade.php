@if ($searchBy)
    <p>Result According To: {{ $searchBy }}</p>
@endif
<table>
    <thead>
        <tr>
            <th>#</th>
            <th>Reference</th>
            <th>Customer First Name</th>
            <th>Customer Last Name</th>
            <th>Phone</th>
            <th>Email</th>
            <th>Address</th>
            <th>Payment Method</th>
            <th>Sub Total</th>
            <th>Delivery Fee</th>
            <th>Total</th>
            <th>Order Status</th>
            <th>Payment Status</th>
            <th>Note</th>
            <th>Added Date</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($payments as $index => $payment)
            <tr>
                <td>{{ $index++ }}</td>
                <td>{{ $payment->order->ref }}</td>
                <td>{{ $payment->order->customer_first_name }}</td>
                <td>{{ $payment->order->customer_last_name }}</td>
                <td>{{ $payment->order->phone }}</td>
                <td>{{ $payment->order->email }}</td>
                <td>{{ $payment->payment_method }}</td>
                <td>{{ $payment->order->address }}</td>
                <td>{{ $payment->order->sub_total }}</td>
                <td>{{ $payment->order->delivery_fee }}</td>
                <td>{{ $payment->order->total }}</td>
                <td>{{ $payment->order->deliver_status }}</td>
                <td>{{ $payment->payment_status }}</td>
                <td>{{ $payment->order->note }}</td>
                <td>{{ $payment->created_at->format('Y-m-d H:i:s') }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
