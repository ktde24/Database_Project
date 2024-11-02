<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>의사 및 간호사 환자 정보</title>
    
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

// 의사별 환자 정보 및 진료 수 조회
$doctor_query = "SELECT d.Doc_ID, d.Doc_Name, COUNT(DISTINCT p.Pat_ID) AS Patient_Count,
                (SELECT COUNT(Treatment_ID) FROM Treatment WHERE Doc_ID = d.Doc_ID) AS Treatment_Count
                FROM Doctor d
                LEFT JOIN Patient p ON d.Doc_ID = p.Doc_ID
                GROUP BY d.Doc_ID";
$doctor_result = mysqli_query($conn, $doctor_query);

// 간호사별 환자 수 조회
$nurse_query = "SELECT n.Nurse_ID, n.Ner_Name, n.Ner_Responsibility, COUNT(p.Pat_ID) AS Patient_Count
               FROM Nurse n
               LEFT JOIN Patient p ON n.Nurse_ID = p.Nurse_ID
               GROUP BY n.Nurse_ID, n.Ner_Name, n.Ner_Responsibility";
$nurse_result = mysqli_query($conn, $nurse_query);

// 간호사 업무별 환자 수 배열 생성
$nurse_tasks = array();
while ($nurse_row = mysqli_fetch_assoc($nurse_result)) {
    $nurse_id = $nurse_row['Nurse_ID'];
    $task = $nurse_row['Ner_Responsibility'];
    $patient_count = $nurse_row['Patient_Count'];

    if (!isset($nurse_tasks[$task])) {
        $nurse_tasks[$task] = array();
    }

    $nurse_tasks[$task][] = array('Nurse_ID' => $nurse_id, 'Nurse_Name' => $nurse_row['Ner_Name'], 'Patient_Count' => $patient_count);
}

?>


<div class="result">
<h2 style="color:green;">의사별 환자 정보</h2>
<table>
    <thead>
    <tr>
        <th>의사 ID</th>
        <th>의사 이름</th>
        <th>담당 환자 수</th>
        <th>진료 수</th>
    </tr>
    </thead>
    <?php while ($doctor_row = mysqli_fetch_assoc($doctor_result)) { ?>
        <tr>
            <td><?= $doctor_row['Doc_ID'] ?></td>
            <td><?= $doctor_row['Doc_Name'] ?></td>
            <td><?= $doctor_row['Patient_Count'] ?></td>
            <td><?= $doctor_row['Treatment_Count'] ?></td>
        </tr>
    <?php } ?>
</table>
</div>

<div class ="result2">
<h2 style="color:green">간호사별 환자 정보</h2>
<?php foreach ($nurse_tasks as $task => $nurses) { ?>
    <h3><?= $task ?></h3>
    <table>
        <thead>
        <tr>
            <th>간호사 ID</th>
            <th>간호사 이름</th>
            <th>담당 환자 수</th>
        </tr>
        </thead>
        <?php foreach ($nurses as $nurse) { ?>
            <tr>
                <td><?= $nurse['Nurse_ID'] ?></td>
                <td><?= $nurse['Nurse_Name'] ?></td>
                <td><?= $nurse['Patient_Count'] ?></td>
            </tr>
        <?php } ?>
    </table>

<?php } ?>
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
    .menu li a {
        text-decoration-line: none;
        font-size: 16px; line-height:30px; color:#555; 
    }
    h1{font-size:18px; padding 20px; }
    li{height: 50px; margin-left: 10px; list-style-type: none;}
    ul{margin-top:200px;}
    .result{ margin-left: 280px; margin-top:20px;
    }
    .result2{ margin-left: 280px; margin-top:20px;
    }
        table {
            border-collapse: collapse;
            margin-bottom: 20px;
            width:900px;
        }

        th, td {
            border: 1px solid black;
            padding: 8px;
        }
        tr {
            text-align: center;
        }
        thead{
        background-color: #39BE66
        }
    </style>
</html>