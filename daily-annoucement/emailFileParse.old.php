<?php

//see http://php.net/manual/en/ for info

$filePath = "normal-email-exampleformatting.txt"; 		//file path, format is c:\\folder\freeMoney.txt.bat
$rawDataDelimiter = "\n";					//what to use to cut one string out from another into diff. rows
								//i.e. if we see the string HELLO.I.AM.SEXY and
								//we use "." as the delimiter, the array will be
								//["HELLO","I","AM","SEXY"]
								
$rawData = file_get_contents($filePath); 	//sets the var $rawData to ALL of the data in $filePath

$rawData = trim($rawData); 	//takes whitespace out from before+after string
				//you can also use 
				//$he = trim("lol.hello.lol","lo.");
				//to get back "he", for example.
				//it trims until it gets a char it can't trim and then stops. )

$rawDataArray = explode($rawDataDelimiter,$rawData); 	//format is (what to use for a new row,what string)
							//this makes an array with new strings for each newline char

////
//after this I need to cycle through ALL of the strings in the array
//and then find the ones containing the tags that are crap
//and set up the php to later those strings
//have them deleted
//after useless info is deleted, take out tags from useful strings
//and then take ALL of the array
//and make it into one string
////

function array_change_key(&$array,$old_key,$new_key)
{
	$array[$new_key] = $array[$old_key];
	unset($array[$old_key]);
	return;
}

function array_tag_keys($array,$keyTagStringArray,$tagString)
{
	$keyTagStringArrayColNum = 0;
	$arrayColNum = 0;
	
	for($n = 0; $n <= count($array); $n++)
	{
		for($s = 0; $s <= count($keyTagStringArray); $s++)
		{
			if(strpos($array($arrayColNum),$keyTagStringArray($keyTagStringArrayColNum)))
			{
				array_change_key($array,$arrayColNum,$tagString + $arrayColNum);
			}
			else
			{
				end;
			}
			
		$keyTagStringArrayColNum = $keyTagStringArrayColNum + 1; //<--	//so when we check again
		}							 //we check for a new string
									 //in the $array
	$arrayColNum = $arrayColNum + 1; //so that we check a new col in the
	$keyTagStringArrayColNum = 0;	 //whole array and also reset the col
					 //to use for the strings to check
	}				 
}


$numRawDataArray = count($rawDataArray);
$arrayColSelect = 0;

//////////////////////////////////////
         /////CAUTION!!!!/////
//PHP does not use quotes to define a string, but rather, an apostraphe.
//Quotes (" as opposed to ') are used INSIDE the string. Por ejemplo (For example), from the PHP Website...
//// //Outputs: Arnold once said: "I'll be back"
//// echo 'Arnold once said: "I\'ll be back"';
//Reference this, as I cannot tell you how much this error gets to me. 
$arrayUselessWords = array[
		'Delivered-To:',
		'X-Recieved:',
		'Return-Path:',
		'Recieved-SPF:',
		'Authentication-Results:',
		'X-Google-DKIM-Signature:',
		'X-BeenThere:',
		'MIME-Version:',
		'X-Goomoji-Body:',
		'Message-ID:',
		'To:',
		'Bcc:',
		'X-Gm-Message-State:',
		'X-Original-Sender:',
		'X-Original-Authentication-Results:',
		'Precedence:',
		'Mailing-list:',
		'List-ID:',
		'X-Google-Group-Id:',
		'List-Post:',
		'List-Help:',
		'List-Archive:',
		'List-Unsubscribe:'
		]; //put useless words here, that's all
		// Just as a point of reference, all this stuff is what is sent through the SMTP server.
		// For our purposes, we will be skipping over this SOLELY BECAUSE users want the data.


/*
for($n = 0; $n <= $numRawDataArray; $n++) //execute the inside code for $numRawDataArray times
{
	for($whatParse = 0; $whatParse <= count($arrayUselessWords); $whatParse++) 	//cycles thru all of
	{										//the words in the
											//arrayuseless array
											//for count(arrayuseless) times

		if(strpos($rawDataArray($ArrayColSelect),$arrayUselessWords($whatParse)) === true) 	//if the string in the selected col of
													//the plaintext rawdata array
		{											//has the array string
			end;										//that corresponds to that col
		}
		else
		{
			array_change_key($rawDataArray, $arrayColSelect, "D" + $arrayColSelect); //'tagging' with D
		}
	} 					//this is outside because we want to select a different
	$arrayColSelect = $arrayColSelect + 1;	//array col ONLY AFTER all the words are done being parsed
}						//in that specific array col
*/


/////
///
///  also here's a listing of all of the email tags I could find that define stuff
/// X is for arbitrary info, O is for useful information, - is for mixed usefulness.
///
//X 'Delivered-To: ' //email it was delivered to
///
//- 'Recieved: ' // what IP recieved the mail and when
///
//- 'X-Received: ' //functionally the same as recieved. I find this useful sicne it tells whether the data server got this successfully or not. However, you never now.
///
//X 'Return-Path: ' //no clue, useless though.
///
//X 'Recieved-SPF: ' //is sender legit or not
///
//X 'Authentication-Results: ' //who says they're legit. Only reason we would use this, I could think, would be for ALL THE HACKS by others here.
///
//X 'X-Google-DKIM-Signature: ' //google sig/metadata, useless
///
//X 'X-BeenThere: ' //who got it and forwarded it
///
//X 'MIME-Version: ' //duh
///
//O 'From: ' //duh
///
//X 'X-Goomoji-Body: ' //are google emoticons enabled
///
//O 'Date: ' //duh 
///
//X 'Message-ID: ' //duh
///
//O 'Subject-ID: ' //subject field
///
//- 'To: ' //who it's sent to other than recipient. Could be useful in terms of groups. Otherwise, public access deems it not needed. 
///
//X 'Bcc: ' //who the bcc is sent to
///
//X 'X-Gm-Message-State: ' //useless
///
//X 'X-Original-Sender: ' //who sent the first instance of the email
///
//X 'X-Original-Authentication-Results: ' //was the first email legit + results
///
//X 'Precedence: ' //useless
///
//X 'Mailing-list: ' //useless
///
//X 'List-ID: ' //useless
///
//- 'X-Google-Group-Id: ' //Needed for colloquium grouping and, for that matter, advisories and other items.
///
//X 'List-Post: ' //useless
///
//X 'List-Help: ' //useless
///
//X 'List-Archive: ' //useless
///
//X 'List-Unsubscribe: ' //useless
///
//O 'Content-Type: ' //very useful for finding when content begins (right after this!!!)
///


?>
