<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>진료과목별 환자 및 진료 정보 조회</title>
</head>
<nav>
    <ul class="menu">
        <li><a href="mainhome.php">+Home</a></li>
        <li><a href="about_patient.php">+About 환자</a></li>
        <li><a href="about_docnur.php">+About 의사&간호사</a></li>
        <li><a href="about_sub.php">+About 진료과</a></li>
</nav>
<body>
   
   
   <?php
    header('Content-Type: text/html; charset=utf-8');
    
    $conn = mysqli_connect("localhost", "web", "web_admin", "ewhahospital");
    if (mysqli_connect_errno()) {
        echo "Database Connection Error!!";
        exit();
    }
    mysqli_set_charset($conn, 'utf8');

    // 진료과목별 환자 수 쿼리
    $subject_query = "SELECT D.Subject, COUNT(*) AS patient_count FROM Patient P
                      INNER JOIN Doctor D ON P.Doc_ID = D.Doc_ID
                      GROUP BY D.Subject";
    $subject_result = mysqli_query($conn, $subject_query);
    ?>


    <div class="result">
    <h2 style="color:green;">진료과목별 환자 수</h2>
    <table border="1">
        <tr>
            <thead>
            <td>진료과목</td>
            <td>환자 수</td>
            </thead>
        </tr>
        <?php while ($row = mysqli_fetch_assoc($subject_result)) { ?>
            <tr>
                <td><?= $row['Subject'] ?></td>
                <td><?= $row['patient_count'] ?></td>
            </tr>
        <?php } ?>
    </table>
    
    <?php
    // 진료과목 선택
    if (isset($_GET['subject'])) {
        $subject = $_GET['subject'];

        // 환자/진료 정보 조회
        $patient_query = "SELECT P.Pat_Name, T.Content, T.Date FROM Treatment T
                        INNER JOIN Patient P ON T.Pat_ID = P.Pat_ID
                        INNER JOIN Doctor D ON T.Doc_ID = D.Doc_ID
                        WHERE D.Subject = '$subject'";
        $patient_result = mysqli_query($conn, $patient_query);
        ?>
        
        <h2><?= $subject ?> 진료과목 환자/진료 정보</h2>
        <table border="1">
            <tr>
            <thead>
                <td>환자 이름</td>
                <td>진료 내용</td>
                <td>진료 날짜</td>
            </tr>
            </thead>
            <?php while ($row = mysqli_fetch_assoc($patient_result)) { ?>
                <tr>
                    <td><?= $row['Pat_Name'] ?></td>
                    <td><?= $row['Content'] ?></td>
                    <td><?= $row['Date'] ?></td>
                </tr>
            <?php } ?>
        </table>
    <?php } else {
        ?>
        <form action="" method="GET">
    <label for="subject">진료과목 선택:</label>
    <select name="subject" id="subject">
        <option value="" selected disabled>선택하세요</option>
        <?php mysqli_data_seek($subject_result, 0); ?>
        <?php while ($row = mysqli_fetch_assoc($subject_result)) { ?>
            <option value="<?= $row['Subject'] ?>"><?= $row['Subject'] ?></option>
        <?php } ?>
    </select>
    <input type="submit" value="조회">
</form>
    <?php } ?>

    <?php
    mysqli_free_result($subject_result);
    mysqli_close($conn);
    ?>
</div>
</body>
<style>
        table {
        
            border-collapse: collapse;
            margin-bottom: 20px;
            width:900px;
        }
        tr {
            text-align: center;
        }
        th, td {
            border: 1px solid black;
            padding: 8px;
        }
        thead{
        background-color: #39BE66
    }
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
    .menu li a {
        text-decoration-line: none;
        font-size: 16px; line-height:30px; color:#555; 
    }
    h1{font-size:18px; padding 20px; }
    li{height: 50px; margin-left: 10px; list-style-type: none;}
    ul{margin-top:200px;}
    .result{ margin-left: 280px; margin-top:20px;
    }
    </style>
</html> 