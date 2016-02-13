<?php
	//error_reporting(E_ALL);
	error_reporting(0);

	mysql_connect("localhost","root","nsjsd") or die("Error connecting to database");
	mysql_select_db("eve_route") or die("Error selecting database");


	$from = strtoupper($_GET['from']);//$_GET['from'];
	$to = strtoupper($_GET['to']);

	if ($from && $to) {
		function microtime_float()
		{
			list($usec, $sec) = explode(" ", microtime());
			return ((float)$usec + (float)$sec);
		}
	
		function graph_find_path( &$G, $A, $B, $M = 50000 )
		{
		  // $P will hold the result path at the end.
		  // Remains empty if no path was found.
		  $P = array();

		  // For each Node ID create a "visit information",
		  // initially set as 0 (meaning not yet visited)
		  // as soon as we visit a node we will tag it with the "source"
		  // so we can track the path when we reach the search target

		  $V = array();

		  // We are going to keep a list of nodes that are "within reach",
		  // initially this list will only contain the start node,
		  // then gradually expand (almost like a flood fill)
		  $R = array( trim($A) );

		  $A = trim($A);
		  $B = trim($B);

		  while ( count( $R ) > 0 && $M > 0 )
		  {

			$M–;
			$X = trim(array_shift( $R ));

			foreach( $G[$X] as $Y )
			{
			  $Y = trim($Y);
			  // See if we got a solution
			  if ( $Y == $B )
			  {
				// We did? Construct a result path then
				array_push( $P, $B );
				array_push( $P, $X );
				while ( $V[$X] != $A )
				{
				   array_push( $P, trim($V[$X]) );
				   $X = $V[$X];
				}
				array_push( $P, $A );
				return array_reverse( $P );
			  }
			  // First time we visit this node?
			  if ( !array_key_exists($Y, $V) )
			  {
				// Store the path so we can track it back,
				$V[$Y] = $X;
				// and add it to the "within reach" list
				array_push( $R, $Y );
			  }
			}
		  }

		  return $P;
		}

		$time_start = microtime_float();

		//Database structure:
		//	E_systems
		//		regionId 	constellationId 	systemName 	systemId 	jumpNodes			security
		//		(INT)		(INT)			(CHAR)		(INT)		(CHAR, Jump1:Jump2:Ju..)	(CHAR)

		//Declare arrays to hold Solar System data
		//
		//Structure :
		//	$nameArray : (ARRAY[ID] = NAME)
		//	$jumpArray : (ARRAY[NAME] = ARRAY[JUMPS])
		//  $idArray   : (ARRAY[NAME] = ID)

		$nameArray = array();
		$jumpArray = array();
		$idArray = array();

		//Populate $jumpArray

		$query="SELECT * FROM e_systems";
		$result=mysql_query($query);

		$previousSystem = "";
		$arrayContent = "";

		while ($row=mysql_fetch_row($result)) {
			$regionId = trim($row[0]);
			$constId = trim($row[1]);
			$systemName = strtoupper(trim($row[2]));
			$systemId = trim($row[3]);
			$secStatus = trim($row[5]);

			$nameArray[$systemId][0] = $systemName;
			$nameArray[$systemId][1] = $regionId;
			$nameArray[$systemId][2] = $constId;
			$nameArray[$systemId][3] = $secStatus;

			$idArray[strtoupper($systemName)] = $systemId;

			$jumpArray[$systemName]= explode(":", strtoupper($row[4]));
			array_push($jumpArray[$systemName],$systemId);
		}

		header("Content-type: text/xml");
		$xml_output  = "<?xml version=\"1.0\"?>\n\t<jump_route>\n";

		$jumpNum = 1;

		foreach( $jumpArray[$from] as $n ) {
			if ($n == $to) {
				$jumpNum = 2;
				$xml_output_body = "\t<jump>\n";
				$xml_output_body .= "\t\t<system>$to</system>\n";
				$xml_output_body .= "\t</jump>\n";
				break;
			}
		}

		if ($jumpNum == 1) {
			foreach( graph_find_path( $jumpArray, $from, $to ) as $n ) {
				if ($jumpNum > 1) {
					$xml_output_body .= "\t<jump>\n";
					$xml_output_body .= "\t\t<system>" . $n . "</system>\n";
					$xml_output_body .= "\t\t<security>" . $nameArray[$idArray[$n]][3] . "</security>\n";
					$xml_output_body .= "\t</jump>\n";
				}
				$jumpNum++;
			}
		}
		if ($jumpNum > 1) {
			$xml_output_body = "\t<route_possible>true</route_possible>\n\t<jump>\n\t\t<system>$from</system>\n\t\t<security>" . $nameArray[$idArray[$from]][3] . "</security>\n\t</jump>\n" . $xml_output_body;
		} else {
			$xml_output_body = "\t<route_possible>false</route_possible>\n" . $xml_output_body;
		}
		$time_end = microtime_float();
		$time = round($time_end - $time_start,5);

		$xml_output_body .= "\t<jump_count>" . ($jumpNum-1) . "</jump_count>\n";
		$xml_output_body .= "\t<exec_time>$time" . "s</exec_time>\n";
		$xml_output_body .= "</jump_route>";
		echo $xml_output . $xml_output_body;
		//Display execution time
	} else {
		echo "<html><body>Usage: eve_route.php?from=&lt;origin&gt;&to=&lt;destination&gt;<br/><br/>Output: XML file, containing list of jumps, begining with origin. If no route is possible, then output will be NULL.</body></html>";
	}
?> 