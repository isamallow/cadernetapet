<?php



/*

$var="User', email='test";
$a=new PDO("mysql:host=localhost;dbname=database;","root","");
$b=  $a->prepare("UPDATE `users` SET user=:var");
$b->bindParam(":var",$var);
$b->execute();


*/

//HOST ONLINE
//$servername = "localhost"; //ou host ou hostname

//HOST LOCAL
$servername = "localhost"; //ou host ou hostname
$dbname = "cadernetapet_db";
$username = "timetopetecano";
$password = "SenhaDobanco";  




// Get dos names do formulario e guardar em variaveis para enviar por insert no banco
// Por segurança os names dos forms não sao os mesmos das colunas do banco para não ficar expostas a estrutura do banco
#OBS  o @  na frente das variávies é pra quando ela não receber um valor não dar pau.

// endereco_tb
@$cep = $_POST ["cep"]; 
@$tipo_logradouro = $_POST ["tipo-de-logradouro"];
@$logradouro = $_POST ["logradouro"]; 
@$num_logradouro = $_POST ["numero-logradouro"]; 
@$complemento = $_POST ["complemento"]; 
@$referencia = $_POST ["referencia"]; 
@$bairro = $_POST ["bairro"]; 
@$cidade = $_POST ["cidade"]; 
@$uf = $_POST ["estado"]; 

// pessoa_fisica_tb
@$num_cpf = $_POST ["cpf"]; 
@$data_nasc = $_POST ["nascimento"];
@$nome_civil = $_POST ["nome"]; 
@$nome_social = $_POST ["nome-social"]; 
@$pseudonimo = $_POST ["apelido"]; 
@$sexo_biologico = $_POST ["sexo"]; 
@$genero = $_POST ["identidade-de-genero"]; 
@$email = $_POST ["e-mail"]; 
@$num_tel_celular = $_POST ["celular"]; 
@$num_whatsapp = $_POST ["whatsapp"]; 
@$num_tel_fixo = $_POST ["telefone"]; 
@$username_login = $_POST ["usuario"]; 
@$password_login = $_POST ["senha"]; 


//LIMPA AS MASCARAS DAS VARIAVEIS NAME DO FORM

/*
function cleanCPF($num_cpf){
$num_cpf = preg_replace('/[^0-9]/', '', $num_cpf);
   return $num_cpf;
}


$chars = array(“(“,”)”,” “,”-“,”-“);  

$celular = str_replace($chars,””,$telefone);

//str_ireplace()  ireplase para case insensitive

*/






// Criar a conexão no Banco de dados
$conn = new mysqli($servername, $username, $password, $dbname);


// Checar a conexão com o banco de dados Apenas habilitamos quando em DEBUG
/*
if ($conn->connect_error) {
  die("<br><hr><strong>DEU RUIM - Banco não foi conectado:</strong><hr><br><br>" . $conn->connect_error);
}
echo "<br><hr><strong>OK - BANCO DE DADOS MYSQL CONECTADO COM SUCESSO</strong><hr><br><br>";
*/

$sql =
      "
        INSERT INTO
          endereco_tb (
                        id_endereco,
                        cep,
                        tipo_logradouro,
                        logradouro,
                        num_logradouro,
                        complemento,
                        referencia,
                        bairro,
                        cidade,
                        uf
                      )
        VALUES (
                  @@IDENTITY,
                  '$cep',
                  '$tipo_logradouro',
                  '$logradouro',
                   $num_logradouro,
                  '$complemento',
                  '$referencia',
                  '$bairro',
                  '$cidade',
                  '$uf'
                );
      "

;

$sql .=
        "
          INSERT INTO
            pessoa_fisica_tb (
                                id_pessoa_fisica,                  
                                id_endereco,                  
                                num_cpf,
                                data_nasc,
                                nome_civil,
                                nome_social,
                                pseudonimo,
                                sexo_biologico,
                                genero,
                                email,
                                num_tel_celular,
                                num_whatsapp,
                                num_tel_fixo,
                                username_login,
                                password_login
                              ) 
            VALUES (
                       @@IDENTITY,
                       @@IDENTITY,
                       '$num_cpf',
                       '$data_nasc',
                       '$nome_civil',
                       '$nome_social',
                       '$pseudonimo',
                       '$sexo_biologico',
                       '$genero',
                       '$email',
                       '$num_tel_celular',
                       '$num_whatsapp',
                       '$num_tel_fixo',
                       '$username_login',
                       MD5('$password_login')
                      
                    ); 
        "
;

if ($conn->multi_query($sql) === TRUE) {
  echo
  
    '
    <!DOCTYPE html>
    <html>
    <head>
	<style type="text/css">

		.cad-ok {
			text-align: center;
		}
	
		.cadastro-ok {
			text-align: center;
			margin: 20px;
			padding: 20px;
			}
		 p .cadastro-ok {
			text-align: center;
			}
		</style>
	
    <title>Cadastro realizado com sucesso. Caderneta PET.</title>
    </head>
    <body>
     <div class="cad-ok"><img class="cadastro-ok" src="./img/cadastro-ok.png" /></p>
    </html>
    
  '
    
  
  ;




} else {
  echo "Ocorreu um Erro: Não foi possível cadastrar seus dados, volte e tente novamernte, cheque os dados inseridos no formulário: " . $sql . "<br>" . $conn->error;
}

$conn->close();

?>