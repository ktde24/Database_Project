<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>환자 정보 조회 결과</title>
</head>
<nav>
    <ul class="menu">
        <li><a href="mainhome.php">+Home</a></li>
        <li><a href="about_patient.php">+About 환자</a></li>
        <li><a href="about_docnur.php">+About 의사&간호사</a></li>
        <li><a href="about_sub.php">+About 진료과</a></li>
</nav>
<body>
<div class="imbody">
        <a style=" font-size:50px; font-style:bold; color:green; "> + EWHA HOSPITAL + </a>
        <h4 style="color:gray; margin-bottom:10px;"> Welcome To EWHA Hospital  </h4>
        <div style ="padding:20px; item-align:center;" >
        <h2 style="margin-top:0px; ">환자 정보 조회</h2>
    
        <form method="POST" action="searchpatient.php">
            <label for="patient_name" style="font-size:20px;font-style:bold;">환자 이름 :</label>
            <input type="text" id="patient_name" name="patient_name">
            <input type="submit" value="조회">
        </form>
        </div>
</div>
<div class="result">
    <h1 style="color:green;">[환자 정보 조회 결과]</h1>

    <?php
    header('Content-Type: text/html; charset=utf-8');
    $patient_name = $_POST['patient_name'];
    $birthday = substr($_POST['birthday'], 0, 6);

    $conn = mysqli_connect("localhost", "web", "web_admin", "ewhahospital");
    if (mysqli_connect_errno()) {
        echo "Database Connection Error!!";
        exit();
    }
    mysqli_set_charset($conn, 'utf8');

    $patient_query = "SELECT Pat_ID, Doc_ID, Nurse_ID, Pat_Name, Pat_Jumin, Pat_Gen, Pat_Add, Pat_Email, Pat_Phone, Pat_Job FROM Patient WHERE Pat_Name = '$patient_name' AND LEFT(Pat_Jumin, 6) = '$birthday'";
    $patient_result = mysqli_query($conn, $patient_query);
    $patient_count = mysqli_num_rows($patient_result);

    if ($patient_count === 1) {
        // Only one patient found
        $patient_row = mysqli_fetch_array($patient_result);
        $patient_id = $patient_row['Pat_ID'];

        $treatment_query = "SELECT Treatment_ID, Content, Date FROM Treatment WHERE Pat_ID = '$patient_id'";
        $treatment_result = mysqli_query($conn, $treatment_query);

        $chart_query = "SELECT Charts_Num, Doc_Comment FROM Charts WHERE Pat_ID = '$patient_id'";
        $chart_result = mysqli_query($conn, $chart_query);
        ?>

<table class ="patient_info" border="1">
        <thead>
        <tr>
            <th scope="cols">아이디</th>
            <th scope="cols">담당의사 아이디</th>
            <th scope="cols">담당간호사 아이디</th>
            <th scope="cols">이름</th>
            <th scope="cols">주민등록번호</th>
            <th scope="cols">성별</th>
            <th scope="cols">주소</th>
            <th scope="cols">메일</th>
            <th scope="cols">전화번호</th>
            <th scope="cols">직업</th>

        </tr>
        </thead>

        <tbody>
        <tr>
            <td><?= $patient_row['Pat_ID'] ?></td>
            <td><?= $patient_row['Doc_ID'] ?></td>
            <td><?= $patient_row['Nurse_ID'] ?></td>
            <td><?= $patient_row['Pat_Name'] ?></td>
            <td><?= $patient_row['Pat_Jumin'] ?></td>
            <td><?= $patient_row['Pat_Gen'] ?></td>
            <td><?= $patient_row['Pat_Add'] ?></td>
            <td><?= $patient_row['Pat_Email'] ?></td>
            <td><?= $patient_row['Pat_Phone'] ?></td>
            <td><?= $patient_row['Pat_Job'] ?></td>
        </tr>
        </tbody>    
        </table>
    
         <h4><?= $patient_row['Pat_Name'] ?> 환자 진료 정보</h4>
        <table class="patient_treat" border="1">
        <thead>
        <tr>
            <td>진료 아이디</td>
            <td>진료 날짜</td>
            <td>진료 내용</td>
            <td>차트 번호</td>
            <td>의사 소견</td>
            
        </tr>
        </thead>
        <?php while ($treatment_row = mysqli_fetch_array($treatment_result) and ($chart_row = mysqli_fetch_array($chart_result)) ) { ?>
            <tbody>
            <tr>
                <td><?= $treatment_row['Treatment_ID'] ?></td>
                <td><?= $treatment_row['Date'] ?></td>
                <td><?= $treatment_row['Content'] ?></td>
                <td><?= $chart_row['Charts_Num'] ?></td>
                <td><?= $chart_row['Doc_Comment'] ?></td>
                
            </tr>
            </tbody> 
        <?php } ?>
         </table>


        <?php
        mysqli_free_result($patient_result);
        mysqli_free_result($treatment_result);
        mysqli_free_result($chart_result);
    } else {
        // No patient found or multiple patients found
        echo "<h2>환자 정보를 찾을 수 없습니다.</h2>";
    }

    mysqli_close($conn);
    ?>
 </div>
</body>
<style>
    nav{
        width:240px;
        background-color:#eee;
        border-right:1px solid #eee;
        position:fixed;
        height:100%;
        top:0px;
        left:0px;
        border-right: dashed 2px;
    }
    h1{font-size:18px; padding 20px; }
    li{height: 50px; margin-left: 10px; list-style-type: none;}
    ul{margin-top:200px;}
  
    .imbody{text-align:center;}
    .menu li a {
        text-decoration-line: none;
        font-size: 16px; line-height:30px; color:#555; 
    }
    .result{ margin-left: 280px; margin-top:20px;

    }
    table{
        width:1200px;
    }
    thead{
        background-color: #39BE66
    }
    thead tr td{
        text-align: center;
    }
    </style>
</html>