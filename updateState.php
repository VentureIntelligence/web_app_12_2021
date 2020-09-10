<?php
require( "dbconnectvi.php" );
$Db = new dbInvestments();
$Db->dbInvestments();

$file = fopen( "cprofile.csv","r" );
while( !feof( $file ) ) {
   $exCin = fgetcsv( $file );
   $cinArrays[] = array( 'cin' => $exCin[ 0 ], 'state' => $exCin[ 1 ] );
}
foreach( $cinArrays as $key => $cinArray ) {
   if( $key != 0 ) {
      if( !empty( $cinArray[ 'cin' ] ) ) {
         $update = "UPDATE cprofile SET State = " . $cinArray[ 'state' ] . " WHERE Company_Id = " . $cinArray[ 'cin' ];
         mysql_query( $update ) or die( mysql_error() );   
      }
   }
}
//$update = "UPDATE cprofile SET State = " . $cinArray[ 'state' ] . " WHERE Company_Id = " . $cinArray[ 'cin' ];
fclose( $file );

?>
