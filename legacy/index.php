<?

include "db.config.php";
include "htmls/Example.inc_html";

$connection = new dbconection();
$connection->dbRead();

echo strpos("banana", "na");
echo strrev ("banana");
