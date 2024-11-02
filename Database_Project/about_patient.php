<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>환자 직종별 환자 수</title>
    
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
$conn = mysqli_connect("localhost", "web", "web_admin", "ewhahospital");
if (mysqli_connect_errno()) {
    echo "Database Connection Error!!";
    exit();
}
mysqli_set_charset($conn, 'utf8');

$occupations = array(
    "학생" => array("대학생", "초등학생", "중학생", "유치원생", "고등학생", "어린이집 재학"),
    "정보통신 연구개발직 및 공학기술직" => array("개발자"),
    "건설.채굴 연구개발직 및 공학기술직" => array("건축가"),
    "교육직" => array("교수", "교사", "강사"),
    "법률직" => array("변호사", "판사", "검사"),
    "예술.디자인.방송직" => array("작가", "PD", "사진작가", "화가"),
    "음식 서비스직" => array("한식조리사"),
    "스포츠.레크리에이션 종사자" => array("축구선수", "배구선수", "야구선수"),
    "금융.보험직" => array("보험설계사"),
    "미용.예식 서비스직" => array("헤어디자이너"),
    "경찰.소방.교도직" => array("경찰"),
    "군인" => array("군인"),
    "보건.의료직" => array("간호사", "의사", "약사", "안경사"),
    "관리직" => array("경비원"),
    "무직" => array()
);

$occupation_results = array();
foreach ($occupations as $occupation => $jobs) {
    $escaped_occupation = mysqli_real_escape_string($conn, $occupation);
    $escaped_jobs = array_map(function ($job) use ($conn) {
        return mysqli_real_escape_string($conn, $job);
    }, $jobs);

    $query = "SELECT COUNT(p.Pat_ID) AS Patient_Count
              FROM Patient p
              WHERE p.Pat_Job = '$escaped_occupation'";

    if (!empty($jobs)) {
        $escaped_jobs_str = "'" . implode("', '", $escaped_jobs) . "'";
        $query .= " OR p.Pat_Job IN ($escaped_jobs_str)";
    }

    $result = mysqli_query($conn, $query);
    $occupation_results[$occupation] = mysqli_fetch_assoc($result);
    mysqli_free_result($result);
}
?>
<div class="result">
<h2 style="color:green;">환자 직종별 환자 수</h2>
<table>
    <thead>
    <tr>
        <th>직종</th>
        <th>환자 수</th>
    </tr>
    </thead>
    <?php foreach ($occupation_results as $occupation => $result) { ?>
        <tr>
            <td><?= $occupation ?></td>
            <td><?= $result['Patient_Count'] ?></td>
        </tr>
    <?php } ?>
</table>
</div>
<?php
mysqli_close($conn);
?>
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