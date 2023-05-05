<!DOCTYPE html>
<html>
  <head>
    <title>選課系統</title>
  </head>
  <center>
  <p><h2>學生選課系統</h2></p>
</center>
  <body>


    <?php
    // 資料庫連接資訊
    $dbhost = "127.0.0.1";
    $username = "hj";
    $password = "test1234";
    $dbname = "coursedb";

    // 建立連接
    $conn = new mysqli($dbhost, $username, $password, $dbname);

    // 檢查連接
    if ($conn->connect_error) {
      die("連接失敗：" . $conn->connect_error);
    }

    // 檢查是否有收到學生學號
    if (isset($_POST["student_id"])) {
      // 取得學生資訊
      $sql = "SELECT * FROM Student WHERE student_id= '".$_POST["student_id"]."'";
      $result = $conn->query($sql);

      if ($result->num_rows > 0) {
        // 顯示學生資訊
        $row = $result->fetch_assoc();
        echo "學號：" . $row["student_id"] . "<br>";
        echo "姓名：" . $row["student_name"] . "<br>";
        echo "系級：" . $row["department_name"] . "<br>";

        // 顯示已選課表按鈕
        echo '<button onclick="location.href=\'?action=show_courses&student_id='.$row["student_id"].'\'">已選課表</button>';
      } else {
        echo "查無此學生";
      }
    }

    if(!isset($_POST["student_id"])&& !isset($_GET["action"])){
      echo'<h2>輸入學號</h2>
      <form method="post" action="">
        <input type="text" name="student_id" required>
        <button type="submit">查詢</button>
      </form>';
    }

    // 檢查學生是否已經加選了該課程
    $sql = "SELECT * FROM courseselection WHERE student_id = '$student_id' AND course_id = '$course_id'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
      echo "You have already selected this course.";
    } else {
      // 如果學生還沒有加選該課程，則將其加入 course_selection 資料表中
      $sql = "INSERT INTO courseselection (student_id, course_id) VALUES ('$student_id', '$course_id')";
      if ($conn->query($sql) === TRUE) {
        echo "Course selected successfully.";
      } else {
        echo "Error selecting course: " . $conn->error;
      }
    }
  }
    
    // 檢查是否要顯示已選課表
    if (isset($_GET["action"]) && $_GET["action"] == "show_courses") {
      // 取得學生已選課表資訊
      $sql = "SELECT course.course_id,course.course_name,course.time,course.day,course.course_credit,course.course_type,course.teachers_name FROM course INNER JOIN courseselection ON course.course_id = courseselection.course_id WHERE student_id = '".$_GET["student_id"]."'ORDER BY course.day ASC, course.time ASC";
      $result = $conn->query($sql);

      if ($result->num_rows > 0) {
        // 計算已選總學分數
        $total_credit = 0;
        while ($row = $result->fetch_assoc()) {
          $total_credit += $row["course_credit"];
        }

        // 顯示已選課表資訊和已選總學分數
        echo "<h2>已選課表</h2>";
        echo "<table>";
        echo "<tr><th>課程編號</th><th>課程名稱</th><th>時段</th><th>上課日</th><th>學分數</th><th>課程類別</th><th>教師姓名</th></tr>";
        mysqli_data_seek($result, 0);
        while($row = $result->fetch_assoc()) {
          echo "<tr><td style='text-align: center;'>" . $row["course_id"] . "</td><td style='text-align: center;'>" . $row["course_name"] . "</td><td style='text-align: center;'>" . $row["time"] . "</td><td style='text-align: center;'>". $row["day"] . "</td><td style='text-align: center;'>". $row["course_credit"] . "</td><td style='text-align: center;'>". $row["course_type"] . "</td><td style='text-align: center;'>". $row["teachers_name"] . "</td></tr>";
        }
        echo "</table>";
        echo "<p>已選總學分數： " . $total_credit . "</p>";
    } else {
      echo "尚未選課";
    }
  }

  // 關閉連接
  $conn->close();
  ?>

  </body>
</html>
