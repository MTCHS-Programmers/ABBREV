<?php
	$sql = ($_POST["query"] == "" ? "SELECT `Shrt_Desc`, `Water_(g)` FROM `ABBREV` WHERE `Shrt_Desc` LIKE \"CHEESE,%\" ORDER BY `Protein_(g)` ASC" : $_POST["query"]);
	$data = query($sql, "compSci")["rows"];
	$endData = array(array());
	
	foreach(array_keys($data[0]) as $key) {
		array_push($endData[0], $key);
	}
	foreach($data as $row) {
		$temp = array();

		foreach($row as $attr) {
			$attrVal = (preg_match("/[A-Z]+/", $attr) ? $attr : intval($attr));
			array_push($temp, $attrVal);
		}
		array_push($endData, $temp);
	}
	
	echo "<!--" . json_encode($endData, JSON_PRETTY_PRINT) . "-->";
?>

<link rel="stylesheet" type="text/css" href="src/css/style.css">

<script type="text/javascript"
          src="https://www.google.com/jsapi?autoload={
            'modules':[{
              'name':'visualization',
              'version':'1',
              'packages':['corechart']
            }]
          }"></script>

    <script type="text/javascript">
      google.setOnLoadCallback(drawChart);

      function drawChart() {
        var data = google.visualization.arrayToDataTable(<?php echo json_encode($endData); ?>);

        var options = {
          title: 'Test',
          curveType: 'function',
          legend: { position: 'bottom' }
        };

        var chart = new google.visualization.ColumnChart(document.getElementById('curve_chart'));

        chart.draw(data, options);
      }
    </script>
    <div id="curve_chart" style="width: 900px; height: 500px"></div>
	
	<form method="post">
		<textarea id="query" name="query" style="width: 100%; min-height: 150px"><?php echo $sql; ?></textarea>
		<input type="submit" />
	</form>