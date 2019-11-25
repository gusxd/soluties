<!-- <!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>Portal</title>
    <link rel="stylesheet" href="login.css">
</head>

<body>
 -->
<?php        
    
    session_start();
    $user=$_POST["login"];
    $key=$_POST["senha"];
    $_SESSION['user']= $user;
    $_SESSION['senha']= $key;


    function verificaSenha($login,$senha){
        $user = "gustavo.pereira"; 
        $password = "000562"; 
        $database = "cli_xtrategie"; 
         
        # O hostname deve ser sempre localhost 
        $hostname = "aws.xtrategie.com.br"; 
         
        # Conecta com o servidor de banco de dados 
        $con=mysqli_connect( $hostname, $user, $password, $database) or die( ' Erro na conexão ' ); 
        
        $query = "SELECT * from xv_login";
        
        $result= mysqli_query($con, $query);
        
        $array= array();
        
        if(mysqli_num_rows($result) > 0){
            while($row = mysqli_fetch_assoc($result)){
                $array[] = $row;
            }
        }

        for($i=0; $i<mysqli_num_rows($result); $i++){
            if($login==$array[$i][user_email] && $senha==$array[$i][user_senha]){
                $er[$i]='true';
            }else{
                $er[$i]='false';
            }
        }

        if(in_array('true', $er)) {
            return true;
        }else{
            return false;    
        }
    }

    error_reporting(0);

    if(verificaSenha($_SESSION['user'], $_SESSION['senha']) == true) {
        $headers = array(
            "Content-Type: application/json",
            "SIG: a813293a2e4e4590288cc3042180a53221c1ff92",
            "TeamID: 51664"
        );
        $url = "https://slemma.com/api/v1/users";
        // Cria o cURL
        $curl = curl_init();
        // Seta algumas opções
        curl_setopt_array($curl, [
            CURLOPT_HTTPHEADER => $headers,
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_URL => $url
        ]);
        // Envia a requisição e salva a resposta
        $response = curl_exec($curl);


        if (curl_errno($curl)) { 
            print "Error: " . curl_error($curl);
        } else {
            // Fecha a requisição e limpa a memória
            curl_close($curl);
            $response = json_decode($response, true);
            foreach ($response as $key => $value) {
                //echo $value['Email'] . "<br>";
                //echo $value['FirstName'] . "<br>";
                //echo $value['LastName'] . "<br>";
                //echo $value['Role'] . "<br>";
                //echo $value['Token'] . "<br>";
                $email[$key][0]=$value['Email'];
                $email[$key][1]=$value['SIG'];
            }

            
                if(in_array($_SESSION['user'], array_column($email, 0))){
                    for ($i = 0; $i <count($email) ; $i++) {
                        if(($email[$i][0]==$_SESSION['user'])==1){
                            $sig=$email[$i][1];
                            $_SESSION['sig'] = $sig;
                        }  
                    }
                    $err=true;
                }else{
                    $err=false;
                }


            if($err==false){
                $msg_nc='<h1 style="color:white;font-size: initial;">Usuário não cadastrado no sistema!</h1>';
                echo $msg_nc;
                require_once('login.php');
            }else{
                header("Location: portal.php");
            }


        }
    }else {
        $msg_err='<h1 style="color:white;font-size: initial;">Login ou senha incorretos!</h1>';
        echo $msg_err;
        require_once('login.php');
    }
            
    


    
    ?>


<!-- 
</body>
</html> -->