#! /usr/bin/env php
<?php
define("SEMAPD","/var/log/uecs/semaphore");
define("INITFILE","/usr/local/etc/chkuecs.conf");

$ini_d = parse_ini_file(INITFILE,true);

foreach($ini_d as $ahost) {
    $tfile = SEMAPD."/".$ahost['ip'].".semap";
    $dfile = SEMAPD."/".$ahost['ip'].".chk";
    if (is_file($tfile)) {
        if (!is_file($dfile)) {
            touch($dfile);
            $txt = sprintf("Communication down %s(%s)\n",$ahost['location'],$ahost['ip']);
            $subj = sprintf("ERROR %s",$ahost['location']);
            send_mail($ahost['mailto'],$subj,$txt);
            print($subj);
        }
    } else {
        if (is_file($dfile)) {
            $txt = sprintf("Communication recover %s(%s)\n",$ahost['location'],$ahost['ip']);
            $subj = sprintf("RECOVER %s",$ahost['location']);
            send_mail($ahost['mailto'],$subj,$txt);
            unlink($dfile);
            print($subj);
        }
        touch($tfile);
    }
}

function send_mail($to,$subject,$txt) {
    $message = "check now\n".$txt;
    $addhead = array(
	    'From' => 'UECS Status check by Qwelzo <horimoto@ys-lab.tech>',
     'Replay-To' => 'horimoto@holly-linux.com',
     'Errors-To' => 'horimoto@holly-linux.com',
     'X-Mailer'  => 'chkuecs/1.00'
    );
    mail($to,$subject,$message,$addhead);
}

?>
