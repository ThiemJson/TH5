<?php
require('dbconfig.php');

// Get status message
if (!empty($_GET['status'])) {
  switch ($_GET['status']) {
    case 'succ':
      $statusType = 'alert-success';
      $statusMsg = 'Members data has been imported successfully.';
      break;
    case 'err':
      $statusType = 'alert-danger';
      $statusMsg = 'Some problem occurred, please try again.';
      break;
    case 'invalid_file':
      $statusType = 'alert-danger';
      $statusMsg = 'Please upload a valid CSV file.';
      break;
    default:
      $statusType = '';
      $statusMsg = '';
  }
}
?>
<!doctype html>
<html lang="en">

<head>
  <title>Bài thực hành số 5</title>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>

<body>
  <!-- CSV file upload form -->
  <div class="col-md-12" id="importFrm">
    <form action="importdata.php" method="post" enctype="multipart/form-data">
      <input type="file" name="file" />
      <input type="submit" class="btn btn-primary" name="importSubmit" value="IMPORT">
    </form>
  </div>
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-12">
        <table class="table">
          <thead class="thead-dark">
            <tr>
              <th>STT</th>
              <th>Mã sinh viên</th>
              <th>Họ đệm</th>
              <th>Tên</th>
              <th>Ngày sinh</th>
              <th>Tổng TC</th>
              <th>Số tín chỉ TD</th>
              <th>Số tín chỉ LN</th>
              <th>Điểm TBC</th>
              <th>Điểm TBCQD</th>
              <th>Số môn không đạt</th>
              <th>Số TC DVHT</th>
            </tr>
          </thead>
          <tbody>
            <?php
            // Get member rows
            $result = $db->query("SELECT * FROM sinhvien ORDER BY id ASC");
            if ($result->num_rows > 0) {
              while ($row = $result->fetch_assoc()) {
            ?>
                <tr>
                  <td><?php echo $row['id']; ?></td>
                  <td><?php echo $row['maSV']; ?></td>
                  <td><?php echo $row['hodemSV']; ?></td>
                  <td><?php echo $row['tenSV']; ?></td>
                  <td><?php echo $row['ngaysinhSv']; ?></td>
                  <td><?php echo $row['tongtinchi']; ?></td>
                  <td><?php echo $row['stctd']; ?></td>
                  <td><?php echo $row['stcln']; ?></td>
                  <td><?php echo $row['dtbc']; ?></td>
                  <td><?php echo $row['dtbcqd']; ?></td>
                  <td><?php echo $row['somonkhongdat']; ?></td>
                  <td><?php echo $row['sotcdvht']; ?></td>
                </tr>
              <?php }
            } else { ?>
              <tr>
                <td colspan="5">No member(s) found...</td>
              </tr>
            <?php } ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
  <!-- Optional JavaScript -->
  <!-- jQuery first, then Popper.js, then Bootstrap JS -->
  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
  <!-- Show/hide CSV upload form -->
  <script>
    function formToggle(ID) {
      var element = document.getElementById(ID);
      if (element.style.display === "none") {
        element.style.display = "block";
      } else {
        element.style.display = "none";
      }
    }
  </script>
</body>

</html>