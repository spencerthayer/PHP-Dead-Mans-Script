<?php

require_once('globals.php');

function sendMsg($toAddress,$msgFile) {
        $msgText = file_get_contents($msgFile);
        if (file_exists(globals::footerFile)) {
                $msgText = $msgText.file_get_contents(globals::footerFile);
        };
        $subject = globals::subjectPrefix.basename($msgFile);
        $fromAddress = 'From: '.globals::mailFrom;
        mail($toAddress,$subject,$msgText,$fromAddress);
};

function getDay() {
      if (file_exists(globals::dataFile)) {
                $dataFile=file(globals::dataFile);
                $dayNum=$dataFile[0];
        } else {
                $dayNum = 0;
        };
        return (intval($dayNum,10)+1);
};

function writeDay($dayNum) {
      $fp=fopen(globals::dataFile,"w");
        fputs($fp,$dayNum);
        fclose($fp);
};

function getToken() {

        if (file_exists(globals::tokenFile)) {
	        $token=file(globals::tokenFile);
	} else {
		$token[0]=0;
	};
	
        return(intval($token[0],10));
};

function randomizeToken() {
        $fp=fopen(globals::tokenFile,'w');
        fputs($fp,rand(1048576,134217728));
        fclose($fp);
};

function resetDayNum() {
        $fp=fopen(globals::dataFile,'w');
        fputs($fp,'0');
	fclose($fp);
};

?>