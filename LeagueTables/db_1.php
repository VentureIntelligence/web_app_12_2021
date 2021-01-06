<?php include_once("../globalconfig.php"); ?>
<?php
$con=mysql_connect("localhost","venture_leag_dev","Leaguetable_Dev123");
mysql_select_db("venture_leaguetable_dev") or die ("DB selection error");
// Check connection
if (!$con)
  {
  echo "Failed to connect to MySQL: ";
  }
  define('BASE_URL','https://www.ventureintelligence.com/');
/*  mysql_query("CREATE TABLE IF NOT EXISTS `industry` (
  `id` int(7) NOT NULL AUTO_INCREMENT,
  `industry` tinytext NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM
)") or die ("error Industry");

mysql_query("CREATE TABLE IF NOT EXISTS `league_table_data` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `advisor_name` tinytext NOT NULL,
  `deal` tinytext NOT NULL,
  `amount` varchar(20) NOT NULL,
  `industry` tinytext NOT NULL,
  `sector` tinytext NOT NULL,
  `date` date NOT NULL,
  `deal_type` varchar(200) NOT NULL,
  `points` int(20) NOT NULL,
  `advisor_type` varchar(200) NOT NULL,
  `notable` varchar(5) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM
)") or die ("error league data");

mysql_query("CREATE TABLE IF NOT EXISTS `sector` (
  `id` int(7) NOT NULL AUTO_INCREMENT,
  `industry_id` int(7) NOT NULL,
  `sector` tinytext NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM
)") or die ("error sector");  */   

?>
