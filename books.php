  <!DOCTYPE html>

<html>

  <head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="jqueryCalendar/star-rating.css">
    <link rel="stylesheet" href="jqueryCalendar/star-rating.min.css">
    <script src="jqueryCalendar/star-rating.min.js" type="text/javascript"></script>
    <script src="jqueryCalendar/star-rating.js" type="text/javascript"></script>
    <link rel="stylesheet" href="style.css">
  </head>


  <body>
    <div class="header">
      <div id="amazon-logo">
        <img src="images/amazon-logo.jpg" style="height:60px">
      </div>
      <div id="user">
        <!-- user is already signed in then the username will be that username,
         else username will be "Sign In" 
        --><?php
        session_start();
        if(isset($_SESSION['username']))
        {
        echo "
        <div class='dropdown' id='name-menu'>
          <button class='btn btn-default dropdown-toggle' type='button' data-toggle='dropdown'>Welcome,". $_SESSION['username']."
          <span class='caret'></span></button>
          <ul class='dropdown-menu' role='menu' aria-labelledby='menu1'>
            <!-- for logged in, would be something else-->
            <li role='presentation'><a role='menuitem' tabindex='-1' href='userProfile.php'>Your Profile</a></li>
            <li role='presentation'><a role='menuitem' tabindex='-1' href='checkLogin.php'>Logout</a></li>
          </ul>
        </div>";
      }
      else
      {
        echo '
        <div class="dropdown" id="name-menu">
          <button class="btn btn-default dropdown-toggle" type="button" data-toggle="dropdown">Not Logged In?
          <span class="caret"></span></button>
          <ul class="dropdown-menu" role="menu" aria-labelledby="menu1">
            <!-- for logged in, would be something else-->
            <li role="presentation"><a role="menuitem" tabindex="-1" href="userLogin.php">Sign In</a></li>
            <li role="presentation"><a role="menuitem" tabindex="-1" href="userRegistration.php">Sign Up</a></li>
          </ul>
        </div>';}
        ?>
      </div>
    </div>

    <div class="navbar">
      <ul class="nav nav-tabs" role="tablist">
        <li class="nav-tab"><a href="home.php">Buy a Kindle</a></li>
        <li class="active nav-tab"><a href="books.php">Kindle eBooks</a></li>
        <li class="nav-tab"><a href="search.php">Advanced Search</a></li>
        <li class="nav-tab"><a href="about.php">About</a></li>        
      </ul>
    </div>

    <div class="container" id="product-container">
      <div class="product-carousel">
        <div class="carousel-mover btn" id="left-arrow1"><</div>
        <div class="product-list" id="product-list1"><div class="viewport" id="viewport1">
             <?php
                try {
                $db = new PDO("mysql:host=localhost;dbname=KINDLE", "root", "123");
                $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                }
  
                catch (PDOException $e) {
                printf("Unable to open database: %s\n", $e->getMessage());
                }
                if(isset($_POST["title"]))
          {
            $title=addslashes($_POST["title"]);
            $rating=addslashes($_POST["rating"]);
            $desc=addslashes($_POST["desc"]);
            $date=date("Y-m-d H:i:s");
            $rat=0;
            $id=0;
              try
                {
                $sel2 = $db->prepare("select User_Id from Users where User_Name ='".$_SESSION["username"]."'");
                $sel2->execute();
                global $id;
                $id=$sel2->fetchColumn();
                }
                catch (PDOException $e) {
                    printf("We had a problem: %s\n", $e->getMessage());
                }
                
                try
                {
                  $qins = $db->prepare("insert into Review values "."(:id,:date,:title,:desc,:rating,:asin)");
                        $qins->bindParam(':id', $id);
                        $qins->bindParam(':date', $date);
                        $qins->bindParam(':title', $title);
                        $qins->bindParam(':desc', $desc);
                        $qins->bindParam(':rating', $rating);
                        $qins->bindParam(':asin', $_POST["Asin"]);
                        $qins->execute();
                }
                catch (PDOException $e) {
                    printf("We had a problem: %s\n", $e->getMessage());
                }
                try
                {
                  $sel4 = $db->prepare("select Rating from Product where Asin='".$_POST['Asin']."'");
                  $sel4->execute();
                  global $rat;
                  $rat=$sel4->fetchColumn();
                }
                catch (PDOException $e) {
                    printf("We had a problem: %s\n", $e->getMessage());
                }
                if(!is_null($rat))
                  $rat=(float)($rating+$rat)/2;
                else
                  $rat=$rating;
                try
                {
                  $sel5 = $db->prepare("update Product set Rating=:rat where Asin=:asin");
                  $sel5->bindParam(':rat',$rat);
                  $sel5->bindParam(':asin',$_POST["Asin"]);
                  $sel5->execute();
                }
                catch (PDOException $e) {
                    $sel4->bindParam(':rat',$rat);
                }
          }
                try    
                  {
                  $sel1 = $db->prepare("select * from books,Product where Product.Asin=books.Asin");
                  $sel1->execute();
                  $i=1;
                   
             $rows = $sel1->fetchAll();
             foreach ($rows as $row)
                  { 
                    echo  '<div class="product" id="product'.(string)$i.'" onclick="select_product('.(string)$i.')">
            <img class="product-image" src="'.$row["Image"].'">
            <label for="product-image1" class="product-label">
            '.$row['title'].'<br>
            <small>'.$row['Asin'].'</small>
            </label>
          </div>';
                  $i = $i + 1;
                  
                 }
                 
                }
                catch (PDOException $e) {
                printf("Unable to open database: %s\n", $e->getMessage());
                }
        echo'</div></div>        
        <div class="carousel-mover btn" id="right-arrow1">></div>
      </div>
      <div class="product-display">';
           
              $i=1;
             foreach ($rows as $row)
             #while($row = $sel1->fetch(PDO::FETCH_ASSOC))
             { 
            
          echo'<div class="product-information" id="info'.(string)$i.'" >
          <div class="page-piece">
            <img class="info-image" src="'.$row["Image"].'" />
            <h2 class="info-heading">
            '.$row['title'].'<br><small>'.$row['Asin'].'</small><br>
            <div class="inline-piece" >
              <div class="orange-heading"> Price<span class="piece-heading"> $'.$row['Price'].'</span> </div>';
                echo'<div class="piece-heading" style="color:green">'.$row['author'].' </div>';
                if(is_null(($row["Rating"])))
              echo'<small>NOT RATED</small>';
            else
              echo'<input id="input-1" class="rating"  data-min="0" data-max="5" data-step="1" data-size="xs" name="rating" value="'.$row["Rating"].'">';    
       
          echo'</div>
            </h2>

            <div class="inline-piece" >';
              try    
                  {
                  $sel2 = $db->prepare("show columns from books");
                  $sel2->execute();
                  $ro = $sel2->fetchAll();
                  foreach ($ro as $ro1)
                  {
              echo'<div class="page-piece" style="border:none;">';
                   echo'<span>'.strtoupper($ro1["Field"]).'</span><span style="float:right">'.$row[$ro1["Field"]].'</span>
              </div>';
            }

            }
            catch (PDOException $e) {
                printf("Unable to open database: %s\n", $e->getMessage());
                }
            echo'</div>

            <div class="inline-piece" style="font-size:16px; width:60%">'.
              $row["Description"].'
            </div></div>';
             if(isset($_SESSION["username"]))
              {
          echo'<div class="page-piece">
            <h2 class="info-heading">Write a Review</h2>
            <form method="POST" action="" class="form-horizontal" role="form"  >

          <div class="form-piece">
            <div class="form-group">
              <label class="control-label col-sm-2" for="email">Title:</label>
              <div class="col-sm-10">
                <input type="text" class="form-control" id="email" placeholder="Enter Title" name="title" required>
              </div>
            </div>
            <div class="form-group">
              <label class="control-label col-sm-2"  for="email">Rating:</label>
              <div class="col-sm-10">
                
              <input id="input-1" class="rating"  data-min="0" data-max="5" data-step="1" data-size="xs" name="rating" >
              </div>
            </div>
            <div class="form-group">
              <label class="control-label col-sm-2" for="pwd">Description:</label>
              <div class="col-sm-10">          
                <textarea rows="10" columns="30" class="form-control" id="pwd" placeholder="Enter Description" name="desc" required></textarea>
                <input type="hidden" name="Asin" value="'.$row["Asin"].'">
              </div>
            </div>
            
          

          <div class="form-group">        
            <div class="col-sm-offset-2 col-sm-10">
              <input type="submit" class="btn btn-default form-submit" value="Enter" name="submit">
            </div>
          </div>

        </form>
      

          </div></div>';

        }
        echo'<div class="page-piece">
        <h2 class="info-heading">Reviews</h2>';
        try
        {
          $sel5=$db->prepare("select * from Review where Asin='".$row["Asin"]."'");
          $sel5->execute();
          $coll=$sel5->fetchAll();
          $user='';
          foreach ($coll as $col) 
          {
            echo'<div><input id="input-1" class="rating"  data-min="0" data-max="5" data-step="1" data-size="xs"
             name="rating" value="'.$col["Rating"].'">'.$col['Title'].'</div>';
             try
             {
              $sel6=$db->prepare("select User_Name from Users where User_Id=".$col['User_ID']."");
              $sel6->execute();
              global $user;
              $user=$sel6->fetchColumn();
             }             
            catch (PDOException $e) {
          printf("Unable to open database: %s\n", $e->getMessage());
          }

             echo'<div>By '.$user.'</div>
             <div>'.$col['Details'].'</div>';
          }
        }
        
            catch (PDOException $e) {
          printf("Unable to open database: %s\n", $e->getMessage());
          }
        

         echo' </div>
        </div>
        
      </div>';
      $i = $i + 1;

    }
  
      ?>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
    <script>
      function setup_carousel(id){
        var left = document.getElementById("left-arrow"+id);
        var right = document.getElementById("right-arrow"+id);
        var viewport = document.getElementById("viewport"+id);
        viewport.style.marginLeft = "0%";
        viewport.style.width = "500%";
        var maxWidth = parseInt(document.getElementById("viewport"+id).style.width);
        
        left.addEventListener("click", function(){
          var margin = parseInt(viewport.style.marginLeft);
          if( margin!=0 ){
            margin = margin + 100;
            viewport.style.marginLeft = margin + "%";
          };
          });
        right.addEventListener("click", function(){
          var margin = parseInt(viewport.style.marginLeft);
          if( maxWidth + margin > 0 ){
            margin = margin - 100;
            viewport.style.marginLeft = margin + "%";
          };
        });
      };
      setup_carousel(1);

      var selected = NaN;
      function select_product(id){
        if(selected){
          document.getElementById("product"+selected).style.border = "";
          document.getElementById("info"+selected).style.display = "none";
        }
        document.getElementById("product"+id).style.border = "2px solid #E47911";
        document.getElementById("info"+id).style.display = "block";
        selected = id;
      };
      select_product(1);

    </script>
     <script src="jqueryCalendar/star-rating.min.js" type="text/javascript"></script>
    <script src="jqueryCalendar/star-rating.js" type="text/javascript"></script>
  </body>

</html>