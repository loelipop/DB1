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
    
     // 檢查是否有 POST 請求
  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // 從 POST 請求中獲取學生選擇的課程 ID
    $course_id = $_POST["course_id"];

    // 從 SESSION 中獲取當前登錄的學生 ID
    session_start();
    $student_id = $_SESSION["student_id"];

    // 檢查是否已經加選了該課程
    $sql = "SELECT * FROM courseselection WHERE student_id = '$student_id' AND course_id = '$course_id'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
      echo "您已加選此課程.";
    } else {
      // 檢查該課程是否已滿
      $sql = "SELECT * FROM courses WHERE id = '$course_id'";
      $result = $conn->query($sql);
      if ($result->num_rows > 0) {
        $course = $result->fetch_assoc();
        if ($course["current_student"] >= $course["max_student"]) {
          echo "課程已滿";
        } 
      }
    }
        // 檢查學生已經選擇的課程的總學分是否超過最高學分限制
    $sql = "SELECT SUM(course_credit) as total_credit FROM courseselection JOIN courses ON courseselection.course_id = courses.id WHERE courseselection.student_id = '$student_id'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
      $row = $result->fetch_assoc();
      $total_credit = $row["total_credit"] + $course["course_credit"];
      if ($total_credit > 30) {
        echo "超過學分限制.";
        exit();
      }
    }
          // 檢查是否與已選課程同名
          $sql = "SELECT * FROM courseselection JOIN courses ON courseselection.course_id = courses.id WHERE courseselection.student_id = '$student_id' AND courses.course_name = '{$course["course_name"]}'";
          $result = $conn->query($sql);
          if ($result->num_rows > 0) {
            echo "課程同名";
         
    
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
