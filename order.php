<?php
require('Dbconnects.php');
$member_HN=$_GET["HN"];

session_start();

    if (!isset($_SESSION['username'])) {
        $_SESSION['msg'] = "You must log in first";
        header('location: login.php');
    }

    if (isset($_GET['logout'])) {
        session_destroy();
        unset($_SESSION['username']);
        header('location: login.php');
    }


?>



<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Cardiac center</title>
    <link
      rel="stylesheet"
      href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css"
      integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z"
      crossorigin="anonymous"
    />
    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css"
      rel="stylesheet"
      integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3"
      crossorigin="anonymous"
    />
 
    <link rel="stylesheet" href="/css/styles_web.css" />
    <link rel="stylesheet" href="/css/styles_order.css" />
  </head>

  <body>
    <nav class="navbar navbar-expand-lg navbar-light">
      <div class="container-fluid">
        <a class="navbar-brand" href="insertForm.php"
          ><img
            src="/img/heart.png"
            width="60"
            height="50"
            class="d-inline-block align-text-center"
          />Cardiac Center</a
        >
        <button
          class="navbar-toggler"
          type="button"
          data-bs-toggle="collapse"
          data-bs-target="#navbarSupportedContent"
          aria-controls="navbarSupportedContent"
          aria-expanded="false"
          aria-label="Toggle navigation"
        >
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <ul class="navbar-nav me-auto my-2 my-lg-0">
            <li class="nav-item ">
              <a class="nav-link" href="insertForm.php">Register</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="update.php">Update</a>
            </li>
            <li class="nav-item dropdown">
              <a class="nav-link active" href="patients-lits.php">Patient List</a>
            </li>
            <li class="nav-item dropdown">
              <a
                class="nav-link dropdown-toggle"
                href="#"
                id="navbarScrollingDropdown"
                role="button"
                data-bs-toggle="dropdown"
                aria-expanded="false"
              >
                Profile
              </a>
              <ul
                class="dropdown-menu"
                aria-labelledby="navbarScrollingDropdown"
              >
                <li><a class="dropdown-item" href="#">Profile</a></li>
                <li><a class="dropdown-item" href="#">Setting</a></li>
                
              </ul>
            </li>
          </ul>
        </div>
      </div>
    </nav>

    <h1 class="center-align">Prescription</h1>
    <div class="container">
      <div class="card">
        <div class="card-body">
          <?php 
          require('Dbconnects.php');
          $sql="SELECT * FROM patient WHERE member_HN =$member_HN";
          $result=mysqli_query($connect,$sql);
          $row=mysqli_fetch_assoc($result);
          $date = date("Y-m-d");
          ?>

          <form class="row g-3">
            <div class="col-md-4">
              <label for="inputEmail4" class="form-label">HN:</label>
              <input
                type="text"
                readonly
                class="form-control"
                id="inputText"
                value="<?php echo $row['member_HN'] ;?>"
              />
            </div>
            <div class="col-md-4">
              <label for="inputPassword4" class="form-label">Firstname:</label>
              <input type="text" readonly class="form-control" id="staticText"
              value="<?php echo $row["member_fname"] ;?>" />
            </div>
            <div class="col-md-4">
              <label for="inputEmail4" class="form-label">Lastname:</label>
              <input type="text" readonly class="form-control" id="staticText"
              value="<?php echo $row["member_lname"] ;?>" />
            </div>
            <div class="col-md-4">
              <label for="inputPassword4" class="form-label">Gender:</label>
              <input type="text" readonly class="form-control" id="staticText"
              value="<?php echo $row["member_gender"] ;?>" />
            </div>
            <div class="col-md-6">
              <label for="inputCity" class="form-label">Age:</label>
              <input type="text" readonly class="form-control" id="staticText"
              value="<?php echo $row["member_age"] ;?>" />
            </div>
            <div class="col-md-4">
              <label for="inputState" class="form-label">วันที่ลงข้อมูล:</label>
              <input
                type="text"
                readonly
                class="form-control"
                id="inputText3"
                value="<?php echo $date ;?>"
              />
            </div>
            
          </form>
        </div>
      </div>
    </div>
    

    <h2 class="center-align">ใบสั่งยา</h2>
    <div class="container">
      <div class="card">
        <div class="card-body">

        <form action="searchMed.php?HN=<?php echo $row["member_HN"];?>" class="form-group" method=POST>
             <div class="row mb-3">
              <div class="row">
                <label for="inputText1" class="col-sm-1 col-form-label">ค้นหา</label>
                <div class="col-sm-10">
                  <input type="text" class="form-control" placeholder="ป้อนโค้ดหรือชื่อยา" name = "medname"/>
                  <input type="submit" value="Search" class="btn btn-dark my-2">
                </div>
              </form>
              <table class="table table-hover">
              <a id="btnEmpty" href="index.php?action=empty">Empty Cart</a>
              <?php if(isset($_SESSION["cart_item"])){
                $total_quantity = 0; 
              }
              ?> 
              <thead>
              <tr>
                <th scope="col">CODE</th>
                <th scope="col">ชื่อยา</th>
                <th scope="col">รูปภาพบรรจุภัณฑ์ยา</th>
                <th scope="col">รูปภาพลักษณะยา</th>
                <th scope="col">Add</th>
              </tr>
            </thead>
            <tbody>
            <?php 
              require('Dbconnects.php');
              $sql = "SELECT * FROM medicine ORDER BY med_code ASC";
              $result=mysqli_query($connect,$sql);
              while ($row=mysqli_fetch_assoc($result)) {?>
              <tr>
                <td> <?php echo $row["med_code"] ;?> </td>
                <td> <?php echo $row["med_n"] ;?></td>
                <td> <img src="med_pm/<?php echo $row["med_pp"] ;?>" width="100px" heigth="100px" ></td>
                <td> <img src="med_pm/<?php echo $row["med_pm"] ;?>" width="100px" heigth="100px" ></td> 
                <td> <input type="submit" value="Add" class="btnAddAction"></td>
              <?php } ?>
              
            </tbody>
          </table>
              </div>
            </div>
            
            <div class="row mb-3">
              <label for="inputText3" class="col-sm-1 col-form-label"></label>
              <div class="col-sm-10">
                <div class="card" style="height: 10rem">
                  <div class="card-body">
                  </div>
                </div>
              </div>
            </div>
            <div class="row row-cols-lg-auto g-3 align-items-center">
              <label for="inputText3" class="col-sm-1 col-form-label label-1"
                >วันละ (เม็ด/ครั้ง)</label
              >
              <div class="col-sm-10">
                <input type="text" class="form-control" id="inputText" />
              </div>
              <label for="inputText3" class="col-sm-1 col-form-label label-1"
                >เวลา</label
              >
              <div class="col-sm-10">
                <input type="text" class="form-control" id="inputText" />
              </div>
            </div>
            <div class="row row-cols-lg-auto g-3 align-items-center">
              <label for="inputText3" class="col-sm-1 col-form-label label-1"
                >Drug Signature</label
              >
              <div class="col-sm-10">
                <input type="text" class="form-control" id="inputText" />
              </div>
            </div>

            <div class="center-align">
            <button type="submit" class="btn btn-coler">ADD</button>
          </div>
        
        </div>
      </div>
    </div>

    <h3 class="center-align">บันทึกการสั่งยา</h3>
    <div class="container">
      <div class="card mb-3">
        <div class="card-body">
          <br />
          <table class="table table-bordered">
            <thead>
              <tr>
                <th scope="col"></th>
                <th scope="col">รายการยา</th>
                <th scope="col">ครั้งละกี่เม็ด</th>
                <th scope="col">เวลาที่รับประทาน</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td>
                  <a href="#" class="btnRemoveAction">
                    <img src="/img/cut.png" alt="Remove Item" width="30" height="32" />
                  </a>
                </td>
                <td>Aspent-M Tab 81 mg</td>
                <td>2</td>
                <td>3 ครั้ง หลังอาหารเช้า กลางวัน เย็น</td>
              </tr>
            </tbody>
          </table>

          <div class="center-align">
            <button type="submit" class="btn btn-coler">SAVE</button>
            <a href="/html/table.html" class="nav-link">Preview</a>
          </div>
        </div>
      </div>
      <br /><br />
    </div>

    <script
      src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"
      integrity="sha384-7+zCNj/IqJ95wo16oMtfsKbZ9ccEh31eOz1HGyDuCQ6wgnyJNSYdrPa03rtR1zdB"
      crossorigin="anonymous"
    ></script>
    <script
      src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js"
      integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13"
      crossorigin="anonymous"
    ></script>
  </body>
</html>
