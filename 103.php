<html>
  <head>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css"/>
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
  </head>
  <body>
    <div class="nearby-orders">
      <table id="order-table" class="display">
        <thead>
          <tr>
            <th>Customer Name</th>
            <th>Product Name</th>
            <th>Order Date</th>
            <th>Delivery Date</th>
            <th>Remaining Days</th>
          </tr>
        </thead>
        <tbody>
          <?php while ($order = mysqli_fetch_assoc($result)) { ?>
            <tr>
              <td><?php echo $order['customer_name']; ?></td>
              <td><?php echo $order['product_name']; ?></td>
              <td><?php echo $order['order_date']; ?></td>
              <td><?php echo $order['delivery_date']; ?></td>
              <td><?php echo $order['remaining_days']; ?></td>
            </tr>
          <?php } ?>
        </tbody>
      </table>
    </div>
    <script>
      $(document).ready(function() {
        $('#order-table').DataTable({
          "lengthMenu": [
            [10, 25, 50, -1],
            [10, 25, 50, "All"]
          ],
          "columnDefs": [{
            "orderable": false,
            "targets": [5]
          }]
        });
      });
    </script>
  </body>
</html>
