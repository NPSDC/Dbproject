<!DOCTYPE html>
<html>

  <head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="style.css">
  </head>


  <body>
    <div class="header">
      <div id="amazon-logo">
        <img src="amazon-logo.jpg" style="height:60px">
      </div>
      <div id="user">
        <div class="dropdown" id="name-menu">
          <button class="btn btn-default dropdown-toggle" type="button" data-toggle="dropdown">AdminName
          <span class="caret"></span></button>
          <ul class="dropdown-menu" role="menu" aria-labelledby="menu1">
            <li role="presentation"><a role="menuitem" tabindex="-1" href="userRegistration.html">Your Account</a></li>
            <li role="presentation"><a role="menuitem" tabindex="-1" href="userRegistration.html">Log Out</a></li>
          </ul>
        </div>
      </div>
    </div>
    <div class="page-piece" id="error-piece"></div>

    <?php

      // CONNECTING TO THE DATABASE
      try{
        $db = new PDO("mysql:host=localhost;dbname=KINDLE","root","a1234");
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      }
      catch (PDOException $e) {
        printf("Unable to open database: %s\n", $e->getMessage());
      }

      // TABLES THAT CAN BE VIEWED
      $tables = array ( "Department", "Employee", "Users", "Kindle" );

      // DISCERNING THE POST REQUEST
      if( $_POST ){

        // GETTING COLUMNS OF THE TABLE TO EDIT
        $table = $_POST['table'];
        $uniqs = array ();
        $autos = array ();
        $cols = array ();
        $pri = NULL;
        $result = $db->prepare("show columns from ". $table);
        $result->execute();

        // GETTING THE UNIQUE COLUMNS OF THE TABLE
        while ($prop = $result->fetch(PDO::FETCH_ASSOC)){
          if( ($prop["Key"] == "PRI") ){
            $pri = $prop["Field"];
            array_push($uniqs, $prop["Field"]);
          }
          elseif( ($prop["Key"] == "UNI") ){
            array_push($uniqs, $prop["Field"]);
          };
          if( $prop["Extra"] == "auto_increment" || $prop["Extra"] == "on update CURRENT" ){
            array_push($autos, $prop["Field"]);
          };
          array_push($cols, $prop["Field"]);
        }

        // GETTING THE PARENT TABLES
        $result = $db->prepare("select referenced_table_name, referenced_column_name, column_name 
          from information_schema.key_column_usage where constraint_name  = 
            ( select constraint_name from information_schema.referential_constraints 
              where delete_rule = 'CASCADE' and table_name = '".$table."') ");
        $result->execute();        
        $moms = $result->fetchAll(PDO::FETCH_ASSOC);
        $cols_ = array ();
        foreach ($moms as $mom){
          $result = $db->prepare("show columns from ". $mom['referenced_table_name']);
          $result->execute();
          $cols_[$mom['referenced_table_name']] = $result->fetchAll(PDO::FETCH_COLUMN);
        };
        $nomom = true;

        // GETTING THE UNIQUE COLUMNS OF THE PARENTS TABLES

        $uniqs_ = array ();
        $autos_ = array ();
        $cols_ = array ();
        $pri_ = array ();
        foreach ($moms as $mom){
          $uniqs_[$mom['referenced_table_name']] = array ();
          $autos_[$mom['referenced_table_name']] = array ();
          $cols_[$mom['referenced_table_name']] = array ();
          $result = $db->prepare("show columns from ". $mom['referenced_table_name']);
          $result->execute();
          // GETTING THE UNIQUE COLUMNS OF THE TABLE
          while ($prop = $result->fetch(PDO::FETCH_ASSOC)){
            if( ($prop["Key"] == "PRI") ){
              $pri_[$mom['referenced_table_name']] = $prop["Field"];
              array_push($uniqs_[$mom['referenced_table_name']], $prop["Field"]);
            }
            elseif ( ($prop["Key"] == "UNI") ){
              array_push($uniqs_[$mom['referenced_table_name']], $prop["Field"]);
            };
            if( $prop["Extra"] == "auto_increment" || $prop["Extra"] == "on update CURRENT" ){
              array_push($autos_[$mom['referenced_table_name']], $prop["Field"]);
            };
            array_push($cols_[$mom['referenced_table_name']], $prop["Field"]);
          }
        }

        $error = "Failed to " . $_POST['edit'] . " in the table " . $_POST['table'];
        $success = true;

        //  DELETING A ROW
        if( $_POST['edit'] == "Delete" ){
          foreach ($moms as $mom){
            $nomom = false;
            $var = $_POST[$mom['column_name']];
            $stmt = $db->prepare("select data_type from information_schema.columns 
              where table_name='".$mom['referenced_table_name']."' and column_name='".$mom['referenced_column_name']."'");
            $stmt->execute();
            $type = $stmt->fetch(PDO::FETCH_ASSOC);
            $type = $type['data_type'];
            if ($type = "varchar"){
              $var = "'".$var."'";
            };
            $stmt = $db->prepare("delete from ".$mom['referenced_table_name'].
                                  " where ".$mom['referenced_column_name']." = ".$var);
            $stmt->execute();
          };
          if($nomom){
            $stmt = $db->prepare( "delete from ". $table ." where ". $uniqs[0] ." = '".addslashes($_POST[$uniqs[0]]) ."'");
            $stmt->execute();
          }
        }

        // CREATING A ROW
        elseif( $_POST['edit'] == "Create" ){
          $success = true;
          foreach ($moms as $mom){
            foreach ($uniqs_[$mom['referenced_table_name']] as $uniq_){
              $query = $db->prepare("select ". $uniq_ ." from ". $mom['referenced_table_name']);
              $query->execute();
              while ($row = $query->fetch(PDO::FETCH_ASSOC)){
                if(isset($_POST[$uniq_])){
                  if( $row[$uniq_] == $_POST[$uniq_]){
                    $success = false;
                    break;
                  }
                }
              }
              if(!$success)
                break;
            }
            if(!$success)
              break;
          }
          foreach ($uniqs as $uniq){
            $query = $db->prepare("select ". $uniq ." from ". $table);
            $query->execute();
            while ($row = $query->fetch(PDO::FETCH_ASSOC)){
              if( $row[$uniq] == $_POST[$uniq]){
                $success = false;
                break;
              }
            }
            if(!$success)
              break;
          };
          if($success){
            foreach ($moms as $mom){
              $values = "(";
              foreach ($cols_[$mom['referenced_table_name']] as $col_){
                if( (!isset($_POST[$col_]) || $_POST[$col_] == "") || (in_array($col_, $autos_[$mom['referenced_table_name']]) ) ){
                  $values = $values . ", NULL";
                }
                else{
                  $values = $values . ", '" . $_POST[$col_] . "'";
                };
              };
              $values = str_replace("(,", "( ",$values) . ")";
              $stmt = $db->prepare("insert into " .$mom['referenced_table_name']. " values " . $values);
              $stmt->execute();
              $uniq_ = false;
              $i = 0;
              while ( !isset($_POST[$uniq_] ) ){
                $uniq_ = $uniqs_[$mom["referenced_table_name"]][$i];
                $i = $i + 1;
              }
              $_POST[$uniq_] = addslashes($_POST[$uniq_]);
              echo "<script> alert('". $_POST[$uniq_] ."'); </script>";
              $query = $db->prepare("select ". $mom["referenced_column_name"] ." from ".$mom["referenced_table_name"] . 
                                      " where ". $uniq_ . " = '" . addslashes($_POST[$uniq_]) ."'");
              $query->execute();
              $momid = $query->fetchAll(PDO::FETCH_ASSOC);
              $_POST[$mom["column_name"]] = $momid[0][$mom["referenced_column_name"]];

            }
            $values = "(";  
            foreach ($cols as $col){
              if( $_POST[$col] == "" || (isset($autos[0]) && $autos[0] == $col) ){
                $values = $values . ", NULL";
              }
              else{
                $values = $values . ", '" . $_POST[$col] . "'";
              };
            };
            $values = str_replace("(,", "( ", $values );
            $values .= " )";
            $stmt = $db->prepare("insert into " .$table. " values " . $values);
            $stmt->execute();
          }
          if(!$success){
            echo "<script> alert('FAILLLLLL'); </script>";
          };
        }

        // UPDATING A ROW
        elseif( $_POST['edit'] == "Update" ){
          $success = true;
          foreach ($moms as $mom){
            foreach ($uniqs_[$mom['referenced_table_name']] as $uniq_){
              $query = $db->prepare("select ". $uniq_ ." from ". $mom['referenced_table_name'] .
                                      " where ".$mom["referenced_column_name"]." != '". $_POST[$mom["column_name"]] ."'");
              $query->execute();
              while ($row = $query->fetch(PDO::FETCH_ASSOC)){
                if(isset($_POST[$uniq_])){
                  if( $row[$uniq_] == $_POST[$uniq_] ){
                    $success = false;
                    break;
                  }
                }
              }
              if(!$success)
                break;
            }
            if(!$success)
              break;
          }
          foreach ($uniqs as $uniq){
            if($pri)
              $uniq = $pri;
            else
              $uniq = $autos[0];
            $query = $db->prepare("select ". $uniq ." from ". $table . " where ". $uniq ." != '". $_POST[$uniq] ."'");
            $query->execute();
            while ($row = $query->fetch(PDO::FETCH_ASSOC)){
              if( $row[$uniq] == $_POST[$uniq]){
                $success = false;
                break;
              }
            }
            if(!$success){
              echo "<script> alert('FAILED AT KID'); </script>";
              break;}
          };
          if($success){
            foreach ($moms as $mom){
              $values = "(";
              foreach ($cols_[$mom['referenced_table_name']] as $col_){
                if( isset($_POST[$col_]) && $_POST[$col_] == "" ){
                  $values = $values . ", " . $col_ ." =  NULL";
                }
                elseif( isset($_POST[$col_]) ){
                  $values = $values . ", ". $col_ . " = '" . $_POST[$col_] . "'";
                };
              };
              $values = str_replace("(,", " ", $values);
              $values = str_replace(")", " ", $values);
              $stmt = $db->prepare("update " .$mom['referenced_table_name']. " set " . $values . " where " .
                                     $mom["referenced_column_name"] . " = '". $_POST[$mom["column_name"]] ."'");
              $stmt->execute();
            }
            $values = "(";
            foreach ($cols as $col){
              if( $_POST[$col] == "" ){
                $values = $values . ", ". $col ." = NULL ";
              }
              elseif (isset($_POST[$col])){
                $values = $values . ", ". $col ." = '". $_POST[$col] . "'";
              };
            };
            $values = str_replace("(,", " ", $values );
            $values = str_replace(")", " ", $values );
            $uniq_ = false;
            if($pri_){
              $uniq_ = $pri;
            }
            else{
              $uniq_ = $autos[0];
            };
            $stmt = $db->prepare("update " .$table. " set " . $values . " where ". $uniq_ . " = '". $_POST[$uniq_] ."'");
            $stmt->execute();
          }
          if(!$success){
            echo "<script> alert('FAILLLLLL'); </script>";
          };
        };

      };



      // DISPLAYING THE TABLE

      $t = 0;
      echo '<div class="admin-nav">';
      foreach ($tables as $table){
        $t = $t + 1;
        echo '<div class="admin-nav-tab" id="tab'.(string)$t.'" onclick="select_tab('.(string)$t.')">'.$table.'</div>';
      };
      echo '</div>';

      $t = 0;
      echo '<div class="adminContainer">';
      foreach ($tables as $table){
        $t = $t + 1;
        echo '<div class="tabler" id="tabler'.(string)$t.'">';
        echo '  <div class="table" id="table'.(string)$t.'">';
        echo '    <table>';

        $result = $db->prepare("show columns from ". $table);
        $result->execute();
        $cols = $result->fetchAll(PDO::FETCH_COLUMN);          
        if (!$cols) {  echo 'Could not display table: ' . mysql_error();    exit;        };

        $result = $db->prepare("select referenced_table_name, referenced_column_name, column_name 
          from information_schema.key_column_usage where constraint_name  = 
            ( select constraint_name from information_schema.referential_constraints 
              where delete_rule = 'CASCADE' and table_name = '".$table."') ");
        $result->execute();        
        $moms = $result->fetchAll(PDO::FETCH_ASSOC);

        $cols_ = array ();
        foreach ($moms as $mom){
          $result = $db->prepare("show columns from ". $mom['referenced_table_name']);
          $result->execute();
          $cols_[$mom['referenced_table_name']] = $result->fetchAll(PDO::FETCH_COLUMN);
        };

        $colno = 0;
        echo "      <tr id='1headrow'>";
        foreach ($cols as $col){
          echo "       <th>" . $col . "</th>";
          $colno = $colno + 1;
        };
        foreach ($moms as $mom){
          foreach ($cols_[$mom['referenced_table_name']] as $col_){
            
            if ($col_ != $mom['referenced_column_name']){
              echo " <th>" . $col_. "</th>";
              array_push($cols, $col_);
            };
          };
        };
        echo "      </tr>";
        
        $query = "select * from ".$table;
        $where = " where ";
        $nowhere = true;
        foreach ($moms as $mom){
          $query = $query.", ".$mom['referenced_table_name'];
          $where = $where." and ";
          $nowhere = false;
          $where .= $mom['referenced_table_name'].".".$mom['referenced_column_name']." = ".$table.".".$mom['column_name'];
        }
        $where = str_replace("where  and", "where", $where);
        if($nowhere)
          $where = "";
        $stmt = $db->prepare($query .$where);
        $stmt->execute();
        $c = 0;
        while( $row_ = $stmt->fetch(PDO::FETCH_ASSOC)){
          $c = $c + 1;
          echo "    <tr class='datarow' id='".(string)$t."row".(string)$c."' onclick='select_row(".(string)$c.")'>";
          foreach ($cols as $col_){
            echo "    <td>".$row_[$col_]."</td>";
          };
          echo "    </tr>";
        };
        echo "    </table>";
        echo '  </div>';

        $edits = array ("Create", "Update", "Delete");
        echo '  <div class="row-edit">';
        foreach ($edits as $edit){
          $display = ($edit=="Create")?"block":"none";
          $visible = ($edit=="Delete")?"none":"block";
          echo '  <div id="'.$edit.'row'.(string)$t.'" style="display:'.$display.'"">
                    <form action="adminPage.php" method="POST">
                      <table>
                        <tr  style="display:'.$visible.'">';
            foreach ($cols as $col_) {
                  echo '  <td><input name="'.$col_.'" type="text"></td>';
            };
          echo '        </tr>
                        <input name="table" type="text" value="'.$table.'" style="display:none;">
                        <input name="edit" type="text" value="'.$edit.'" style="display:none;">
                        <input type="submit" value="'.$edit.'">
                      </table>  
                    </form>   
                  </div>';
        };
        echo '  </div>';
        echo '</div>';
      };
      echo '</div>';
      

    ?>
      
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
    <script>

      var tab = NaN;
      function select_tab(id){
        if(tab){
          document.getElementById("tab"+tab).style.border = "";
          document.getElementById("tabler"+tab).style.display = "none";
        }
        document.getElementById("tab"+id).style.border = "2px dotted rgba(1,2,3,0.5)";
        document.getElementById("tabler"+id).style.display = "block";
        tab = id;
      };
      select_tab(1);

      var row = NaN;
      function select_row(r){
        if( row ){
          var selected_row = document.getElementById(tab + "row" + row);
          selected_row.style.backgroundColor = "white";
          selected_row.addEventListener("mouseenter", function(){
            if( tab + 'row' + row != this.id ){
              this.style.backgroundColor = "#FF9900";
            }
          });
          selected_row.addEventListener("mouseleave", function(){
            if( tab + 'row' + row != this.id ){
              this.style.backgroundColor = "#FFF";
            }
          });
          if(row == r){
            row = NaN;
            document.getElementById("Deleterow"+tab).style.display = "none";
            document.getElementById("Updaterow"+tab).style.display = "none";
            document.getElementById("Createrow"+tab).style.display = "block";
            return;
          };
        };
        document.getElementById(tab + "row" + r).style.backgroundColor = "#E47911";
        var D = document.getElementById("Deleterow"+tab); D.style.display = "block";
        var U = document.getElementById("Updaterow"+tab); U.style.display = "block";
        document.getElementById("Createrow"+tab).style.display = "none";
        row = r;
        var thisrow = document.getElementById(tab + "row" + r);
        var kids = thisrow.children;
        var Dkids = D.children[0].children[3].children[0].children[0].children;
        var Ukids = U.children[0].children[3].children[0].children[0].children;
        for(var i = 0; i < kids.length; i++){
          Dkids[i].children[0].value = kids[i].innerHTML;
          Ukids[i].children[0].value = kids[i].innerHTML;
        }
        
      };

    </script>
  </body>

</html>