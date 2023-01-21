<? require("header.html") ; ?>
<?php
	// ACL Matching Calculator - John Wilson  - Brighton Feb 2010 
	// I wrote this as a test tool - prior to writting a Java Mobile version.
	// You can see from the 'require' statements you need two extra files
	
	// HTML 'header' file (header.html) - with your website name etc.
	// and a 'footer' HTML file (footer.html).
	 
	// Any bugs, suggestions - please email john66@talk21.com

	// Define Globals 1st
	
	$Constant_ZeroBit_Colour 	= "#FF0000" ;
	$Constant_SetBit_Colour 	= "#FF0000" ;
	$Constant_DontCare_Colour	= "#000080" ;
	
	$Constant_Binary_Colour		= "#800000" ;
	$Constant_Denary_Colour		= "#000080" ;
	
	// HTML Form Functions
	
	
	// Navigation Button 
	function showHomeButton($buttontext,$homepage)
	{
		print("<form name='input' action='$homepage' method='get'>") ;
		print("<input type='submit' value='$buttontext' />") ;
		print("</form>") ;
	}

	// Input Form for Sample IP and Wild Card Mask
	function showOctetForm($ipoctet1,$ipoctet2,$ipoctet3,$ipoctet4,$mskoctet1,$mskoctet2,$mskoctet3,$mskoctet4)
	{
		print("<form name='input' action='acl.php' method='get'>") ;

		print("<p>IPADD:<input type='text' value='$ipoctet1' name='ipoctet1' />") ;
		print("<input type='text'  value='$ipoctet2' name='ipoctet2' />") ;
		print("<input type='text'  value='$ipoctet3' name='ipoctet3' />") ;
		print("<input type='text'  value='$ipoctet4' name='ipoctet4' /></p>") ;

		print("<p>MASK:<input type='text' value='$mskoctet1' name='mskoctet1' />") ;
		print("<input type='text' value='$mskoctet2' name='mskoctet2' />") ;
		print("<input type='text' value='$mskoctet3' name='mskoctet3' />") ;
		print("<input type='text' value='$mskoctet4' name='mskoctet4' /></p>") ;
		
		print("<input type='submit' name='command' value='match' />") ;
		print("</form>") ;
	}

	// Display Helpers - 
	
	function outputbinary($label,$octet1,$octet2,$octet3,$octet4) 
	{
		printf("<p>$label:<b>%08b.%08b.%08b.%08b</b></p>",$octet1,$octet2,$octet3,$octet4) ;
	}
	
	
	// Generate Don't Care Masks from 8 bit wildcard mask and sample octet values
	// Used for Display purposes only. It is NOT used to calculate ACL MATCHING.
	
	function generateDontCareMask($sampleoctet,$mskoctet)
	{
		$dcm = str_split(sprintf("%08b",$mskoctet)) ;
		$sbin = str_split(sprintf("%08b",$sampleoctet)) ;
		
		// Go through our mask octect - if we see a binary 0 use the corresponding bit
		// from the sample octet - otherwise it's a binary 1 - a 'don't care' bit - which
		// we replace with an 'X'
		
		for($idx = 0 ; $idx < 8 ; $idx++) {
			if ($dcm[$idx] == '1') {
				$dcm[$idx] = 'X' ;
			} else {
				$dcm[$idx] = $sbin[$idx] ;
			}
		}	
		return implode($dcm) ;
	}
	
	function colourMaskIn($maskvalue,$offcolour,$oncolour,$dontcarecolour) {
		// Takes a 'dont care mask' string (produced by generateDontCareMask Function)
		// and surrounds those bits with various HTML tagged font colours 

		// **Warning** FONT tags are Deprecated - Use Styles!
		
		// ...this looks awfully messy!!
		$col= preg_replace('([X10])',"C\\0",$maskvalue) ;

		$col = preg_replace("(C0)",sprintf("<font color='%s'>0</font>",$offcolour),$col) ;
		$col = preg_replace("(C1)",sprintf("<font color='%s'>1</font>",$oncolour),$col) ;
		$col = preg_replace("(CX)",sprintf("<font color='%s'>X</font>",$dontcarecolour),$col) ;
		
		return $col ;
		
	}



	// ACL Matching Calculation consist of one simple function ... easy!
	
//	function matchOctet2($mskoctet,$ipoctet,$testoctet) {
//		// ~maskoctet & testoctet == ipoctet
//		return (((255-$mskoctet) & $testoctet) == $ipoctet) ;
//	}

// This function to be used if Sample Bits override don't care bits
//	function matchOctet3($mskoctet,$ipoctet,$testoctet) {
//		$nmsk = (255-(($mskoctet ^ $ipoctet) & $mskoctet))  ;
//		return (($nmsk & $testoctet) == $ipoctet) ;
//	}


	//
	// This is the most important function!
	// Calculates if the testoctect macthes the ip and wildcard mask octet.
	// The Wildcard Mask bits override any bits set in the ipoctet.
	// eg   ip = 0011 and mask octet of X00X  gives a result of X01X (X='Don't care bit')
	// (Nb: 255 - msk is equiv to ~ 1 bit (bitwise) compliment for an 8 bit value)
	function matchOctet($mskoctet,$ipoctet,$testoctet) {
		return (((255-$mskoctet) & $testoctet) == (($ipoctet & $mskoctet) ^ $ipoctet)) ;
	}
	
	
	// Our Main Code Starts Here - Get URL parameters (if any),
	// type cast to 'int', cos leaving them
	// as strings causes BIG problems - (Bug in PHP? !!!)

	if (isset($_GET{ipoctet1})) {
		$ipoctet1 = (int)$_GET{ipoctet1} ;
	}

	if (isset($_GET{ipoctet2})) {
		$ipoctet2 = (int)$_GET{ipoctet2} ;
	}

	if (isset($_GET{ipoctet3})) {
		$ipoctet3 = (int)$_GET{ipoctet3} ;
	}

	if (isset($_GET{ipoctet4})) {
		$ipoctet4 = (int)$_GET{ipoctet4} ;
	}

	if (isset($_GET{mskoctet1})) {
		$mskoctet1 = (int)$_GET{mskoctet1} ;
	}

	if (isset($_GET{mskoctet2})) {
		$mskoctet2 = (int)$_GET{mskoctet2} ;
	}

	if (isset($_GET{mskoctet3})) {
		$mskoctet3 = (int)$_GET{mskoctet3} ;
	}

	if (isset($_GET{mskoctet4})) {
		$mskoctet4 = (int)$_GET{mskoctet4} ;
		
	}

	
	print("<p><b>Johnny's ACL Matching Calculator.(includes non host ips) IS STILL UNDER TESTING! PLEASE REPORT PROBLEMS TO john66@talk21.com</b></p>") ;
	
	// Warning !!! The HTML generated uses Deprecated FONT tags!! Create a Style sheet!
	
	// Go Home Button - replace with your own button text and welcome page -
	//showHomeButton("BACK","index.html") ;
	
	// Octet Input Form
	showOctetForm($ipoctet1,$ipoctet2,$ipoctet3,$ipoctet4,$mskoctet1,$mskoctet2,$mskoctet3,$mskoctet4) ;

	if (isset($_GET{command})) {
		$command = $_GET{command} ;
		if ($command == "match") 
		{
			outputbinary("IPADD",$ipoctet1,$ipoctet2,$ipoctet3,$ipoctet4) ;
			outputbinary("MASK",$mskoctet1,$mskoctet2,$mskoctet3,$mskoctet4) ;
			printf("<p>GENERATOR MASK =  %s.%s.%s.%s ('X' are the don't care bits)</p>",
			colourMaskIn(generateDontCareMask($ipoctet1,$mskoctet1),$GLOBALS{Constant_ZeroBit_Colour},$GLOBALS{Constant_SetBit_Colour},$GLOBALS{Constant_DontCare_Colour}),
			colourMaskIn(generateDontCareMask($ipoctet2,$mskoctet2),$GLOBALS{Constant_ZeroBit_Colour},$GLOBALS{Constant_SetBit_Colour},$GLOBALS{Constant_DontCare_Colour}),
			colourMaskIn(generateDontCareMask($ipoctet3,$mskoctet3),$GLOBALS{Constant_ZeroBit_Colour},$GLOBALS{Constant_SetBit_Colour},$GLOBALS{Constant_DontCare_Colour}),
			colourMaskIn(generateDontCareMask($ipoctet4,$mskoctet4),$GLOBALS{Constant_ZeroBit_Colour},$GLOBALS{Constant_SetBit_Colour},$GLOBALS{Constant_DontCare_Colour})
			) ;
			
			print("<div align = 'center'>") ;
			
 			print("<table border='1'>") ;
			print("<caption>Results</caption>") ;
			
			print("<tr><th>IP Denary</th><th>IP Binary</th></tr>") ;
			$counter = 0 ;
			
			// Brute Force - Go through all combinations - starting with the top most octet
			
			for($input1 = 0; $input1 < 256; $input1++) {
				if (matchOctet($mskoctet1,$ipoctet1,$input1)) {
						for($input2 = 0 ; $input2 < 256 ; $input2++) {
							if (matchOctet($mskoctet2,$ipoctet2,$input2)) {
								for($input3 = 0 ; $input3 < 256 ; $input3++) {
									if (matchOctet($mskoctet3,$ipoctet3,$input3)) {
										for($input4 = 0 ; $input4 < 256 ; $input4++) {
											if (matchOctet($mskoctet4,$ipoctet4,$input4)) {
												// We Found One!
												// Warning !!! Uses Deprecated FONT tags!! Create a Style sheet!
												printf("<tr><td><font color='%s'>%d.%d.%d.%d</font></td>",$GLOBALS{Constant_Denary_Colour},$input1,$input2,$input3,$input4) ;
												printf("<td><b><font color='%s'>%08b.%08b.%08b.%08b<font></b></td></tr>",$GLOBALS{Constant_Binary_Colour},$input1,$input2,$input3,$input4) ;
												$counter++ ;
											}
										}
									}
								}
							}
						}
				}
			}
			print("</table>") ;
			print("<p><b>$counter matches found.</b></p>") ;
			print("</div>") ;
			
		}
	}
	//showHomeButton("BACK","index.html") ;
?>
<? require("footer.html") ; ?>


