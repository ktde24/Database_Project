<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>환자 정보 조회</title>
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
    </style>
</html>