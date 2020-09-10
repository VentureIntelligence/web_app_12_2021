<?php


if (isset($_POST['search'])) {
    $search = urlencode($_POST['search']);
} else {
    echo 'Unauthorized Access';
    exit;
}



if(isset($_REQUEST['companysearch'])){
/*
    $url = "https://api.angel.co/1/search?query=$search&type=Startup&access_token=5688a487422775f0f973d1cfc636d74ceeeeac76fca1c534&token_type=bearer";
   // $url = "https://api.angel.co/1/tags/1647/startups?access_token=5688a487422775f0f973d1cfc636d74ceeeeac76fca1c534&token_type=bearer&type=startup";
    $json = file_get_contents($url);
    $result = json_decode($json);
    
    
    if(count($result)==0){
        
    $url = "https://api.angel.co/1/search/slugs?query=$search&type=Startup&access_token=5688a487422775f0f973d1cfc636d74ceeeeac76fca1c534&token_type=bearer";
   // $url = "https://api.angel.co/1/tags/1647/startups?access_token=5688a487422775f0f973d1cfc636d74ceeeeac76fca1c534&token_type=bearer&type=startup";
    $json = file_get_contents($url);
    $result = json_decode($json);  

    }
*/
    
    
        $url ="https://api.angel.co/1/search?query=$search&type=Startup&access_token=5688a487422775f0f973d1cfc636d74ceeeeac76fca1c534&token_type=bearer";
        
        $ch = curl_init(); 
        // set url 
        curl_setopt($ch, CURLOPT_URL,$url); 
        //return the transfer as a string 
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        // $output contains the output string 
        $result = curl_exec($ch); 
        // close curl resource to free up system resources 
        curl_close($ch);
        $result = json_decode($result);
        
        
        if(count($result)==0){
        $url ="https://api.angel.co/1/search/slugs?query=$search&type=Startup&access_token=5688a487422775f0f973d1cfc636d74ceeeeac76fca1c534&token_type=bearer";
        
        $ch = curl_init(); 
        // set url 
        curl_setopt($ch, CURLOPT_URL,$url); 
        //return the transfer as a string 
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        // $output contains the output string 
        $result = curl_exec($ch); 
        // close curl resource to free up system resources 
        curl_close($ch);
        $result = json_decode($result);
        
        $slugs=1;
        }
        
        
        
        
        
    if(count($result)>0){
        
            $html = '<br> <table border="1" style="font-family: Arial; font-size:12px ; border-collapse: collapse" cellpadding="10"> 
                    <tr> <th>Id</th>  <th>Name</th>    <th>Type</th>    <th>Angel.co url</th>  
                    </tr>';
            
            
        if(count($result)==1 && $slugs==1){
            $co=$result;
                    $html .= '<tr>';
                    $html .= '<td> <label> <input type="radio" class="angelcomp" name="angelcomp" value="'.$co->id.'"> ' .$co->id. '  </label> </td>';
                    $html .= '<td> ' .$co->name. '</td>';
                    $html .= '<td> ' .$co->type. '</td>';
                    $html .= '<td> <a href="'.$co->url.'" target="_blank"> ' .$co->url. '</a></td>';
                    $html .= '</tr>';
            
        }else if(count($result)>0){    
                foreach ($result as $co) {

                    $html .= '<tr>';
                    $html .= '<td> <label> <input type="radio" class="angelcomp" name="angelcomp" value="'.$co->id.'"> ' .$co->id. '  </label> </td>';
                    $html .= '<td> ' .$co->name. '</td>';
                    $html .= '<td> ' .$co->type. '</td>';
                    $html .= '<td> <a href="'.$co->url.'" target="_blank"> ' .$co->url. '</a></td>';
                    $html .= '</tr>';

                }
        }
        $html .='</table>';
        
        echo $html;
        
        
    }
    else {
        echo 0;
    }

exit;

}




if(isset($_REQUEST['investorsearch'])){

    /*
    $url = "https://api.angel.co/1/search?query=$search&type=User&access_token=5688a487422775f0f973d1cfc636d74ceeeeac76fca1c534&token_type=bearer";
   // $url = "https://api.angel.co/1/tags/1647/startups?access_token=5688a487422775f0f973d1cfc636d74ceeeeac76fca1c534&token_type=bearer&type=startup";
    $json = file_get_contents($url);
    $result = json_decode($json);
*/
    
        $url ="https://api.angel.co/1/search?query=$search&type=User&access_token=5688a487422775f0f973d1cfc636d74ceeeeac76fca1c534&token_type=bearer";
        
        $ch = curl_init(); 
        // set url 
        curl_setopt($ch, CURLOPT_URL,$url); 
        //return the transfer as a string 
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        // $output contains the output string 
        $result = curl_exec($ch); 
        // close curl resource to free up system resources 
        curl_close($ch);
        $result = json_decode($result);
        
        
        if(count($result)==0){
        $url ="https://api.angel.co/1/search/slugs?query=$search&type=User&access_token=5688a487422775f0f973d1cfc636d74ceeeeac76fca1c534&token_type=bearer";
        
        $ch = curl_init(); 
        // set url 
        curl_setopt($ch, CURLOPT_URL,$url); 
        //return the transfer as a string 
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        // $output contains the output string 
        $result = curl_exec($ch); 
        // close curl resource to free up system resources 
        curl_close($ch);
        $result = json_decode($result);
        
        $slugs=1;
        }
        
       
         
        
        
    
    if(count($result)>0){
        
            $html = '<br> <table border="1" style="font-family: Arial; font-size:12px ; border-collapse: collapse" cellpadding="10"> 
                    <tr> <th>Id</th>  <th>Name</th>    <th>Type</th>    <th>Angel.co url</th>  
                    </tr>';

        if(count($result)==1 && $slugs==1){
            $co=$result;
                    $html .= '<tr>';
                    $html .= '<td> <label> <input type="radio" class="angelcomp" name="angelcomp" value="'.$co->id.'"> ' .$co->id. '  </label> </td>';
                    $html .= '<td> ' .$co->name. '</td>';
                    $html .= '<td> ' .$co->type. '</td>';
                    $html .= '<td> <a href="'.$co->url.'" target="_blank"> ' .$co->url. '</a></td>';
                    $html .= '</tr>';
            
        }else if(count($result)>0){  
            foreach ($result as $co) {

            $html .= '<tr>';
            $html .= '<td> <label> <input type="radio" class="angelcomp" name="angelcomp" value="'.$co->id.'"> ' .$co->id. '  </label> </td>';
            $html .= '<td> ' .$co->name. '</td>';
            $html .= '<td> ' .$co->type. '</td>';
            $html .= '<td> <a href="'.$co->url.'" target="_blank"> ' .$co->url. '</a></td>';
            $html .= '</tr>';

            }
        }
        
        $html .='</table>';
        
        echo $html;
        
        
    }
    else {
        echo 0;
    }

exit;

}



?>