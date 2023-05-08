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
        echo "系所：" . $row["department_name"] . "<br>";
        echo "年級：" . $row["grade"] . "<br>";
		
		// 顯示已選課表按鈕
		echo '<button onclick="location.href=\'?action=show_courses&student_id='.$row["student_id"].'\'">已選課表</button>';
    echo "<br>";
    echo '<button onclick="location.href=\'?action=add_courses&student_id='.$row["student_id"].'\'">可加選課表</button>';
    echo "<br>";
		// 顯示重新輸入學號的按鈕
		echo '<button onclick="location.href=\'\'">重新輸入學號</button>';
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

    if(isset($_GET["action"]) && $_GET["action"] == "add_courses"){
      $sql="SELECT * FROM course";
      $result = $conn->query($sql);
      if($result->num_rows > 0){
         // 顯示已選課表資訊和已選總學分數
         echo "<h2>可加選課表</h2>";
		
         // 新增返回主頁的按鈕
         echo '<button onclick="window.history.back()">返回主頁</button>';
     
         echo "<table>";
         echo "<tr><th>課程編號</th><th>課程名稱</th><th>時段</th><th>上課日</th><th>學分數</th><th>課程類別</th><th>年級</th><th>教師姓名</th><th>系所</th><th>最多可收</th><th>現在修課人數</th></tr>";
        
        while($row = $result->fetch_assoc()) {
          echo "<tr><td style='text-align: center;'>" . $row["course_id"] . "</td><td style='text-align: center;'>" . $row["course_name"] . "</td><td style='text-align: center;'>" . $row["time"] . "</td><td style='text-align: center;'>". $row["day"] . "</td><td style='text-align: center;'>". $row["course_credit"] . "</td><td style='text-align: center;'>". $row["course_type"] . "</td><td style='text-align: center;'>" . $row["grade"] ."</td><td style='text-align: center;'>". $row["teachers_name"] . "</td><td style='text-align: center;'>" . $row["department_name"] ."</td><td style='text-align: center;'>" . $row["max_student"] ."</td><td style='text-align: center;'>" . $row["current_student"] ."</td></tr>";
        }
        echo "</table>";

        echo "<form method='post' action=''>";
        echo "輸入課程編號加選：<input type='text' name='add_course_id' required>";
        echo "<button type='submit'>加選</button>";
        echo "</form>";
        echo "</td></tr>";

        if(isset($_POST["add_course_id"])){
          $sql = "SELECT * FROM course WHERE course_id='".$_POST["add_course_id"]."'";
          $result = $conn->query($sql);
          if($result->num_rows > 0){
            $row = $result->fetch_assoc();
            $selectedCourseName = $row["course_name"];
            $selectedCourseTime = $row["time"];
            $selectedCourseDay = $row["day"];

            // 拆分加選課程的時間段
            $selectedCourseTimeParts = explode("~", $selectedCourseTime);
            $selectedCourseStartTime = $selectedCourseTimeParts[0];
            $selectedCourseEndTime = $selectedCourseTimeParts[1];

            $sql = "SELECT course.course_name
            FROM student
            INNER JOIN courseselection ON student.student_id = courseselection.student_id
            INNER JOIN course ON courseselection.course_id = course.course_id
            WHERE student.student_id = '".$_GET["student_id"]."' AND course.day = '$selectedCourseDay' AND ((course.time >= '$selectedCourseStartTime' AND course.time <= '$selectedCourseEndTime')
            OR (SUBSTRING_INDEX(course.time, '~', -1) >= '$selectedCourseStartTime' AND SUBSTRING_INDEX(course.time, '~', -1) <= '$selectedCourseEndTime'))";
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
              // 衝堂不可加選
              echo "衝堂不可加選";
          } else {
              // 可以加選課程
              echo "加選成功";
          }
          }
        }
      }
	        // 檢查學生已經選擇的課程的總學分是否超過最高學分限制
    $sql = "SELECT SUM(credit) as total_credit FROM courseselection JOIN course ON courseselection.course_id = course.id WHERE courseselection.student_id = '$student_id'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
      $row = $result->fetch_assoc();
      $total_credit = $row["total_credit"] + $course["credit"];
      if ($total_credit > 30) {
        echo "Cannot add course due to maximum credit limit.";
        exit();
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
		
		    // 新增返回主頁的按鈕
		    echo '<button onclick="window.history.back()">返回主頁</button>';
		
        echo "<table>";
        echo "<tr><th>課程編號</th><th>課程名稱</th><th>時段</th><th>上課日</th><th>學分數</th><th>課程類別</th><th>教師姓名</th></tr>";
        mysqli_data_seek($result, 0);
        while($row = $result->fetch_assoc()) {
          echo "<tr><td style='text-align: center;'>" . $row["course_id"] . "</td><td style='text-align: center;'>" . $row["course_name"] . "</td><td style='text-align: center;'>" . $row["time"] . "</td><td style='text-align: center;'>". $row["day"] . "</td><td style='text-align: center;'>". $row["course_credit"] . "</td><td style='text-align: center;'>". $row["course_type"] . "</td><td style='text-align: center;'>". $row["teachers_name"] . "</td></tr>";
        }
        echo "</table>";
        echo "<p>已選總學分數： " . $total_credit . "</p>";
        echo "<tr><td colspan='7'>";
        echo "<form method='post' action=''>";
        echo "輸入課程編號退選：<input type='text' name='drop_course_id' required>";
        echo "<button type='submit'>退選</button>";
        echo "</form>";
        echo "</td></tr>";
        //退選
        if(isset($_POST["drop_course_id"])) {
          $sql = "SELECT * FROM course WHERE course_id='".$_POST["drop_course_id"]."'";
          $result = $conn->query($sql);
          if($result->num_rows > 0){
            $row = $result->fetch_assoc();
            //檢查是否為必修
            if($row["course_type"] == "必修") {
              echo "必修無法退選";
            } else {
              // 取得學生已選課程學分總和
              $sql = "SELECT course_credit FROM course INNER JOIN courseselection ON course.course_id = courseselection.course_id WHERE student_id = '".$_GET["student_id"]."'";
              $result = $conn->query($sql);
              
              if($result->num_rows > 0){
                $row = $result->fetch_assoc();
              }
              //檢查學分是否低於9分
              if($total_credit - $row["course_credit"] < 9){
                echo "已選總學分數不能低於9分，無法退選";
              } else {
                //進行退選
                $sql = "DELETE FROM courseselection WHERE student_id='".$_GET["student_id"]."' AND course_id='".$_POST["drop_course_id"]."'";
                if($conn->query($sql) == TRUE && mysqli_affected_rows($conn) > 0) {
                  echo "退選成功";
                  //更新課程人數
                  $sql = "UPDATE course SET current_student = (current_student - 1)";
                  $conn->query($sql);
                }else{
                  echo "退選失敗" . $conn->error;
                }
              }
            }
          }else{
            echo "查無此課";
          }
        }
    } else {
      echo "尚未選課";
    }
  }

  

  // 關閉連接
  $conn->close();
  ?>

  </body>
</html>
