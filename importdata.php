<?php
// Load the database configuration file
include_once 'dbconfig.php';

function formatDate($date){
    // 17/05/2000
    $year = substr($date,6,9);
    $month = substr($date,3,3);
    $day = substr($date,0,0);

    return $year."-".$month."-".$day;
}

if (isset($_POST['importSubmit'])) {

    // Allowed mime types
    $csvMimes = array('text/x-comma-separated-values', 'text/comma-separated-values', 'application/octet-stream', 'application/vnd.ms-excel', 'application/x-csv', 'text/x-csv', 'text/csv', 'application/csv', 'application/excel', 'application/vnd.msexcel', 'text/plain');

    // Validate whether selected file is a CSV file
    if (!empty($_FILES['file']['name']) && in_array($_FILES['file']['type'], $csvMimes)) {

        // If the file is uploaded
        if (is_uploaded_file($_FILES['file']['tmp_name'])) {

            // Open uploaded CSV file with read-only mode
            $csvFile = fopen($_FILES['file']['tmp_name'], 'r');

            // Skip the first line
            fgetcsv($csvFile);
            fgetcsv($csvFile);
            fgetcsv($csvFile);
            fgetcsv($csvFile);
            fgetcsv($csvFile);
            fgetcsv($csvFile);
            fgetcsv($csvFile);
            fgetcsv($csvFile);

            // Parse data from CSV file line by line
            while (($line = fgetcsv($csvFile)) !== FALSE) {
                // Get row data
                $ma   = $line[1];
                $hodem  = $line[2];
                $ten  = $line[3];
                $ngaysinh = $line[4];
                $tongtinchi = $line[5];
                $sotinchitd = $line[6];
                $sotinchiln = $line[7];
                $diemtbc = $line[8];
                $diemtbcqd = $line[9];
                $somonkhongdat = $line[10];
                $sotinchidhvt = $line[11];
                
                $ngaysinhFormat = formatDate($ngaysinh);


                // Check whether member already exists in the database with the same email
                $prevQuery = "SELECT id FROM sinhvien WHERE maSV = '" . $line[1] . "'";
                $prevResult = $db->query($prevQuery);

                if ($prevResult->num_rows > 0) {
                    // Update member data in the database
                    $db->query("UPDATE sinhvien SET  hodemSV = '" . $hodem . "', tenSV = '" . $ten . "', ngaysinhSv = '".$ngaysinhFormat."' 
                    , tongtinchi = '" . $tongtinchi . "'
                    , stctd = '" . $sotinchitd . "'
                    , stcln = '" . $sotinchiln . "'
                    , dtbc = '" . $diemtbc . "'
                    , dtbcqd = '" . $diemtbcqd . "'
                    , somonkhongdat = '" . $somonkhongdat . "'
                    , sotcdvht = '" . $sotinchidhvt . "'
                    WHERE maSV = '" . $ma . "'");
                } else {
                    // Insert member data in the database
                    $sql = "INSERT INTO sinhvien(maSV, hodemSV, tenSV, ngaysinhSv, tongtinchi, stctd, stcln, dtbc, dtbcqd, somonkhongdat, sotcdvht) VALUES (" . $ma . ", '" . $hodem . "', '" . $ten . "', '" . $ngaysinhFormat . "', " . $tongtinchi . ", " . $sotinchitd . ", " . $sotinchiln . "," . $diemtbc . "," . $diemtbcqd . "," . $somonkhongdat . ", " . $sotinchidhvt . ");";
                    if (strlen($ma) == 10) {
                        $db->query($sql);
                        print_r($sql);
                    }
                }
            }

            // Close opened CSV file
            fclose($csvFile);

            $qstring = '?status=succ';
        } else {
            $qstring = '?status=err';
        }
    } else {
        $qstring = '?status=invalid_file';
    }
}

// Redirect to the listing page
header("Location: index.php" . $qstring);
