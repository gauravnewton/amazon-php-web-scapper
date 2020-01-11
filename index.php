
<!DOCTYPE html>
<html>
  <head>
    <title>Amazon web scraping using PHP</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.bundle.min.js" integrity="sha384-6khuMg9gaYr5AxOqhkVIODVIvm9ynTT5J4V1cfthmT+emCG6yVmEZsRHdxlotUnm" crossorigin="anonymous"></script>
    <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
  </head>
  <body>
    <div class="container">
      <h2>Amazon PHP Scrapper</h2>
      <div class="row">

        <div class="col-sm-12">
          <div class="card">
            <div class="card-header">
              Amazon Prodect ASIN & Zone Selcetion
            </div>
            <div class="card-body">
              <form method="get" class="">
            		ASIN:
                <div class="form-group">
                  <input name="asin" class="form-control" type="text" placeholder="Visit Amazon for ASIN" required />
                </div>

                <div class="form-group">
              		<select name="zone" class="form-control" required>
              			<option value="">Select Zone</option>
              			<option value="india">INDIA</option>
              			<option value="usa">USA</option>
              		</select>
                </div>

                <div class="form-group">
                  <button type="submit" class="btn btn-primary pull-right">Scrap</button>
                </div>

            	</form>
              <blockquote class="blockquote mb-0">
                <footer class="blockquote-footer">Made with <span class="fa fa-heart"></span> by <a href="https://github.com/gauravnewton" target="_blank"> Gaurav </a></footer>
              </blockquote>
            </div>

            <div class="card-footer">
              <?php
            		error_reporting(0);
            		$asin = filter_input(INPUT_GET,'asin');
            		$zone = filter_input(INPUT_GET,'zone');
            		if(!empty($asin) && !empty($zone)){
            			echo "<br>";
            			if( $zone == "india"){
            				$baseURL = "https://www.amazon.".in."/gp/product/";
            			}else{
            				$baseURL = "https://www.amazon.".com."/gp/product/";
            			}
            			try{
            				$html = file_get_contents($baseURL.$asin);
            				if( $zone == "india"){
            					$isMatched = preg_match('|"priceblock_ourprice".*\₹(.*)<|',$html,$match);
            				}else{
            					$isMatched = preg_match('|"priceblock_ourprice".*\$(.*)<|',$html,$match);
            				}

            				$price = 0;
            				if($isMatched && isset($match)){
            					$price = $match[1];
            					if( $zone == "india"){
            						echo "<center>Response from Amazon.in <b>₹ ".$price."</b></center>";
            					}else{
            						echo "<center>Response from Amazon.com <b>$ ".$price."</b></center>";
            					}

            				}else{
            					echo "<center>Invalid ASIN! please make sure ASIN is available on amazon on same store.<center>";
            				}
            			}catch(Exception $e){
            				echo "Some thing bad happens";
            			}
            		}
            	?>
            </div>
          </div>
        </div>
      </div>
    </div>
  </body>
</html>
