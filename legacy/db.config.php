<?
class dbconection{
    var $dbJobs=0;
    var $Host="database";
    var $User="root";
    var $User_r="root";
    var $User_w="root";
    var $Pass="jobsnepal";
    var $Port="3306";
    var $Pass_r="jobsnepal";
    var $Pass_w="jobsnepal";
    var $DB="jn1x";

    function dbRead(){
        // $this->dbJobs = new PDO("mysql:host=$this->Host;port=3308;dbname=$this->DB", $this->User, $this->User_r);
        $this->dbJobs = mysql_connect("$this->Host:$this->Port", $this->User, $this->Pass_r);
         if (!$this->dbJobs):
            die("Unable to connect to SQL server". mysql_error());
        endif;
        if (!mysql_select_db($this->DB)):
            die("Unable to select database");
        endif;

        mysql_select_db($this->DB);
    }


    function dbWrite(){
        $this->dbJobs=mysql_connect($this->Host,$this->User_w,$this->Pass_w);
        if (!$this->dbJobs):
            die("Unable to connect to SQL server");
        endif;
        if (!mysql_select_db($this->DB)):
            die("Unable to select database");
        endif;

        mysql_select_db($this->DB);

    }


    function dbReadWrite(){
        $this->dbJobs=mysql_connect($this->Host,$this->User,$this->Pass);
        if (!$this->dbJobs):
            die("Unable to connect to SQL server");
        endif;
        if (!mysql_select_db($this->DB)):
            die("Unable to select database");
        endif;

        mysql_select_db($this->DB);

    }



    var $Line1;
    var $Line2;
    var $Line3;

    function dbconection(){
        //$this->Line1=implode('',file('/usr/local/www/docs/alsop/thegana.inc'));
        //$this->Line2=implode('',file('/usr/local/www/docs/alsop/talcha.inc'));
        // $this->Line3=implode('',file('/usr/local/www/docs/alsop/chaabi.inc'));

    }

    var $DirPath="/usr/local/www/docs/jobsnepal/";
    var $ConnectionID=0;


    //FTP Connection
    function FTPConnect(){
        $this->ConnectionID = ftp_connect("$this->Line1");
        $login_result = ftp_login($this->ConnectionID, "$this->Line2", "$this->Line3");
        if ((!$this->ConnectionID) || (!$login_result)):
            die ("FTP Connection Failed");
        endif;
        return $this->ConnectionID;
    }

    //Upload
    function FTPImageUpload($img,$imgName,$imgDir){
        //set temporary upload directory
        $TempDir="/var/tmp/php";
        //Set Image directory
        $ImageDir=$this->DirPath.$imgDir;
        //set temporary upload file name
        $TempImageName=tempnam($TempDir, "AAP");
        //move uploaded file to temporary name
        move_uploaded_file($img,$TempImageName);
        chmod ($TempImageName, 0644);

        //upload to real directory
        $ImageFile="$ImageDir/$imgName";
        @ftp_put($this->ConnectionID, "$ImageFile", "$TempImageName", FTP_BINARY);

        //delete temporary upload file
        unlink($TempImageName);
    }


    //Image Move
    function FTPImageMove($img,$imgName,$imgDir){
        //Set Image directory
        $ImageDir=$this->DirPath.$imgDir;
        //set temporary upload file name
        $TempImageName=$this->DirPath."temp_pic/$img";
        //upload to real directory
        $ImageFile="$ImageDir/$imgName";
        ftp_put($this->ConnectionID, "$ImageFile", "$TempImageName", FTP_BINARY);
        //delete temporary upload file
        ftp_delete($this->ConnectionID,"$TempImageName");
    }


    //Delete
    function FTPImageDelete($imgFile,$imgDir){
        //delete referred uploaded file
        $imgDir=$this->DirPath.$imgDir;
        @ftp_delete($this->ConnectionID,"$imgDir/$imgFile");
    }

    //File Move
    function FTPFileMove($FileText, $DestinationName, $DestinationDir){
        //set temporary upload directory
        $TempDir="/var/tmp/php";
        $DestinationDir=$this->DirPath.$DestinationDir;
        //set temporary upload file name
        $TempFileName=tempnam($TempDir, "AAP");
        $fp=fopen($TempFileName,'w');
        fwrite($fp,$FileText);
        fclose($fp);
        //upload to real directory
        $DestinationFile="$DestinationDir/$DestinationName";
        @ftp_put($this->ConnectionID, "$DestinationFile", "$TempFileName", FTP_BINARY);
        //delete temporary upload file
        unlink($TempFileName);
    }


    function FTPQuit(){
        ftp_quit($this->ConnectionID);
    }


}
?>
