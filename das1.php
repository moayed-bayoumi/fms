<body>
<?php
include 'include/header.php';
include 'include/functions.php';
  $delivery_date = "2023-02-28";
  $current_date = date("Y-m-d");
  $days_remaining = (strtotime($delivery_date) - strtotime($current_date)) / 86400;
  $percentage = 100 - (($days_remaining / 30) * 100);

  if ($percentage >= 0 && $percentage <= 25) {
    $color = "red";
  } elseif ($percentage > 25 && $percentage <= 50) {
    $color = "yellow";
  } elseif ($percentage > 50 && $percentage <= 75) {
    $color = "blue";
  } else {
    $color = "green";
  }
?>
<div class="progress-bar">
  <div class="percentage" style="width: <?php echo $percentage; ?>%; background-color: <?php echo $color; ?>;"><?php echo round($percentage); ?>%</div>
</div>
</body>
</html>




