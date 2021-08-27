
	<?php 
    //echo $getUserDetails['fullname'];die;    
    //echo "<pre>";print_r($getUserDetails);die;?>
    
    <html>
        <head>
            <link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
            <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
            <script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
            <!------ Include the above in your HEAD tag ---------->
        </head>
        <body>
        <div align="center">
             <div style="max-width: 680px; min-width: 500px; border: 2px solid #e3e3e3; border-radius:5px; margin-top: 20px">   
        	    <div>
        	         <h3 class="text-center">Ras E-Tender</h3>
        	    </div> 
        	    <div  style="background-color: #fbfcfd; border-top: thick double #cccccc; text-align: left;">
        	        <div style="margin: 30px;">
             	        <p>
                 	        Dear Candidate,<br> <br>
                 	        Welcome to Creative Ras E-Tender!<br> <br>
                 	        We have created an account for you. Here are your details:<br><br>
             	        </p>
             	        <table style="text-align: left;">
             	            <tr>
             	                <th>Name</th>
             	                <td><?php echo $getUserDetails['fullname']?></td>
             	            </tr>
             	            <tr>
             	                <th>Email</th>
             	                <td>: <?php echo $getUserDetails['email']?></td>
             	            </tr>
             	            <tr>
             	                <th>Organization</th>
             	                <td>: <?php echo $getUserDetails['company_name']?></td>
             	            </tr>
             	            <tr>
             	                <th>Mobile No</th>
             	                <td>: <?php echo $getUserDetails['phone']?></td>
             	            </tr>
             	            <tr>
             	                <th>Pan No</th>
             	                <td>: <?php echo $getUserDetails['pan_no']?></td>
             	            </tr>
                             <tr>
             	                <th>GST No</th>
             	                <td>: <?php echo $getUserDetails['gst_no']?></td>
             	            </tr>
             	        </table>
             	        <br>  <br>
                         You have been successfully registered!. Please wait for the admin approval.
             	       
             	            <br><br>
                        
             	        <div style="text-align: Right;">
             	            With warm regards,<br>
                            Ras E-Tender Team 
             	        </div>
             	    </div>
        	    </div>   
        	</div>   
    	</div>
  	    <center style="display:none;">2017 ©. ALL Rights Reserved.</center>
    	</body>
	</html>	