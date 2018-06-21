<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
  	<link href="../assets/css/bootstrap.min.css" rel="stylesheet">
	<link href="../assets/css/style.css" rel="stylesheet">
	<title></title>
	<script type="text/javascript">
  </script>
</head>
<body>
	<header>
		<nav class="navbar navbar-expand-lg navbar-light bg-light">
			<a><span class="navbar-brand mb-0 h1">忠順</span></a>
			<div class="collapse navbar-collapse" id="navbarSupportedContent">
				<ul class="navbar-nav mr-auto">
					<li class="nav-item active">
					<a class="nav-link" href="#">目標總覽</a>
					</li>
					<li class="nav-item dropdown">
					<a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
						任務
					</a>
					<div class="dropdown-menu" aria-labelledby="navbarDropdown">
						<a class="dropdown-item" href="#">掃描</a>
						<div class="dropdown-divider"></div>
						<a class="dropdown-item" href="#">攻擊</a>
					</div>
					</li>
					<li class="nav-item">
					<a class="nav-link" href="#">漏洞項目</a>
					</li>
				</ul>
				<a>登出</a>
			</div>
		</nav>
	</header>
	<div class="row">
		<div class="col-4">
			<form class="form-inline" name="test" action="" method="Post">
			  <input class="form-control mr-sm-1 mb-sm-1" type="search" placeholder="Search" aria-label="Search" name="s_ob" style="width:80%">
				<button class="btn btn-outline-success my-2 my-sm-0 mb-sm-1" type="submit">搜尋</button>
			</form>
			<div class="list-group" id="list-tab" role="tablist" style="height:820px;overflow:auto;">
<!-- php code
			$value="";
			if(isset($_POST["s_ob"])){ 
				$value = $_POST["s_ob"]; 					
			}

			//$filter = ['ip' => ['$in' => [new MongoDB\BSON\Regex($value,'i')]]];
			//var_dump($filter);
			//主機資訊
			$filter = array(
				'$or' => array(
					array('ip' => ['$in'=>[new MongoDB\BSON\Regex($value,'i')]]),
					array('product' => ['$in'=>[new MongoDB\BSON\Regex($value,'i')]]),
					array('extrainfo' => ['$in'=>[new MongoDB\BSON\Regex($value,'i')]]),
					array('port' => ['$in'=>[new MongoDB\BSON\Regex($value,'i')]]),
					array('name' => ['$in'=>[new MongoDB\BSON\Regex($value,'i')]]),
					array('version' => ['$in'=>[new MongoDB\BSON\Regex($value,'i')]])
				)					
			);
			$options = array(
					/* Only return the following fields in the matching documents */
					"projection" => array(
						"ip" => 1,
						"product" => 1,
						"extrainfo" => 1,
						"port" => 1,
						"name" => 1,
						"version" => 1,
				),
					"sort" => array(
							"views" => -1,
					),
			);
			$query = new MongoDB\Driver\Query($filter, $options);
			// 連接到 MongoDB
			$manager = new MongoDB\Driver\Manager("mongodb://root:example@localhost:27017");
			$readPreference = new MongoDB\Driver\ReadPreference(MongoDB\Driver\ReadPreference::RP_PRIMARY);
			$cursor = $manager->executeQuery("toybox.ip_list", $query, $readPreference);
			//漏洞資訊
			$filter2 = array();
			$options2 = array(
				"projection" => array(
					"_id" => 1,
					"vuln" => 1
				),
				"sort" => array(
						"views" => -1,
				),
			);
			$query2 = new MongoDB\Driver\Query($filter2, $options2 );
			$manager = new MongoDB\Driver\Manager("mongodb://root:example@localhost:27017");
			$readPreference = new MongoDB\Driver\ReadPreference(MongoDB\Driver\ReadPreference::RP_PRIMARY);
			$cursor_vuln = $manager->executeQuery("toybox.nse_list", $query2, $readPreference);
			$cursor1 = $cursor_vuln -> toArray(); //轉陣列
			$cursor2 = json_encode($cursor1); //stdClass -> Array 轉換類型
			$cursor3 = json_decode($cursor2, true);//true 表示把陣列對象全部decode
			//var_dump($cursor3);
			$ip_temp = array();
			$ip_num = 1;
			foreach($cursor as $index => $doc) {
				$ip = $doc -> ip;
				if ($index == '0') {
					array_push($ip_temp, $ip);
					printf("<a class='list-group-item list-group-item-action' id='list-%s' data-toggle='list' href='#list-%s-list' role='tab' aria-controls='list-%s-list'>%s</a>",$ip_num,$ip_num,$ip_num,$ip);					
					$ip_num++;
				}
				$same_count = 0 ;
				foreach($ip_temp as $value){
					if (preg_match("/$value/i", "$ip")) {
						$same_count++;
					} 
				}
				if ($same_count == 0) {
					array_push($ip_temp, $ip);
					printf("<a class='list-group-item list-group-item-action' id='list-%s' data-toggle='list' href='#list-%s-list' role='tab' aria-controls='list-%s-list'>%s</a>",$ip_num,$ip_num,$ip_num,$ip);
					$ip_num++;
				}
			}
			//print_r($ip_temp);
-->		
			</div>
		</div>
	  <div class="col-8">
			<div class="tab-content" id="nav-tabContent" style="height:820px;overflow:auto;">
<!-- php code			
					$content_temp = array();
					$ip_temp_num = 0;
					$ip_num = 1;

					$vuln_name = array("ms17-010","ms08-067","ms12-020");

					foreach($ip_temp as $ip_value) {
						printf("<div class='tab-pane fade' id='list-%s-list' role='tabpanel' aria-labelledby='list-%s-list'>",$ip_num,$ip_num);
						printf("<h1 class='mt-sm-2'>主機 IP : %s</h1>",$ip_value);
						printf("<hr class='style-one' />");
						printf("<table class='table table-bordered'><thead class='thead-light'><tr>");
						printf("<th scope='col'>port</th><th scope='col'>協定</th>");
						printf("<th scope='col'>服務</th><th scope='col'>詳細資訊</th>");
						printf("</tr><tbody>");
						//printf("<a class='content_test'></a>");
						$cursor = $manager->executeQuery("toybox.ip_list", $query, $readPreference);
						foreach($cursor as $index => $doc) {
							$ip = $doc -> ip;
							$port = $doc -> port;
							//協定
							$name = $doc -> name;
							//服務
							$pro = $doc -> product;
							//版本
							$ver = $doc -> version;
							//詳細資訊
							$exinfo = $doc -> extrainfo;
							if (preg_match("/$ip_temp[$ip_temp_num]/i", "$ip")) {										
									array_push($content_temp, $port);
									array_push($content_temp, $name);
									array_push($content_temp, $pro);
									array_push($content_temp, $ver);
									array_push($content_temp, $exinfo);
									printf("<tr>");
									printf("<td>%s</td>", $port);
									printf("<td>%s</td>", $name);
									printf("<td>%s %s</td>", $pro, $ver);
									printf("<td>%s</td>", $exinfo);
									printf("</tr>");
									//printf("port ： %s | 協定 : %s | 服務 : %s %s | 詳細資訊 : %s",$port,$name,$pro,$ver,$exinfo);
									//printf("</br>");
							}		
						}
						printf("</tbody></thead></table>");						
						printf("<table class='table table-bordered'><thead class='thead-light'><tr>");
						printf("<th scope='col'>漏洞編號</th><th scope='col'>掃描結果</th><th scope='col'>掃描時間</th>");
						printf("</tr><tbody>");
						for ($i = 0 ; $i < 3 ; $i++) {
							$vuln = $vuln_name[$i];
							printf("<tr><td>%s</td>",$vuln);
							if ($cursor3[$ip_temp_num]['vuln'][$vuln]['hack'] == '1'){
								printf("<td>OK</td>");
							}else {
								printf("<td>NO</td>");
							}
							printf("<td>%s</td>", $cursor3[$ip_temp_num]['vuln'][$vuln]['time_man']);
						}					
						printf("</tr></tbody></thead></table></div>");
						$ip_temp_num++;
						$ip_num++;
					}
-->
			</div>
	  </div>
	</div>
    <script src="../assets/js/jquery.min.js"></script>
    <script src="../assets/js/bootstrap.min.js"></script>
    <script src="../assets/js/popper.min.js"></script>
</body>
<footer>
</footer>
</html>	  
