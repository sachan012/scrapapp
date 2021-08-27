<link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
<script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
<!------ Include the above in your HEAD tag ---------->

<?php //echo $fullname;?>
<?php //echo die;?>

	<html>
        <body>
        <div align="center">
             <div style="max-width: 680px; min-width: 500px; border: 2px solid #e3e3e3; border-radius:5px; margin-top: 20px">
        	    <div  style="background-color: #fbfcfd; text-align: left;">
        	        <div style="margin: 30px;">
             	        <p>
                 	        Dear <?php echo $fullname;?>,<br> <br>
                 	        You have won the Auction no. <?php echo $auction_id;?>,Dated:&nbsp;<strong><?php echo date("F j, Y",strtotime($auction_start_date));?></strong><br> <br>
                 	        for material code:<strong><?php echo $material_code;?></strong>,Material Type: <strong><?php echo $material_type;?></strong><br> <br>
                 	        for the period from <strong><?php echo date("F j, Y",strtotime($auction_validity_start_date));?> to <?php echo date("F j, Y",strtotime($auction_validity_end_date));?></strong><br><br>
                 	        We have created an account for you. Here are your details:<br><br>
                 	        1) Payment terms: 100% advance.<br><br>
                 	        2) Security deposit of Rs.10.00Lack to be deposited before start picking scrap from the company.<br><br>
                 	        3) Security deposit will be forfeited incase of failure to pickup the scrap after winning the bid.<br><br>
                 	        4) The bid is valid only for the period mentioned above.<br><br>
                            5) Winning bidder shall be responsible to pay all charges along with applicable taxes (GST /TCS/TDS) in regards to  loading/transportation of said Scrap.<br><br>
                            6) Scrap loading time will be up to 16:30 PM and vehicle departure time up to 17:30 pm, Buyer must ensure that all financial transactions should be completed before that. Loaded vehicle shall not be allowed to park at the company after invoicing.<br><br>
                            7) Sale of Scrap on weekends will be at Company's management discretion.<br><br>
                            8) The company shall not be responsible for anything once the invoicing is done and vehicle leaves the company premises.<br><br>
                            9) Company has all rights to cancel the bid in case the winning bidder is fail to pickup the scrap from company after an intimation of 48 Hrs.<br><br>
                            10) The bidder shall be debarred from further bidding in future, In case of failure to pick the scrap in any month after winning the bid.<br><br>
             	        </p>
                        
             	        <div style="text-align: Right;">
             	            With warm regards,<br>                            
             	        </div>
             	    </div>
        	    </div>   
        	</div>   
    	</div>
    	</body>
	</html>	