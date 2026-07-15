<?php
session_start();
error_reporting(0);
include('includes/config.php');

if(strlen($_SESSION['alogin'])==0) {	
    header('location:index.php');
} else {
    if(isset($_POST['submited'])) {
        $h_pname = $_POST['h_packagename'];
        $h_foodtype = $_POST['h_Foodtype'];    // Separate variable for Food Type
        $h_rating = $_POST['h_Rating'];
        $h_ptype = $_POST['h_packagetype'];    // Separate variable for Package Type
        $h_plocation = $_POST['h_packagelocation'];
        // $h_pprice = $_POST['h_packageprice'];
        $h_pfeatures = $_POST['h_packagefeatures'];
        $h_pdetails = $_POST['h_packagedetails'];
        $h_pimage = $_FILES["h_packageimage"]["name"];

        // Move uploaded file to the correct directory
        // move_uploaded_file($_FILES["h_packageimage"]["tmp_name"], "IMAGE/" . $h_pimage);
		move_uploaded_file($_FILES["h_packageimage"]["tmp_name"],"pacakgeimages/".$_FILES["h_packageimage"]["name"]);


        // Prepare SQL statement
        $sql = "INSERT INTO restaurant (Name, FOODTYPE, RATINGS, PHONE, ADDRESS,  Restaurant_Features, Restaurant_Details, image)
                VALUES (:h_pname, :h_foodtype, :h_rating, :h_ptype, :h_plocation,  :h_pfeatures, :h_pdetails, :h_pimage)";
        
        $query = $dbh->prepare($sql);

        // Bind parameters to the query
        $query->bindParam(':h_pname', $h_pname, PDO::PARAM_STR);
        $query->bindParam(':h_foodtype', $h_foodtype, PDO::PARAM_STR);
        $query->bindParam(':h_rating', $h_rating, PDO::PARAM_STR);
        $query->bindParam(':h_ptype', $h_ptype, PDO::PARAM_STR);
        $query->bindParam(':h_plocation', $h_plocation, PDO::PARAM_STR);
        // $query->bindParam(':h_pprice', $h_pprice, PDO::PARAM_STR);
        $query->bindParam(':h_pfeatures', $h_pfeatures, PDO::PARAM_STR);
        $query->bindParam(':h_pdetails', $h_pdetails, PDO::PARAM_STR);
        $query->bindParam(':h_pimage', $h_pimage, PDO::PARAM_STR);

        // Execute the query
        $query->execute();
        $lastInsertId = $dbh->lastInsertId();

        if($lastInsertId) {
            $msg = "Package Created Successfully";
        } else {
            $error = "Something went wrong. Please try again";
        }
    }

?>

<!DOCTYPE HTML>
<html>
<head>
<title>TMS | Admin Package Creation</title>

<script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); } </script>
<link href="css/bootstrap.min.css" rel='stylesheet' type='text/css' />
<link href="css/style.css" rel='stylesheet' type='text/css' />
<link rel="stylesheet" href="css/morris.css" type="text/css"/>
<link href="css/font-awesome.css" rel="stylesheet"> 
<script src="js/jquery-2.1.4.min.js"></script>
<link href='//fonts.googleapis.com/css?family=Roboto:700,500,300,100italic,100,400' rel='stylesheet' type='text/css'/>
<link href='//fonts.googleapis.com/css?family=Montserrat:400,700' rel='stylesheet' type='text/css'>
<link rel="stylesheet" href="css/icon-font.min.css" type='text/css' />
  <style>
		.errorWrap {
    padding: 10px;
    margin: 0 0 20px 0;
    background: #fff;
    border-left: 4px solid #dd3d36;
    -webkit-box-shadow: 0 1px 1px 0 rgba(0,0,0,.1);
    box-shadow: 0 1px 1px 0 rgba(0,0,0,.1);
}
.succWrap{
    padding: 10px;
    margin: 0 0 20px 0;
    background: #fff;
    border-left: 4px solid #5cb85c;
    -webkit-box-shadow: 0 1px 1px 0 rgba(0,0,0,.1);
    box-shadow: 0 1px 1px 0 rgba(0,0,0,.1);
}
		</style>

</head> 
<body>
   <div class="page-container">
   <!--/content-inner-->
<div class="left-content">
	   <div class="mother-grid-inner">
              <!--header start here-->
<?php include('includes/header.php');?>
							
				     <div class="clearfix"> </div>	
				</div>
<!--heder end here-->
	<ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.php">Home</a><i class="fa fa-angle-right"></i>Create Restaurant Package </li>
            </ol>
		<!--grid-->
 	<div class="grid-form">
 
  <div class="grid-form1">
  	       <h3>Create Restaurant Package</h3>
  	        	  <?php if($error){?><div class="errorWrap"><strong>ERROR</strong>:<?php echo htmlentities($error); ?> </div><?php } 
				else if($msg){?><div class="succWrap"><strong>SUCCESS</strong>:<?php echo htmlentities($msg); ?> </div><?php }?>
  	         <div class="tab-content">
						<div class="tab-pane active" id="horizontal-form">
							<form class="form-horizontal" name="h_package" method="post" enctype="multipart/form-data">
<div class="form-group">
									<label for="focusedinput" class="col-sm-2 control-label">Restaurant  Name</label>
									<div class="col-sm-8">
										<input type="text" class="form-control1" name="h_packagename" id="h_packagename" placeholder="Enter the Restaurant  Name" required>
									</div>
								</div>
<div class="form-group">
									<label for="focusedinput" class="col-sm-2 control-label">Food Type</label>
									<div class="col-sm-8">
										<input type="text" class="form-control1" name="h_Foodtype" id="h_Foodtype" placeholder="Enter Food Type" required>
									</div>
								</div>
<div class="form-group">
									<label for="focusedinput" class="col-sm-2 control-label">Restaurant Rating</label>
									<div class="col-sm-8">
										<input type="text" class="form-control1" name="h_Rating" id="h_Rating" placeholder=" Restaurant  Rating" required>
									</div>
								</div>

<div class="form-group">
									<label for="focusedinput" class="col-sm-2 control-label">Restaurant Phone Number</label>
									<div class="col-sm-8">
										<input type="text" class="form-control1" name="h_packagetype" id="h_packagetype" placeholder="Lan Line Number" required>
									</div>
								</div>

<div class="form-group">
									<label for="focusedinput" class="col-sm-2 control-label">Restaurant  Location</label>
									<div class="col-sm-8">
										<input type="text" class="form-control1" name="h_packagelocation" id="h_packagelocation" placeholder=" Restaurant  Location" required>
									</div>
								</div>

<!-- <div class="form-group">
									<label for="focusedinput" class="col-sm-2 control-label">Restaurant  Price in PKR</label>
									<div class="col-sm-8">
										<input type="text" class="form-control1" name="h_packageprice" id="h_packageprice" placeholder=" Restaurant Price is PKR" required>
									</div>
								</div> -->

<div class="form-group">
									<label for="focusedinput" class="col-sm-2 control-label">Restaurant  Features</label>
									<div class="col-sm-8">
										<input type="text" class="form-control1" name="h_packagefeatures" id="h_packagefeatures" placeholder="Restaurant  Features Eg-free Pickup-drop facility" required>
									</div>
								</div>		


<div class="form-group">
									<label for="focusedinput" class="col-sm-2 control-label">Restaurant  Details</label>
									<div class="col-sm-8">
										<textarea class="form-control" rows="5" cols="50" name="h_packagedetails" id="h_packagedetails" placeholder="Restaurant  Details" required></textarea> 
									</div>
								</div>															
<div class="form-group">
									<label for="focusedinput" class="col-sm-2 control-label">Restaurant  Image</label>
									<div class="col-sm-8">
										<input type="file" name="h_packageimage" id="h_packageimage" required>
									</div>
								</div>	

								<div class="row">
			<div class="col-sm-8 col-sm-offset-2">
				<button type="submit" name="submited" class="btn-primary btn">Create</button>

				<button type="reset" class="btn-inverse btn">Reset</button>
			</div>
		</div>
						
					
						
						
						
					</div>
					
					</form>

     
      

      
      <div class="panel-footer">
		
	 </div>
    </form>
  </div>
 	</div>
 	<!--//grid-->

<!-- script-for sticky-nav -->
		<script>
		$(document).ready(function() {
			 var navoffeset=$(".header-main").offset().top;
			 $(window).scroll(function(){
				var scrollpos=$(window).scrollTop(); 
				if(scrollpos >=navoffeset){
					$(".header-main").addClass("fixed");
				}else{
					$(".header-main").removeClass("fixed");
				}
			 });
			 
		});
		</script>
		<!-- /script-for sticky-nav -->
<!--inner block start here-->
<div class="inner-block">

</div>
<!--inner block end here-->
<!--copy rights start here-->
<?php include('includes/footer.php');?>
<!--COPY rights end here-->
</div>
</div>
  <!--//content-inner-->
		<!--/sidebar-menu-->
					<?php include('includes/sidebarmenu.php');?>
							  <div class="clearfix"></div>		
							</div>
							<script>
							var toggle = true;
										
							$(".sidebar-icon").click(function() {                
							  if (toggle)
							  {
								$(".page-container").addClass("sidebar-collapsed").removeClass("sidebar-collapsed-back");
								$("#menu span").css({"position":"absolute"});
							  }
							  else
							  {
								$(".page-container").removeClass("sidebar-collapsed").addClass("sidebar-collapsed-back");
								setTimeout(function() {
								  $("#menu span").css({"position":"relative"});
								}, 400);
							  }
											
											toggle = !toggle;
										});
							</script>
<!--js -->
<script src="js/jquery.nicescroll.js"></script>
<script src="js/scripts.js"></script>
<!-- Bootstrap Core JavaScript -->
   <script src="js/bootstrap.min.js"></script>
   <!-- /Bootstrap Core JavaScript -->	   

</body>
</html>
<?php } ?>