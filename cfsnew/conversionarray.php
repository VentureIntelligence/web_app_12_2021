<?php
include "header.php";
include "sessauth.php";
$yearcurrency=array();
$currvatype=array('75.3675337409','69.2813479208','65.1365861653','64.8589085866','66.17526015','62.335530796','60.0593486709','54.2849998474','50.8699989319','44.4','44.9747584839','50.861443474','40.022','43.5898132023','44.535','71.2921527817','69.6049200418','63.8499066326','67.9669','66.2013798142','63.1889610935','61.859004615','54.8509728363','53.0600413817','44.7000007629','46.41','48.5800658634','39.37','44.25','71.2921527817','69.6049200418','63.8499066326','67.9669','66.2013798142','63.1889610935','61.859004615','54.8509728363','53.0600413817','44.7000007629','46.41','48.5800658634','39.37','44.25','75.5252545624','68.9494955653','68.4749073223','64.6175469794','67.5184820083','63.601650706','60.0771666411','59.5260009766','55.625','44.5999984742','46.4099998474','47.8905513061','42.92','40.7498828823','45.9538307587','75.5252545624','68.9494955653','68.4749073223','64.6175469794','67.5184820083','63.601650706','60.0771666411','59.5260009766','55.625','44.5999984742','46.4099998474','47.8905513061','42.92','40.7498828823','45.9538307587','75.5252545624','68.9494955653','68.4749073223','64.6175469794','67.5184820083','63.601650706','60.0771666411','59.5260009766','55.625','44.5999984742','46.4099998474','47.8905513061','42.92','40.7498828823','45.9538307587','71.2921527817','69.6049200418','63.8499066326','67.9669','66.2013798142','63.1889610935','61.859004615','54.8509728363','53.0600413817','44.7000007629','46.41','48.5800658634','39.37','44.25','71.2921527817','69.6049200418','63.8499066326','67.9669','66.2013798142','63.1889610935','61.859004615','54.8509728363','53.0600413817','44.7000007629','46.41','48.5800658634','39.37','44.25','71.2921527817','69.6049200418','63.8499066326','67.9669','66.2013798142','63.1889610935','61.859004615','54.8509728363','53.0600413817','44.7000007629','46.41','48.5800658634','39.37','44.25','71.2921527817','69.6049200418','63.8499066326','67.9669','66.2013798142','63.1889610935','61.859004615','54.8509728363','53.0600413817','44.7000007629','46.41','48.5800658634','39.37','44.25','68.9494955653','68.4749073223','64.6175469794','67.5184820083','63.601650706','60.0771666411','59.5260009766','55.625','44.5999984742','46.4099998474','47.8905513061','42.92','40.7498828823','45.9538307587','68.9494955653','68.4749073223','64.6175469794','67.5184820083','63.601650706','60.0771666411','59.5260009766','55.625','44.5999984742','46.4099998474','47.8905513061','42.92','40.7498828823','45.9538307587');
$fyvalue=array('20','19','18','17','16','15','14','13','12','11','10','09','08','07','06','20__311219','19__311218','18__311217','17__311216','16__311215','15__311214','14__311213','13__311212','12__311211','11__311210','10__311209','09__311208','08__311207','07__311206','20_311219','19_311218','18_311217','17_311216','16_311215','15_311214','14_311213','13_311212','12_311211','11_311210','10_311209','09_311208','08_311207','07_311206','20__300620','19__300619','18__300618','17__300617','16__300616','15__300615','14__300614','13__300613','12__300612','11__300611','10__300610','09__300609','08__300608','07__300607','06__300606','20_300620','19_300619','18_300618','17_300617','16_300616','15_300615','14_300614','13_300613','12_300612','11_300611','10_300610','09_300609','08_300608','07_300607','06_300606','20_30062020','19_30062019','18_30062018','17_30062017','16_30062016','15_30062015','14_30062014','13_30062013','12_30062012','11_30062011','10_30062010','09_30062009','08_30062008','07_30062007','06_30062006','20__301119','19__301118','18__301117','17__301116','16__301115','15__301114','14__301113','13__301112','12__301111','11__301110','10__301109','09__301108','08__301107','07__301106','19__31122019','18__31122018','17__31122017','16__31122016','15__31122015','14__31122014','13__31122013','12__31122012','11__31122011','10__31122010','09__31122009','08__31122008','07__31122007','06__31122006','19_311219','18_311218','17_311217','16_311216','15_311215','14_311214','13_311213','12_311212','11_311211','10_311210','09_311209','08_311208','07_311207','06_311206','19_31122019','18_31122018','17_31122017','16_31122016','15_31122015','14_31122014','13_31122013','12_31122012','11_31122011','10_31122010','09_31122009','08_31122008','07_31122007','06_31122006','20__300619','19__300618','18__300617','17__300616','16__300615','15__300614','14__300613','13__300612','12__300611','11__300610','10__300609','09__300608','08__300607','07__300606','20_300619','19_300618','18_300617','17_300616','16_300615','15_300614','14_300613','13_300612','12_300611','11_300610','10_300609','09_300608','08_300607','07_300606');
$yearcurrency=array_combine($fyvalue,$currvatype);
//print_r($yearcurrency);
?>
